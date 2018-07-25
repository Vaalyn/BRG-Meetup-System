<?php

namespace BronyRadioGermany\Meetup\Routes\Api;

use BronyRadioGermany\Meetup\Exception\InfoException;
use BronyRadioGermany\Meetup\Exception\MailNotSendException;
use BronyRadioGermany\Meetup\Model\Booking;
use BronyRadioGermany\Meetup\Model\Manager\BookingModelManager;
use BronyRadioGermany\Meetup\Model\Room;
use BronyRadioGermany\Meetup\Model\Setting;
use BronyRadioGermany\Meetup\Model\User;
use DateTime;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;
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
	public function createBookingAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$allergies   = $request->getParsedBody()['allergies'] ?? '';
		$stuff       = $request->getParsedBody()['stuff'] ?? '';
		$wishes      = $request->getParsedBody()['wishes'] ?? '';
		$couple      = isset($request->getParsedBody()['couple']);
		$coupleCode  = $request->getParsedBody()['couple_code'] ?? '';
		$roomId      = (int) $request->getParsedBody()['room_id'] ?? 0;
		$nightHike   = isset($request->getParsedBody()['night_hike']);

		try {
			$bookingIsActive = (bool) Setting::where('setting_code', '=', 'booking_active')->first()->value;

			if (!$bookingIsActive) {
				throw new InfoException('Die Anmeldung ist momentan geschlossen');
			}

			$bookingModelManager = new BookingModelManager(
				$this->container->config['allowUnisexRooms'],
				$this->container->config['nightHike']['places'],
				$this->container->auth,
				$this->container->mailer,
				$this->container->renderer
			);

			$booking = $bookingModelManager->createBooking(
				$allergies,
				$stuff,
				$wishes,
				$couple,
				$coupleCode,
				$roomId,
				$nightHike
			);

			$user = $this->container->auth->user();

			$bookingDetailsUrl = sprintf(
				'%s://%s%s',
				$request->getUri()->getScheme(),
				$request->getUri()->getHost(),
				$this->container->router->pathFor('booking.details')
			);

			$this->sendBookingEmail($user, $booking, $bookingDetailsUrl);

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Buchung wurde erstellt'
			)));
		}
		catch (InfoException $exception) {
			return $response->write(json_encode(array(
				'status' => 'error',
				'errors' => $exception->getMessage()
			)));
		}
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function moveBookingToRoomAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$couple     = isset($request->getParsedBody()['couple']);
		$coupleCode = $request->getParsedBody()['couple_code'] ?? '';
		$roomId     = $request->getParsedBody()['room_id'] ?? '';

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

		if ($booking->confirmed) {
			return $response->write(json_encode(array(
				'status' => 'error',
				'errors' => 'Dein Zimmerwunsch wurde bereits bestätigt, bitte kontaktiere uns'
			)));
		}

		$bookingModelManager = new BookingModelManager(
			$this->container->config['allowUnisexRooms'],
			$this->container->config['nightHike']['places'],
			$this->container->auth,
			$this->container->mailer,
			$this->container->renderer
		);

		$room = Room::where('room_id', '=', $roomId)->first();

		try {
			if ($couple && $coupleCode !== '') {
				$bookingModelManager->validateCoupleCode($coupleCode);
				$room = Booking::where('couple_code', '=', $coupleCode)->first()->room;
			}

			$bookingModelManager->validateBookingArguments(
				$coupleCode,
				$room->room_id,
				$booking->bookingInfo->night_hike,
				$booking
			);
		}
		catch (InfoException $exception) {
			return $response->write(json_encode(array(
				'status' => 'error',
				'errors' => $exception->getMessage()
			)));
		}

		switch ($room->roomType->type_code) {
			case ($couple && $coupleCode !== ''):
				$booking->couple      = true;
				$booking->couple_code = $coupleCode;
				break;

			case 'couple':
				$booking->couple      = true;
				$booking->couple_code = $room->bookings->count() === 0 ? Uuid::uuid4() : '';
				break;

			default:
				$booking->couple      = false;
				$booking->couple_code = '';
				break;
		}

		$booking->room_id = $room->room_id;
		$booking->save();

		return $response->write(json_encode(array(
			'status' => 'success',
			'message' => 'Zimmer wurde geändert'
		)));
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function cancelBookingAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		try {
			$bookingIsActive = (bool) Setting::where('setting_code', '=', 'booking_active')->first()->value;

			if (!$bookingIsActive) {
				throw new InfoException('Das stornieren ist zum jetzigen Zeitpunkt nicht mehr möglich');
			}

			$bookingModelManager = new BookingModelManager(
				$this->container->config['allowUnisexRooms'],
				$this->container->config['nightHike']['places'],
				$this->container->auth,
				$this->container->mailer,
				$this->container->renderer
			);

			$booking = $this->container->auth->user()->booking;

			$bookingModelManager->cancelBooking($booking, 'Durch den Benutzer storniert');

			return $response->write(json_encode(array(
				'status' => 'success',
				'message' => 'Buchung wurde storniert'
			)));
		}
		catch (InfoException $exception) {
			return $response->write(json_encode(array(
				'status' => 'error',
				'errors' => $exception->getMessage()
			)));
		}
	}

	/**
	 * @param User $user
	 * @param Booking $booking
	 * @param string $bookingDetailsUrl
	 *
	 * @return void
	 */
	protected function sendBookingEmail(User $user, Booking $booking, string $bookingDetailsUrl): void {
		$meetupDate = DateTime::createFromFormat('Y-m-d', $this->container->config['meetupDate']);
		$meetupYear = $meetupDate->format('Y');

		$bookingEmailMessage = $this->container->renderer->fetch(
			'/mailer/booking/create-booking/create-booking.php',
			[
				'isCoupleBooking' => $booking->couple,
				'coupleCode' => $booking->couple_code,
				'bookingDetailsUrl' => $bookingDetailsUrl,
				'meetupCost' => $this->container->config['meetupCost'],
				'user' => $user,
				'meetupYear' => $meetupYear,
				'payment' => $this->container->config['payment']
			]
		);

		try {
			$this->container->mailer->sendMail(
				'BRG-Meetup Anmeldung',
				$user->email,
				$user->username,
				$bookingEmailMessage
			);
		} catch (MailNotSendException $exception) {
			$booking->bookingInfo->delete();
			$booking->delete();
			throw new InfoException('Fehler beim Erstellen der Buchung');
		}
	}
}
