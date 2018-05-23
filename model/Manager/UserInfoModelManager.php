<?php

namespace Model\Manager;

use Exception\InfoException;
use Model\Gender;
use Model\User;
use Model\UserInfo;
use Respect\Validation\Validator;
use Service\Auth\AuthInterface;

class UserInfoModelManager {
	/**
	 * @var \Service\Auth\AuthInterface
	 */
	protected $auth;

	/**
	 * @var string
	 */
	protected $meetupDate;

	/**
	 * @param \Service\Auth\AuthInterface $auth
	 * @param string $meetupDate
	 */
	public function __construct(AuthInterface $auth, string $meetupDate) {
		$this->auth       = $auth;
		$this->meetupDate = $meetupDate;
	}

	/**
	 * @param \Model\User $user
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $birthday
	 * @param int $genderId
	 *
	 * @return \Model\UserInfo
	 */
	public function createUserInfo(
		User $user,
		string $firstName,
		string $lastName,
		string $birthday,
		int $genderId
	): UserInfo {
		$this->validateUserInfo(
			$user,
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
	 * @param \Model\User $user
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $birthday
	 * @param int $genderId
	 *
	 * @return \Model\UserInfo
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
			$user,
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
	 * @param \Model\User $user
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $birthday
	 * @param int $genderId
	 *
	 * @return void
	 */
	private function validateUserInfo(
		User $user,
		string $firstName,
		string $lastName,
		string $birthday,
		int $genderId
	): void {
		if (!isset($user->user_id)) {
			throw new InfoException('Unbekannter Benutzer');
		}

		if (trim($firstName) === '') {
			throw new InfoException('Es muss eine Vorname eingegeben werden');
		}

		if (trim($lastName) === '') {
			throw new InfoException('Es muss eine Nachname eingegeben werden');
		}

		if (!Validator::date('Y-m-d')->validate($birthday)) {
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
	private function isYearsAgoOnMeetup(string $datetime, int $years): bool {
		$birthdayDateTime                 = \DateTime::createFromFormat('Y-m-d', $datetime);
		$meetupDateTime                   = \DateTime::createFromFormat('Y-m-d', $this->meetupDate);
		$timeToMeetupInterval             = $meetupDateTime->diff(new \DateTime());
		$birthdayWithMeetupDateDifference = $birthdayDateTime->sub($timeToMeetupInterval);

		return Validator::age($years)->validate($birthdayWithMeetupDateDifference);
	}
}
