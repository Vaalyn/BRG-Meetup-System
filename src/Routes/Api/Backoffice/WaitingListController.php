<?php

namespace BronyRadioGermany\Meetup\Routes\Api\Backoffice;

use BronyRadioGermany\Meetup\Model\WaitingList;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class WaitingListController {
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
	public function deleteWaitingListEntryAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$waitingListEntry = WaitingList::where('waiting_list_id', '=', $id);

		if (!$waitingListEntry->exists()) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Kein Eintrag gefunden'
			)));
		}

		$waitingListEntry->delete();

		return $response->write(json_encode(array(
			'status' => 'success',
			'message' => 'Wartelisteneintrag wurde gelöscht'
		)));
	}
}
