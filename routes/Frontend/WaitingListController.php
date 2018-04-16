<?php
	namespace Routes\Frontend;

use Model\Room;
use Model\Booking;
use Model\Setting;

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
			$allRoomsFull        = (Room::sum('bed_count') - Booking::count()) > 0 ? false : true;
			$waitingListIsActive = (bool) Setting::where('setting_code', '=', 'waiting_list_active')->first()->value;

			if (!$waitingListIsActive && !$allRoomsFull) {
				return $response->withRedirect($this->container->router->pathFor('booking'));
			}

			return $this->container->renderer->render($response, '/waiting-list/waiting-list.php', [
				'request' => $request,
				'response' => $response,
				'database' => $this->container->database,
				'auth' => $this->container->auth,
				'flashMessages' => $this->container->flash->getMessages(),
				'pageTitle' => 'Warteliste'
			]);
		}
	}
?>
