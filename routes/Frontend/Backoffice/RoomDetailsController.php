<?php
	namespace Routes\Frontend\Backoffice;

	use Model\Room;
	use Model\RoomType;
	use Psr\Container\ContainerInterface;
	use Slim\Http\Request;
	use Slim\Http\Response;

	class RoomDetailsController {
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
			$id = $args['id'];

			$rooms     = Room::withCount('bookings')->havingRaw('bookings_count < bed_count')->get();
			$roomTypes = RoomType::get();
			$room      = Room::where('room_id', '=', $id)->first();

			if (!isset($room)) {
				return $response->withRedirect($this->container->router->pathFor('rooms'));
			}

			$pageTitle = sprintf('Zimmer "%s"', $room->name);

			return $this->container->renderer->render($response, '/backoffice/room/details.php', [
				'request' => $request,
				'response' => $response,
				'database' => $this->container->database,
				'auth' => $this->container->auth,
				'flashMessages' => $this->container->flash->getMessages(),
				'pageTitle' => $pageTitle,
				'rooms' => $rooms,
				'roomTypes' => $roomTypes,
				'room' => $room
			]);
		}
	}
?>
