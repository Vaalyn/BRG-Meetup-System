<?php
	namespace Routes\Api;

	use Exception\InfoException;
	use Model\Booking;
	use Model\Manager\BookingModelManager;
	use Model\Setting;
	use Psr\Container\ContainerInterface;
	use Slim\Http\Request;
	use Slim\Http\Response;

	class BookingInfoController {
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
		public function updateBookingInfoAction(Request $request, Response $response, array $args): Response {
			$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

			$allergies = $request->getParsedBody()['allergies'] ?? '';
			$stuff     = $request->getParsedBody()['stuff'] ?? '';
			$wishes    = $request->getParsedBody()['wishes'] ?? '';
			$nightHike = isset($request->getParsedBody()['night_hike']);

			$bookingIsActive = (bool) Setting::where('setting_code', '=', 'booking_active')->first();

			if (!$bookingIsActive) {
				return $response->write(json_encode(array(
					'status' => 'error',
					'errors' => 'Die Buchungsinformationen dürfen nicht mehr geändert werden'
				)));
			}

			$booking = $this->container->auth->user()->booking;

			if (!isset($booking)) {
				return $response->write(json_encode(array(
					'status' => 'error',
					'errors' => 'Du hast kein Zimmer gebucht'
				)));
			}

			if (!$this->checkIfNightHikePlaceIsAvailable($booking, $nightHike)) {
				return $response->write(json_encode(array(
					'status' => 'error',
					'errors' => 'Es sind keine Plätze mehr für die Nachtwanderung verfügbar'
				)));
			}

			$booking->bookingInfo->allergies  = $allergies;
			$booking->bookingInfo->stuff      = $stuff;
			$booking->bookingInfo->wishes     = $wishes;
			$booking->bookingInfo->night_hike = $nightHike;
			$booking->bookingInfo->save();

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Informationen wurden aktualisiert'
			)));
		}

		/**
		 * @param \Model\Booking $booking
		 * @param bool $nightHike
		 *
		 * @return bool
		 */
		protected function checkIfNightHikePlaceIsAvailable(Booking $booking, bool $nightHike): bool {
			$bookingModelManager = new BookingModelManager(
				$this->container->config['allowUnisexRooms'],
				$this->container->config['nightHike']['places'],
				$this->container->auth,
				$this->container->mailer,
				$this->container->renderer
			);

			try {
				$bookingModelManager->validateNightHikeBooking($booking, $nightHike);
			}
			catch(InfoException $exception) {
				return false;
			}

			return true;
		}
	}
?>
