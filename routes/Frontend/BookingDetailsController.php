<?php

namespace Routes\Frontend;

use Model\Booking;
use Model\Manager\UserInfoModelManager;
use Model\Room;
use Model\Setting;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class BookingDetailsController {
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
		if ($this->container->auth->user()->booking === null) {
			return $response->withRedirect($this->container->router->pathFor('booking'));
		}

		$userInfoModelManager = new UserInfoModelManager(
			$this->container->auth,
			$this->container->config['meetupDate']
		);

		$user = $this->container->auth->user();

		$isUserUnderage = !$userInfoModelManager->isUserEighteenOnMeetup($user->userInfo->birthday->format('Y-m-d'));

		$bookingIsActive = (bool) Setting::where('setting_code', '=', 'booking_active')->first()->value;
		$allRoomsFull    = (Room::sum('bed_count') - Booking::count()) > 0 ? false : true;

		$rooms       = Room::with(['roomType'])->get();
		$roomsCouple = $rooms->where('roomType.type_code', '=', 'couple');
		$roomsSingle = [];

		switch ($user->userInfo->gender->gender_code) {
			case 'male':
				$roomsSingle = $rooms->where('roomType.type_code', '=', 'normal');
				break;

			case 'female':
				if ($this->container->config['allowUnisexRooms']) {
					$roomsSingle = $rooms->where([
						['roomType.type_code', '=', 'normal'],
						['roomType.type_code', '=', 'female']
					]);
				}
				else {
					$roomsSingle = $rooms->where('roomType.type_code', '=', 'female');
				}
				break;
		}

		$nightHikePlaces = $this->container->config['nightHike']['places'];
		$bookingsWithNightHike = Booking::join(
				'booking_info',
				'booking.booking_id',
				'=',
				'booking_info.booking_id'
			)
			->where('night_hike', '=', true)
			->count();
		$availableNightHikePlaces = $nightHikePlaces - $bookingsWithNightHike;

		return $this->container->renderer->render($response, '/booking/details.php', [
			'request' => $request,
			'response' => $response,
			'database' => $this->container->database,
			'auth' => $this->container->auth,
			'flashMessages' => $this->container->flash->getMessages(),
			'user' => $user,
			'isUserUnderage' => $isUserUnderage,
			'bookingIsActive' => $bookingIsActive,
			'allRoomsFull' => $allRoomsFull,
			'roomsCouple' => $roomsCouple,
			'roomsSingle' => $roomsSingle,
			'availableNightHikePlaces' => $availableNightHikePlaces,
			'payment' => $this->container->config['payment'],
			'meetupCost' => $this->container->config['meetupCost'],
			'meetupDate' => $this->container->config['meetupDate']
		]);
	}
}
