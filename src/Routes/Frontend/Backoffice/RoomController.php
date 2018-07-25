<?php

namespace BronyRadioGermany\Meetup\Routes\Frontend\Backoffice;

use BronyRadioGermany\Meetup\Model\Room;
use BronyRadioGermany\Meetup\Model\RoomType;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class RoomController {
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
		$roomTypes = RoomType::get();
		$rooms     = Room::get();

		return $this->container->renderer->render($response, '/backoffice/room/room.php', [
			'request' => $request,
			'response' => $response,
			'database' => $this->container->database,
			'auth' => $this->container->auth,
			'flashMessages' => $this->container->flash->getMessages(),
			'pageTitle' => 'Zimmerverwaltung',
			'roomTypes' => $roomTypes,
			'rooms' => $rooms
		]);
	}
}
