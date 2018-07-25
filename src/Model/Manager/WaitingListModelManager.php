<?php

namespace BronyRadioGermany\Meetup\Model\Manager;

use BronyRadioGermany\Meetup\Exception\InfoException;
use BronyRadioGermany\Meetup\Model\WaitingList;
use Respect\Validation\Validator;

class WaitingListModelManager {
	/**
	 * @param string $username
	 * @param string $email
	 * @param string $notice
	 *
	 * @return \BronyRadioGermany\Meetup\Model\WaitingList
	 */
	public function createEntry(string $username, string $email, string $notice): WaitingList {
		$this->validateEntry($username, $email);

		$entry           = new WaitingList();
		$entry->username = $username;
		$entry->email    = $email;
		$entry->notice   = $notice;
		$entry->save();

		if ($entry->waiting_list_id === null) {
			throw new InfoException('Eintrag konnte nicht erstellt werden');
		}

		return $entry;
	}

	/**
	 * @param string $username
	 * @param string $email
	 *
	 * @return void
	 */
	protected function validateEntry(string $username, string $email): void {
		if (trim($username) === '') {
			throw new InfoException('Es muss eine Username eingegeben werden');
		}

		if (trim($email) === '') {
			throw new InfoException('Es muss eine E-Mail Adresse eingegeben werden');
		}

		if (!Validator::email()->validate(trim($email))) {
			throw new InfoException('E-Mail Adresse ist ungültig');
		}
	}
}
