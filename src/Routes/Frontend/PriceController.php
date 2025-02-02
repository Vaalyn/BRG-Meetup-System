<?php

namespace BronyRadioGermany\Meetup\Routes\Frontend;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PriceController {
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
		return $this->container->renderer->render($response, '/price/price.php', [
			'request' => $request,
			'response' => $response,
			'database' => $this->container->database,
			'auth' => $this->container->auth,
			'flashMessages' => $this->container->flash->getMessages(),
			'pageTitle' => 'Teilnahmegebühr',
			'meetupDate' => $this->container->config['meetupDate'],
			'meetupYear' => date('Y', strtotime($this->container->config['meetupDate'])),
			'payment' => $this->container->config['payment']
		]);
	}
}
