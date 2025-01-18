<?php

namespace BronyRadioGermany\Meetup\Model\Manager;

use BronyRadioGermany\Meetup\Exception\InfoException;
use BronyRadioGermany\Meetup\Model\Gender;
use BronyRadioGermany\Meetup\Model\User;
use BronyRadioGermany\Meetup\Model\UserInfo;
use BronyRadioGermany\Meetup\Service\Auth\AuthInterface;
use Respect\Validation\Validator;

class UserInfoModelManager {
	/**
	 * @var \BronyRadioGermany\Meetup\Service\Auth\AuthInterface
	 */
	protected $auth;

	/**
	 * @var string
	 */
	protected $meetupDate;

	/**
	 * @param \BronyRadioGermany\Meetup\Service\Auth\AuthInterface $auth
	 * @param string $meetupDate
	 */
	public function __construct(AuthInterface $auth, string $meetupDate) {
		$this->auth       = $auth;
		$this->meetupDate = $meetupDate;
	}

	/**
	 * @param \BronyRadioGermany\Meetup\Model\User $user
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $birthday
	 * @param int $genderId
	 *
	 * @return \BronyRadioGermany\Meetup\Model\UserInfo
	 */
	public function createUserInfo(
		User $user,
		string $firstName,
		string $lastName,
		string $birthday,
		int $genderId
	): UserInfo {
		if (!isset($user->user_id)) {
			throw new InfoException('Unbekannter Benutzer');
		}

		$this->validateUserInfo(
			$firstName,
			$lastName,
			$birthday,
			$genderId
		);

		$userInfo             = new UserInfo();
		$userInfo->user_id    = $user->user_id;
		$userInfo->first_name = trim($firstName);
		$userInfo->last_name  = trim($lastName);
		$userInfo->birthday   = $birthday;
		$userInfo->gender_id  = $genderId;
		$userInfo->save();

		if ($userInfo->user_info_id === null) {
			throw new InfoException('Account konnte nicht erstellt werden');
		}

		return $userInfo;
	}

	/**
	 * @param \BronyRadioGermany\Meetup\Model\User $user
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $birthday
	 * @param int $genderId
	 *
	 * @return \BronyRadioGermany\Meetup\Model\UserInfo
	 */
	public function updateUserInfo(
		User $user,
		string $firstName,
		string $lastName,
		string $birthday,
		int $genderId
	): UserInfo {
		if ($user->user_id !== $this->auth->user()->user_id) {
			throw new InfoException('Du darfst nur deinen eigenen Benutzer bearbeiten');
		}

		$this->validateUserInfo(
			$firstName,
			$lastName,
			$birthday,
			$genderId
		);

		$user->userInfo->user_id    = $user->user_id;
		$user->userInfo->first_name = trim($firstName);
		$user->userInfo->last_name  = trim($lastName);
		$user->userInfo->birthday   = $birthday;
		$user->userInfo->gender_id  = $genderId;
		$user->userInfo->save();

		return $user->userInfo;
	}

	/**
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $birthday
	 * @param int $genderId
	 *
	 * @return void
	 */
	public function validateUserInfo(
		string $firstName,
		string $lastName,
		string $birthday,
		int $genderId
	): void {
		if (trim($firstName) === '') {
			throw new InfoException('Es muss eine Vorname eingegeben werden');
		}

		if (trim($lastName) === '') {
			throw new InfoException('Es muss eine Nachname eingegeben werden');
		}

		if (!Validator::date('Y-m-d')->validate($birthday)) {
			var_dump($birthday);
			die();
			throw new InfoException('Ungültiges Format für Geburtsdatum');
		}

		if (!$this->isUserSixteenOnMeetup($birthday)) {
			throw new InfoException('Du musst zum Start des Meetups 16 Jahre alt sein');
		}

		if (!Gender::where('gender_id', '=', $genderId)->exists()) {
			throw new InfoException('Unbekanntes Geschlecht');
		}
	}

	/**
	 * @param string $birthday
	 *
	 * @return bool
	 */
	public function isUserSixteenOnMeetup(string $birthday): bool {
		return $this->isYearsAgoOnMeetup($birthday, 16);
	}

	/**
	 * @param string $birthday
	 *
	 * @return bool
	 */
	public function isUserEighteenOnMeetup(string $birthday): bool {
		return $this->isYearsAgoOnMeetup($birthday, 18);
	}

	/**
	 * @param string $datetime
	 * @param int $years
	 *
	 * @return bool
	 */
	protected function isYearsAgoOnMeetup(string $datetime, int $years): bool {
		$birthdayDateTime                 = \DateTime::createFromFormat('Y-m-d', $datetime);
		$meetupDateTime                   = \DateTime::createFromFormat('Y-m-d', $this->meetupDate);
		$timeToMeetupInterval             = $meetupDateTime->diff(new \DateTime());
		$birthdayWithMeetupDateDifference = $birthdayDateTime->sub($timeToMeetupInterval);

		return Validator::age($years)->validate($birthdayWithMeetupDateDifference);
	}
}
