<?php

namespace BronyRadioGermany\Meetup\Service\Mailer;

use BronyRadioGermany\Meetup\Exception\InvalidMailArgumentException;
use BronyRadioGermany\Meetup\Exception\InvalidMailerConfigurationException;
use BronyRadioGermany\Meetup\Exception\MailNotSendException;
use Respect\Validation\Validator;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport\Smtp\Auth\CramMd5Authenticator;
use Symfony\Component\Mailer\Transport\Smtp\Auth\LoginAuthenticator;
use Symfony\Component\Mailer\Transport\Smtp\Auth\PlainAuthenticator;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class Mailer implements MailerInterface {
	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @param array $config
	 *
	 * @throws \BronyRadioGermany\Meetup\Exception\InvalidMailerConfigurationException
	 */
	public function __construct(array $config) {
		$this->config = $config;

		$this->validateConfig();
	}

	/**
	 * @param string $subject
	 * @param string $toEmail
	 * @param string $toName
	 * @param string $message
	 * @param bool $isHtmlMessage
	 *
	 * @return void
	 *
	 * @throws \BronyRadioGermany\Meetup\Exception\MailNotSendException
	 */
	public function sendMail(string $subject, string $toEmail, string $toName, string $message, bool $isHtmlMessage = true): void {
		$this->validateMailArguments($subject, $toEmail);

		$email = (new Email())
			->subject($subject)
			->from(new Address($this->config['fromAddress'], $this->config['from']))
			->to(new Address($toEmail, $toName));

		if ($isHtmlMessage) {
			$email->html($message);
		} else {
			$email->text($message);
		}

		try {
			$this->createTransport()->send($email);
		} catch (TransportExceptionInterface $exception) {
			throw new MailNotSendException(
				sprintf(
					'Mail could not be send to "%s": %s',
					$toEmail,
					$exception->getMessage()
				),
				0,
				$exception
			);
		}
	}

	/**
	 * @return EsmtpTransport
	 */
	protected function createTransport(): EsmtpTransport {
		return $this->buildSmtpTransport(
			$this->config['username'],
			$this->config['password'],
			$this->config['host'],
			$this->config['port'],
			$this->config['security'],
			$this->config['authMode']
		);
	}

	/**
	 * @param string $username
	 * @param string $password
	 * @param string $host
	 * @param int $port
	 * @param ?string $security
	 * @param ?string $authMode
	 *
	 * @return EsmtpTransport
	 */
	protected function buildSmtpTransport(
		string $username,
		string $password,
		string $host,
		int $port,
		?string $security,
		?string $authMode
	): EsmtpTransport {
		$smtpTransport = new EsmtpTransport($host, $port, $security === 'ssl');
		$smtpTransport->setRequireTls($security === 'tls');
		$smtpTransport->setUsername($username);
		$smtpTransport->setPassword($password);

		$authenticator = match ($authMode) {
			'plain' => new PlainAuthenticator(),
			'login' => new LoginAuthenticator(),
			'cram-md5' => new CramMd5Authenticator(),
			null => null,
		};

		if ($authenticator !== null) {
			$smtpTransport->setAuthenticators([$authenticator]);
		}

		return $smtpTransport;
	}

	/**
	 * @return void
	 *
	 * @throws \BronyRadioGermany\Meetup\Exception\InvalidMailerConfigurationException
	 */
	protected function validateConfig(): void {
		if (!Validator::email()->validate($this->config['fromAddress'])) {
			throw new InvalidMailerConfigurationException(
				sprintf(
					'From address "%s" is an invalid e-mail address',
					$this->config['fromAddress']
				)
			);
		}

		if ($this->config['username'] === '') {
			throw new InvalidMailerConfigurationException('Empty username given');
		}

		if ($this->config['password'] === '') {
			throw new InvalidMailerConfigurationException('Empty password given');
		}

		if ($this->config['host'] === '') {
			throw new InvalidMailerConfigurationException('Empty host given');
		}

		if (!is_int($this->config['port'])) {
			throw new InvalidMailerConfigurationException(
				sprintf(
					'Invalid port "%s" must be an integer',
					$this->config['port']
				)
			);
		}

		if (!in_array($this->config['security'], [null, 'ssl', 'tls'])) {
			throw new InvalidMailerConfigurationException(
				sprintf(
					'Unkown security setting "%s"',
					$this->config['security']
				)
			);
		}

		if (!in_array($this->config['authMode'], [null, 'plain', 'login', 'cram-md5'])) {
			throw new InvalidMailerConfigurationException(
				sprintf(
					'Unkown auth mode "%s"',
					$this->config['authMode']
				)
			);
		}
	}

	/**
	 * @param string $subject
	 * @param string $toEmail
	 *
	 * @return void
	 *
	 * @throws \BronyRadioGermany\Meetup\Exception\InvalidMailArgumentException
	 */
	protected function validateMailArguments(string $subject, string $toEmail): void {
		if (trim($subject) === '') {
			throw new InvalidMailArgumentException('The given "subject" is empty');
		}

		if (!Validator::email()->validate($toEmail)) {
			throw new InvalidMailArgumentException(
				sprintf(
					'The given receiver e-mail address "%s" is not a valid e-mail address',
					$toEmail
				)
			);
		}
	}
}
