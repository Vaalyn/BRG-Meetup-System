<?php

namespace BronyRadioGermany\Meetup\Routes\Frontend;

use BronyRadioGermany\Meetup\Model\Gender;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class RegistrationController {
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
		if ($this->container->auth->check()) {
			return $response->withRedirect($this->container->router->pathFor('booking'));
		}

		return $this->container->renderer->render($response, '/registration/registration.php', [
			'request' => $request,
			'response' => $response,
			'database' => $this->container->database,
			'auth' => $this->container->auth,
			'flashMessages' => $this->container->flash->getMessages(),
			'pageTitle' => 'Registrierung',
			'genders' => Gender::get(),
			'recaptchaKey' => $this->container->config['recaptcha']['key']
		]);
	}
}
