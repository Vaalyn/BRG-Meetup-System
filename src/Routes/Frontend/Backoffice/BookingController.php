<?php

namespace BronyRadioGermany\Meetup\Routes\Frontend\Backoffice;

use BronyRadioGermany\Meetup\Model\Booking;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class BookingController {
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
		$bookings = Booking::join('user', 'booking.user_id', '=', 'user.user_id')
			->orderBy('username')
			->get();

		return $this->container->renderer->render($response, '/backoffice/booking/booking.php', [
			'request' => $request,
			'response' => $response,
			'database' => $this->container->database,
			'auth' => $this->container->auth,
			'flashMessages' => $this->container->flash->getMessages(),
			'pageTitle' => 'Buchungen',
			'bookings' => $bookings
		]);
	}
}
