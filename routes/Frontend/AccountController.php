<?php
	namespace Routes\Frontend;

	use Model\Gender;
	use Psr\Container\ContainerInterface;
	use Slim\Http\Request;
	use Slim\Http\Response;

	class AccountController {
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
			return $this->container->renderer->render($response, '/account/account.php', [
				'request' => $request,
				'response' => $response,
				'database' => $this->container->database,
				'auth' => $this->container->auth,
				'flashMessages' => $this->container->flash->getMessages(),
				'pageTitle' => 'Account',
				'user' => $this->container->auth->user(),
				'genders' => Gender::get()
			]);
		}
	}
?>
