<?php
	namespace Routes\Api;

	use Exception\InfoException;
	use Model\Manager\UserInfoModelManager;
	use Psr\Container\ContainerInterface;
	use Slim\Http\Request;
	use Slim\Http\Response;

	class UserInfoController {
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
		public function updateUserInfoAction(Request $request, Response $response, array $args): Response {
			$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

			$firstName = $request->getParsedBody()['first_name'] ?? '';
			$lastName  = $request->getParsedBody()['last_name'] ?? '';
			$birthday  = $request->getParsedBody()['birthday'] ?? '';
			$genderId  = (int) $request->getParsedBody()['gender_id'] ?? 0;

			try {
				$userInfoModelManager = new UserInfoModelManager(
					$this->container->auth,
					$this->container->config['meetupDate']
				);

				$user = $this->container->auth->user();

				$userInfoModelManager->updateUserInfo(
					$user,
					$firstName,
					$lastName,
					$birthday,
					$genderId
				);

				return $response->write(json_encode(array(
					'status' => 'success',
					'message' => 'Informationen wurden aktualisiert'
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
?>
