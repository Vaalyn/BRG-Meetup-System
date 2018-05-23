<?php

namespace Routes\Frontend\Backoffice;

use Model\WaitingList;
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
	public function __invoke(Request $request, Response $response, array $args): Response {
		$waitingListEntries = WaitingList::orderBy('created_at', 'DESC')->get();

		return $this->container->renderer->render($response, '/backoffice/waiting-list/waiting-list.php', [
			'request' => $request,
			'response' => $response,
			'database' => $this->container->database,
			'auth' => $this->container->auth,
			'flashMessages' => $this->container->flash->getMessages(),
			'pageTitle' => 'Warteliste',
			'waitingListEntries' => $waitingListEntries
		]);
	}
}
