<?php
	namespace Routes\Frontend\Backoffice;

	use Model\Booking;
	use Model\Room;
	use Model\Setting;
	use Psr\Container\ContainerInterface;
	use Slim\Http\Request;
	use Slim\Http\Response;

	class DashboardController {
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
			$bedCount          = Room::sum('bed_count');
			$bookingsCount     = Booking::count();
			$paidBookingsCount = Booking::where('paid', '=', true)->count();
			$malesCount        = $this->getBookingCountByGenderCode('male');
			$femalesCount      = $this->getBookingCountByGenderCode('female');

			$mailToAllRecipients = sprintf(
				'%s?bcc=%s',
				$this->container->config['mailer']['fromAddress'],
				implode(',', $this->getEmailAddressesForAllBookings())
			);

			$bookingIsActive     = (bool) Setting::where('setting_code', '=', 'booking_active')->first()->value;
			$waitingListIsActive = (bool) Setting::where('setting_code', '=', 'waiting_list_active')->first()->value;

			return $this->container->renderer->render($response, '/backoffice/dashboard/dashboard.php', [
				'request' => $request,
				'response' => $response,
				'database' => $this->container->database,
				'auth' => $this->container->auth,
				'flashMessages' => $this->container->flash->getMessages(),
				'pageTitle' => 'Dashboard',
				'bedCount' => $bedCount,
				'bookingsCount' => $bookingsCount,
				'paidBookingsCount' => $paidBookingsCount,
				'malesCount' => $malesCount,
				'femalesCount' => $femalesCount,
				'mailToAllRecipients' => $mailToAllRecipients,
				'bookingIsActive' => $bookingIsActive,
				'waitingListIsActive' => $waitingListIsActive
			]);
		}

		/**
		 * @param string $genderCode
		 *
		 * @return int
		 */
		protected function getBookingCountByGenderCode(string $genderCode): int {
			return Booking::join('user', 'booking.user_id', '=', 'user.user_id')
				->join('user_info', 'user.user_id', '=', 'user_info.user_id')
				->join('gender', 'user_info.gender_id', '=', 'gender.gender_id')
				->where('gender_code', '=', $genderCode)
				->count();
		}

		/**
		 * @return array
		 */
		protected function getEmailAddressesForAllBookings(): array {
			return Booking::join('user', 'booking.user_id', '=', 'user.user_id')
				->get(['email'])
				->pluck('email')
				->toArray();
		}
	}
?>
