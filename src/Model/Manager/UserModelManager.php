<?php

namespace BronyRadioGermany\Meetup\Model\Manager;

use BronyRadioGermany\Meetup\Exception\InfoException;
use BronyRadioGermany\Meetup\Model\User;
use BronyRadioGermany\Meetup\Service\Auth\AuthInterface;
use Respect\Validation\Validator;
use ZxcvbnPhp\Zxcvbn;

class UserModelManager {
	/**
	 * @var \BronyRadioGermany\Meetup\Service\Auth\AuthInterface
	 */
	protected $auth;

	/**
	 * @var string
	 */
	protected $meetupDate;

	/**
	 * @var \BronyRadioGermany\Meetup\Model\Manager\UserInfoModelManager
	 */
	protected $userInfoModelManager;

	/**
	 * @param \BronyRadioGermany\Meetup\Service\Auth\AuthInterface $auth
	 * @param string $meetupDate
	 */
	public function __construct(AuthInterface $auth, string $meetupDate) {
		$this->auth       = $auth;
		$this->meetupDate = $meetupDate;

		$this->userInfoModelManager = new UserInfoModelManager($auth, $meetupDate);
	}

	/**
	 * @param string $username
	 * @param string $password
	 * @param string $email
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $birthday
	 * @param int $genderId
	 *
	 * @return \BronyRadioGermany\Meetup\Model\User
	 */
	public function createUser(
		string $username,
		string $password,
		string $email,
		string $firstName,
		string $lastName,
		string $birthday,
		int $genderId
	): User {
		$this->validateUsername($username);
		$this->validatePassword($password);
		$this->validateEmail($email);

		$this->userInfoModelManager->validateUserInfo(
			$firstName,
			$lastName,
			$birthday,
			$genderId
		);

		$user           = new User();
		$user->username = trim($username);
		$user->password = password_hash($password, PASSWORD_DEFAULT);
		$user->is_admin = false;
		$user->email    = trim($email);
		$user->save();

		if ($user->user_id === null) {
			throw new InfoException('Account konnte nicht erstellt werden');
		}

		try {
			$this->userInfoModelManager->createUserInfo(
				$user,
				$firstName,
				$lastName,
				$birthday,
				$genderId
			);
		}
		catch (InfoException $exception) {
			$user->delete();

			throw $exception;
		}

		return $user;
	}

	/**
	 * @param int $id
	 * @param string $passwordOld
	 * @param string $passwordNew
	 *
	 * @return \BronyRadioGermany\Meetup\Model\User
	 */
	public function updateUser(int $id, string $passwordOld, string $passwordNew): User {
		if ($id !== $this->auth->user()->user_id) {
			throw new InfoException('Du darfst nur deinen eigenen Benutzer bearbeiten');
		}

		$user = User::where('user_id', '=', $id)->first();

		if (!isset($user)) {
			throw new InfoException('Es wurde kein Benutzer zu der Id gefunden');
		}

		if (!password_verify($passwordOld, $user->password)) {
			throw new InfoException('Um Änderungen vorzunehmen wird dein aktuelles Passwort benötigt');
		}

		$this->validatePassword($passwordNew);
		$user->password = password_hash($passwordNew, PASSWORD_DEFAULT);

		$user->save();

		return $user;
	}

	/**
	 * @param string $username
	 *
	 * @return void
	 */
	public function validateUsername(string $username): void {
		if (trim($username) === '') {
			throw new InfoException('Es muss ein Benutzername eingegeben werden');
		}

		if (
			User::where('username', '=', $username)->exists() &&
			$username !== $this->auth->user()->username
		) {
			throw new InfoException('Es existiert bereits ein Benutzer mit diesem Namen');
		}
	}

	/**
	 * @param string $password
	 *
	 * @return void
	 */
	public function validatePassword(string $password): void {
		if (trim($password) === '') {
			throw new InfoException('Es muss ein Passwort eingegeben werden');
		}

		if ($this->getPasswordStrength($password) < 2) {
			throw new InfoException('Das Passwort ist zu unsicher');
		}
	}

	/**
	 * @param string $email
	 *
	 * @return void
	 */
	public function validateEmail(string $email): void {
		if (!Validator::email()->validate(trim($email))) {
			throw new InfoException('E-Mail Adresse ist ungültig');
		}

		if (User::where('email', '=', trim($email))->exists()) {
			throw new InfoException('E-Mail Adresse wird bereits verwendet');
		}
	}

	/**
	 * @param string $password
	 * @param array $userData
	 *
	 * @return int
	 */
	protected function getPasswordStrength(string $password, array $userData = []): int {
		$zxcvbn = new Zxcvbn();
		$strength = $zxcvbn->passwordStrength($password, $userData);

		return $strength['score'];
	}
}
