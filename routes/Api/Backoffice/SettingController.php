<?php
	namespace Routes\Api\Backoffice;

	use Model\Setting;
	use Psr\Container\ContainerInterface;
	use Slim\Http\Request;
	use Slim\Http\Response;

	class SettingController {
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
		public function enableBookingProcessAction(Request $request, Response $response, array $args): Response {
			$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

			$settingBookingActive = Setting::where('setting_code', '=', 'booking_active')->first();
			$settingBookingActive->value = '1';
			$settingBookingActive->save();

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Anmeldung wurde geöffnet'
			)));
		}

		/**
		 * @param \Slim\Http\Request $request
		 * @param \Slim\Http\Response $response
		 * @param array $args
		 *
		 * @return \Slim\Http\Response
		 */
		public function disableBookingProcessAction(Request $request, Response $response, array $args): Response {
			$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

			$settingBookingActive = Setting::where('setting_code', '=', 'booking_active')->first();
			$settingBookingActive->value = '0';
			$settingBookingActive->save();

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Anmeldung wurde geschlossen'
			)));
		}

		/**
		 * @param \Slim\Http\Request $request
		 * @param \Slim\Http\Response $response
		 * @param array $args
		 *
		 * @return \Slim\Http\Response
		 */
		public function enableWaitingListAction(Request $request, Response $response, array $args): Response {
			$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

			$settingBookingActive = Setting::where('setting_code', '=', 'waiting_list_active')->first();
			$settingBookingActive->value = '1';
			$settingBookingActive->save();

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Warteliste wurde geöffnet'
			)));
		}

		/**
		 * @param \Slim\Http\Request $request
		 * @param \Slim\Http\Response $response
		 * @param array $args
		 *
		 * @return \Slim\Http\Response
		 */
		public function disableWaitingListAction(Request $request, Response $response, array $args): Response {
			$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

			$settingBookingActive = Setting::where('setting_code', '=', 'waiting_list_active')->first();
			$settingBookingActive->value = '0';
			$settingBookingActive->save();

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Warteliste wurde geschlossen'
			)));
		}
	}
?>
