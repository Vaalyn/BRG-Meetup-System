<?php

namespace BronyRadioGermany\Meetup\Routes\Frontend;

use BronyRadioGermany\Meetup\Model\Booking;
use BronyRadioGermany\Meetup\Model\Manager\UserInfoModelManager;
use BronyRadioGermany\Meetup\Model\Room;
use BronyRadioGermany\Meetup\Model\Setting;
use BronyRadioGermany\Meetup\Model\RoomType;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class BookingController {
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
		$bookingIsActive     = (bool) Setting::where('setting_code', '=', 'booking_active')->first()->value;
		$waitingListIsActive = (bool) Setting::where('setting_code', '=', 'waiting_list_active')->first()->value;
		$allRoomsFull        = (Room::sum('bed_count') - Booking::count()) > 0 ? false : true;

		if ($waitingListIsActive && (!$bookingIsActive || $allRoomsFull)) {
			return $response->withRedirect($this->container->router->pathFor('waiting-list'));
		}

		if (!$bookingIsActive) {
			return $this->container->renderer->render($response, '/booking/booking-disabled.php', [
				'request' => $request,
				'response' => $response,
				'database' => $this->container->database,
				'auth' => $this->container->auth,
				'flashMessages' => $this->container->flash->getMessages()
			]);
		}

		if (!$this->container->auth->check()) {
			return $response->withRedirect($this->container->router->pathFor('registration'));
		}

		if ($this->container->auth->user()->booking !== null) {
			return $response->withRedirect($this->container->router->pathFor('booking.details'));
		}

		$userInfoModelManager = new UserInfoModelManager(
			$this->container->auth,
			$this->container->config['meetupDate']
		);

		$user = $this->container->auth->user();

		$isUserUnderage = !$userInfoModelManager->isUserEighteenOnMeetup($user->userInfo->birthday->format('Y-m-d'));

		$rooms       = Room::with(['roomType']);
		$roomsCouple = $rooms->where('room_type.type_code', '=', 'couple');
		$roomsSingle = [];

		switch ($user->userInfo->gender->gender_code) {
			case 'male':
				$roomsSingle = $rooms->where('room_type.type_code', '=', 'normal')->get();
				break;

			case 'female':
				if ($this->container->config['allowUnisexRooms']) {
					$roomsSingle = $rooms->where([
						['room_type.type_code', '=', 'normal'],
						['room_type.type_code', '=', 'female']
					])->get();
				}
				else {
					$roomsSingle = $rooms->where('room_type.type_code', '=', 'female')->get();
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

		return $this->container->renderer->render($response, '/booking/booking.php', [
			'request' => $request,
			'response' => $response,
			'database' => $this->container->database,
			'auth' => $this->container->auth,
			'flashMessages' => $this->container->flash->getMessages(),
			'user' => $user,
			'isUserUnderage' => $isUserUnderage,
			'roomsCouple' => $roomsCouple,
			'roomsSingle' => $roomsSingle,
			'availableNightHikePlaces' => $availableNightHikePlaces
		]);
	}
}
