<?php

namespace BronyRadioGermany\Meetup\Routes\Api;

use BronyRadioGermany\Meetup\Exception\InfoException;
use BronyRadioGermany\Meetup\Model\Manager\WaitingListModelManager;
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
	public function addWaitingListEntryAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$username = $request->getParsedBody()['username'] ?? '';
		$email    = $request->getParsedBody()['email'] ?? '';
		$notice   = $request->getParsedBody()['notice'] ?? '';

		try {
			$waitingListModelManager = new WaitingListModelManager();
			$waitingListModelManager->createEntry($username, $email, $notice);

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Eintrag wurde hinzugefügt'
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
