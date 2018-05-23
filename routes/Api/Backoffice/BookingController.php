<?php

namespace Routes\Api\Backoffice;

use Exception\InfoException;
use Model\Booking;
use Model\Manager\BookingModelManager;
use Model\Room;
use Model\User;
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
	public function confirmRoomAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$booking = Booking::where('booking_id', '=', $id)->first();

		if (!isset($booking)) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Keine Buchung gefunden'
			)));
		}

		$booking->confirmed = true;
		$booking->save();

		return $response->write(json_encode(array(
			'status' => 'success',
			'message' => 'Zimmer wurde bestätigt'
		)));
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function removeRoomConfirmationAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$booking = Booking::where('booking_id', '=', $id)->first();

		if (!isset($booking)) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Keine Buchung gefunden'
			)));
		}

		$booking->confirmed = false;
		$booking->save();

		return $response->write(json_encode(array(
			'status' => 'success',
			'message' => 'Zimmerbestätigung wurde widerrufen'
		)));
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function setBookingPaidAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$booking = Booking::where('booking_id', '=', $id)->first();

		if (!isset($booking)) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Keine Buchung gefunden'
			)));
		}

		$booking->paid = true;
		$booking->save();

		$this->sendBookingPaidEmail($booking->user);

		return $response->write(json_encode(array(
			'status' => 'success',
			'message' => 'Buchung wurde als bezahlt markiert'
		)));
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function setBookingUnpaidAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$booking = Booking::where('booking_id', '=', $id)->first();

		if (!isset($booking)) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Keine Buchung gefunden'
			)));
		}

		$booking->paid = false;
		$booking->save();

		return $response->write(json_encode(array(
			'status' => 'success',
			'message' => 'Buchung wurde als nicht bezahlt markiert'
		)));
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

		$bookingId = $args['bookingId'];
		$roomId    = $args['roomId'];

		$booking = Booking::where('booking_id', '=', $bookingId)->first();
		$room    = Room::where('room_id', '=', $roomId)->first();

		$reason = $request->getParsedBody()['reason'] ?? 'Von Administrator geändert';

		if (!isset($booking)) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Keine Buchung gefunden'
			)));
		}

		if (!isset($room)) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Kein Zimmer gefunden'
			)));
		}

		if ($booking->room_id === $room->room_id) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Buchung läuft bereits auf dieses Zimmer'
			)));
		}

		if ($room->bookings()->count() >= $room->bed_count) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Keine Betten verfügbar'
			)));
		}

		switch ($room->roomType->type_code) {
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

		$this->sendBookingRoomChangedEmail(
			$booking->user,
			$booking,
			$reason
		);

		return $response->write(json_encode(array(
			'status' => 'success',
			'message' => 'Zimmer der Buchung wurde geändert'
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

		$id = $args['id'];

		$reason = $request->getParsedBody()['reason'] ?? null;

		$booking = Booking::where('booking_id', '=', $id)->first();

		if (!isset($booking)) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Keine Buchung gefunden'
			)));
		}

		$bookingModelManager = new BookingModelManager(
			$this->container->config['allowUnisexRooms'],
			$this->container->config['nightHike']['places'],
			$this->container->auth,
			$this->container->mailer,
			$this->container->renderer
		);

		$bookingModelManager->cancelBooking($booking, $reason);

		return $response->write(json_encode(array(
			'status' => 'success',
			'message' => 'Buchung wurde storniert'
		)));
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function deleteBookingAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$booking = Booking::onlyTrashed()->where('booking_id', '=', $id)->first();

		if (!isset($booking)) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Keine Buchung gefunden'
			)));
		}

		$booking->bookingInfo->delete();
		$booking->forceDelete();

		return $response->write(json_encode(array(
			'status' => 'success',
			'message' => 'Buchung wurde gelöscht'
		)));
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function exportBookingsAction(Request $request, Response $response, array $args): Response {
		$bookings = Booking::get();

		$temporaryCsvFile = tmpfile();

		fputcsv($temporaryCsvFile, [
			'Vorname',
			'Nachname',
			'Username',
			'Zimmer',
			'Allergien',
			'Mitbringsel',
			'Nachtwanderung'
		]);

		foreach ($bookings as $booking) {
			$csvEntry = [
				$booking->user->userInfo->first_name,
				$booking->user->userInfo->last_name,
				$booking->user->username,
				$booking->room->name,
				$booking->bookingInfo->allergies,
				$booking->bookingInfo->stuff,
				$booking->bookingInfo->night_hike
			];

			fputcsv($temporaryCsvFile, $csvEntry);
		}

		$fileSize = fstat($temporaryCsvFile)['size'];
		$downloadFileStream = new \Slim\Http\Stream($temporaryCsvFile);

		return $response->withStatus(200)
			->withHeader('Content-Type', 'text/csv')
			->withHeader('Content-Description', 'File Transfer')
			->withHeader('Content-Disposition', 'attachment; filename="Buchungen.csv"')
			->withHeader('Content-Transfer-Encoding', 'binary')
			->withHeader('Cache-Control', 'no-cache')
			->withHeader('Expires', '0')
			->withHeader('Content-Length',  $fileSize)
			->withBody($downloadFileStream);
	}

	/**
	 * @param \Slim\Http\Request $request
	 * @param \Slim\Http\Response $response
	 * @param array $args
	 *
	 * @return \Slim\Http\Response
	 */
	public function getBookingAction(Request $request, Response $response, array $args): Response {
		$response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');

		$id = $args['id'];

		$booking = Booking::with('bookingInfo')
			->where('booking_id', '=', $id)
			->first();

		$user = User::with(['userInfo', 'userInfo.gender'])->where('user_id', '=', $booking->user_id)->first();

		$booking->user = [
			'username' => $user->username,
			'email' => $user->email,
			'user_info' => $user->userInfo
		];

		if (!isset($booking)) {
			return $response->write(json_encode(array(
	        	'status' => 'error',
				'errors' => 'Keine Buchung gefunden'
			)));
		}

		return $response->write(json_encode(array(
			'status' => 'success',
			'result' => $booking
		)));
	}

	/**
	 * @param User $user
	 *
	 * @return void
	 */
	protected function sendBookingPaidEmail(User $user): void {
		$paymentReceivedEmailMessage = $this->container->renderer->fetch(
			'/mailer/booking/payment-received/payment-received.php'
		);

		try {
			$this->container->mailer->sendMail(
				'BRG-Meetup Zahlungseingang bestätigt',
				$user->email,
				$user->username,
				$paymentReceivedEmailMessage
			);
		} catch (\Exception\MailNotSendException $exception) {
			throw new InfoException('Fehler beim senden der E-Mail Benachrichtigung nach Bezahlung');
		}
	}

	/**
	 * @param User $user
	 * @param Booking $booking
	 * @param string $reason
	 *
	 * @return void
	 */
	protected function sendBookingRoomChangedEmail(User $user, Booking $booking, string $reason): void {
		$roomChangedEmailMessage = $this->container->renderer->fetch(
			'/mailer/booking/room-changed/room-changed.php',
			[
				'reason' => $reason,
				'booking' => $booking
			]
		);

		try {
			$this->container->mailer->sendMail(
				'BRG-Meetup Zimmer wurde geändert',
				$user->email,
				$user->username,
				$roomChangedEmailMessage
			);
		} catch (\Exception\MailNotSendException $exception) {
			throw new InfoException('Fehler beim senden der E-Mail Benachrichtigung nach Zimmeränderung');
		}
	}
}
