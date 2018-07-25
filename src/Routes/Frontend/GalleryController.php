<?php

namespace BronyRadioGermany\Meetup\Routes\Frontend;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class GalleryController {
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
		$year = null;
		$images = [];

		if (isset($args['year']) && in_array($args['year'], ['2016', '2017'])) {
			$year = $args['year'];
		}

		return $this->container->renderer->render($response, '/gallery/gallery.php', [
			'request' => $request,
			'response' => $response,
			'database' => $this->container->database,
			'auth' => $this->container->auth,
			'flashMessages' => $this->container->flash->getMessages(),
			'pageTitle' => 'Gallerie',
			'year' => $year,
			'gallery' => $this->container->gallery
		]);
	}
}
