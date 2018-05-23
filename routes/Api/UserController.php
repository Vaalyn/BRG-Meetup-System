<?php

namespace Routes\Api;

use Carbon\Carbon;
use Exception\InfoException;
use Model\Manager\UserModelManager;
use Model\RecoveryCode;
use Model\User;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController {
	/**
	 * @var \Psr\Container\ContainerInterface
	 */
	protected $container;

	/**
	 * @param \Psr\Container\ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function createUserAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$username       = $request->getParsedBody()['username'] ?? '';
		$password       = $request->getParsedBody()['password'] ?? '';
		$email          = $request->getParsedBody()['email'] ?? '';
		$firstName      = $request->getParsedBody()['first_name'] ?? '';
		$lastName       = $request->getParsedBody()['last_name'] ?? '';
		$birthday       = $request->getParsedBody()['birthday'] ?? '';
		$genderId       = (int) $request->getParsedBody()['gender_id'] ?? 0;
		$recaptchaToken = $request->getParsedBody()['g-recaptcha-response'] ?? '';

		try {
			$recaptcha         = new \ReCaptcha\ReCaptcha($this->container->config['recaptcha']['secret']);
			$recaptchaResponse = $recaptcha->verify($recaptchaToken, $request->getAttribute('ip_address'));

			if (!$recaptchaResponse->isSuccess()) {
			    throw new InfoException('reCAPTCHA konnte nicht verifiziert werden');
			}

			$userModelManager = new UserModelManager(
				$this->container->auth,
				$this->container->config['meetupDate']
			);

			$userModelManager->createUser(
				$username,
				$password,
				$email,
				$firstName,
				$lastName,
				$birthday,
				$genderId
			);

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Account wurde erstellt'
			)));
		}
		catch (InfoException $exception) {
			return $response->write(json_encode(array(
				'status' => 'error',
				'errors' => $exception->getMessage()
			)));
		}
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function updateUserAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$passwordOld = $request->getParsedBody()['password_old'] ?? '';
		$passwordNew = $request->getParsedBody()['password_new'] ?? '';

		try {
			$userModelManager = new UserModelManager(
				$this->container->auth,
				$this->container->config['meetupDate']
			);

			$user = $this->container->auth->user();

			$userModelManager->updateUser($user->user_id, $passwordOld, $passwordNew);

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Benutzer wurde aktualisiert'
			)));
		}
		catch (InfoException $exception) {
			return $response->write(json_encode(array(
				'status' => 'error',
				'errors' => $exception->getMessage()
			)));
		}
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function forgotPasswordAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$username = $request->getParsedBody()['username'] ?? '';
		$email    = $request->getParsedBody()['email'] ?? '';

		try {
			$user = User::where([
				['username', '=', $username],
				['email', '=', $email]
			])->first();

			if (!isset($user)) {
				throw new InfoException('Kein Benutzer mit diesem Usernamen für die E-Mail Addresse gefunden');
			}

			$code = Uuid::uuid4();

			$recoveryCode          = new RecoveryCode();
			$recoveryCode->user_id = $user->user_id;
			$recoveryCode->code    = password_hash($code, PASSWORD_DEFAULT);
			$recoveryCode->save();

			if ($recoveryCode->recovery_code_id === null) {
				throw new InfoException('Passwort Reset Code konnte nicht generiert werden');
			}

			$passwordResetUrl = sprintf(
				'%s://%s%s%s',
				$request->getUri()->getScheme(),
				$request->getUri()->getHost(),
				$this->container->router->pathFor('password-reset', ['code' => null]),
				$code
			);

			$passwordResetEmailMessage = $this->container->renderer->fetch(
				'/mailer/user/reset-password/reset-password.php',
				[
					'passwordResetUrl' => $passwordResetUrl
				]
			);

			try {
				$this->container->mailer->sendMail(
					'BRG-Meetup Website Passwort vergessen',
					$email,
					$user->username,
					$passwordResetEmailMessage
				);
			} catch (\Exception\MailNotSendException $exception) {
				$recoveryCode->delete();
				throw new InfoException('E-Mail konnte nicht gesendet werden');
			}

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'E-Mail zum Passwort zurücksetzen versendet'
			)));
		}
		catch (InfoException $exception) {
			return $response->write(json_encode(array(
				'status' => 'error',
				'errors' => $exception->getMessage()
			)));
		}
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function resetPasswordAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$code     = $request->getParsedBody()['code'] ?? '';
		$password = $request->getParsedBody()['password'] ?? '';

		try {
			$userModelManager = new UserModelManager(
				$this->container->auth,
				$this->container->config['meetupDate']
			);
			$userModelManager->validatePassword($password);

			$codeValidFromDateTime = Carbon::now()->subHours(6);
			$validRecoveryCodes = RecoveryCode::whereDate(
				'created_at',
				'>=',
				$codeValidFromDateTime->toDateString()
			)->get();

			$validRecoveryCode = null;

			foreach ($validRecoveryCodes as $recoveryCode) {
				if (password_verify($code, $recoveryCode->code)) {
					$validRecoveryCode = $recoveryCode;
				}
			}

			if (!isset($validRecoveryCode)) {
				throw new InfoException('Ungültiger code');
			}

			$recoveryCode->user->password = password_hash($password, PASSWORD_DEFAULT);
			$recoveryCode->user->save();

			$recoveryCode->delete();

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Passwort wurde geändert'
			)));
		}
		catch (InfoException $exception) {
			return $response->write(json_encode(array(
				'status' => 'error',
				'errors' => $exception->getMessage()
			)));
		}
	}
}
