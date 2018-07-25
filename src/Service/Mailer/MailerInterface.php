<?php

namespace BronyRadioGermany\Meetup\Service\Mailer;

interface MailerInterface {
	/**
	 * @param array $config
	 *
	 * @throws \BronyRadioGermany\Meetup\Exception\InvalidMailerConfigurationException
	 */
	public function __construct(array $config);

	/**
	 * @param string $subject
	 * @param string $toEmail
	 * @param string $toName
	 * @param string $message
	 *
	 * @return void
	 *
	 * @throws \BronyRadioGermany\Meetup\Exception\MailNotSendException
	 */
	public function sendMail(string $subject, string $toEmail, string $toName, string $message): void;
}
