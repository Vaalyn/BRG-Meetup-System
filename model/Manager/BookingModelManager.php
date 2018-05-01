<?php
	namespace Model\Manager;

	use Exception\InfoException;
	use Model\Booking;
	use Model\BookingInfo;
	use Model\Room;
	use Model\User;
	use Ramsey\Uuid\Uuid;
	use Service\Auth\AuthInterface;
	use Service\Mailer\MailerInterface;
	use Slim\Views\PhpRenderer;

	class BookingModelManager {
		/**
		 * @var bool
		 */
		protected $allowUnisexRooms;

		/**
		 * @var int
		 */
		protected $nightHikePlaces;

		/**
		 * @var \Service\Auth\AuthInterface
		 */
		protected $auth;

		/**
		 * @var \Service\Mailer\MailerInterface
		 */
		protected $mailer;

		/**
		 * @var \Slim\Views\PhpRenderer
		 */
		protected $renderer;

		/**
		 * @param bool $allowUnisexRooms
		 * @param int $nightHikePlaces
		 * @param \Service\Auth\AuthInterface $auth
		 * @param \Service\Mailer\MailerInterface $mailer
		 * @param \Slim\Views\PhpRenderer $renderer
		 */
		public function __construct(
			bool $allowUnisexRooms,
			int $nightHikePlaces,
			AuthInterface $auth,
			MailerInterface $mailer,
			PhpRenderer $renderer
		) {
			$this->allowUnisexRooms = $allowUnisexRooms;
			$this->nightHikePlaces  = $nightHikePlaces;
			$this->auth             = $auth;
			$this->mailer           = $mailer;
			$this->renderer         = $renderer;
		}

		/**
		 * @param string $allergies
		 * @param string $stuff
		 * @param string $wishes
		 * @param bool $couple
		 * @param string $coupleCode
		 * @param int $roomId
		 * @param bool $nightHike
		 *
		 * @return \Model\Booking
		 */
		public function createBooking(
			string $allergies,
			string $stuff,
			string $wishes,
			bool $couple,
			string $coupleCode,
			int $roomId,
			bool $nightHike
		): Booking {
			$this->validateBookingArguments($coupleCode, $roomId, $nightHike);

			if ($couple) {
				return $this->createBookingForCouple(
					$allergies,
					$stuff,
					$wishes,
					$coupleCode,
					$roomId,
					$nightHike
				);
			}
			else {
				return $this->createBookingForSingle(
					$allergies,
					$stuff,
					$wishes,
					$roomId,
					$nightHike
				);
			}
		}

		/**
		 * @param string $allergies
		 * @param string $stuff
		 * @param string $wishes
		 * @param int $roomId
		 * @param bool $nightHike
		 *
		 * @return \Model\Booking
		 */
		protected function createBookingForSingle(
			string $allergies,
			string $stuff,
			string $wishes,
			int $roomId,
			bool $nightHike
		): Booking {
			$user = $this->auth->user();

			$booking              = new Booking();
			$booking->room_id     = $roomId;
			$booking->user_id     = $user->user_id;
			$booking->couple_code = '';
			$booking->paid        = false;
			$booking->save();

			if ($booking->booking_id === null) {
				throw new InfoException('Buchung konnte nicht erstellt werden');
			}

			$bookingInfo             = new BookingInfo();
			$bookingInfo->booking_id = $booking->booking_id;
			$bookingInfo->allergies  = $allergies;
			$bookingInfo->stuff      = $stuff;
			$bookingInfo->wishes     = $wishes;
			$bookingInfo->night_hike  = $nightHike;
			$bookingInfo->save();

			if ($bookingInfo->booking_info_id === null) {
				$booking->delete();
				throw new InfoException('Buchung konnte nicht erstellt werden');
			}

			return $booking;
		}

		/**
		 * @param string $allergies
		 * @param string $stuff
		 * @param string $wishes
		 * @param string $coupleCode
		 * @param int $roomId
		 * @param bool $nightHike
		 *
		 * @return \Model\Booking
		 */
		protected function createBookingForCouple(
			string $allergies,
			string $stuff,
			string $wishes,
			string $coupleCode,
			int $roomId,
			bool $nightHike
		): Booking {
			$user = $this->auth->user();

			if ($user->booking !== null) {
				throw new InfoException('Es kann nur ein Zimmer pro Person gebucht werden');
			}

			$booking          = new Booking();
			$booking->user_id = $user->user_id;
			$booking->couple  = true;
			$booking->paid    = false;

			if ($coupleCode === '') {
				$booking->room_id     = $roomId;
				$booking->couple_code = Uuid::uuid4();
			}
			else {
				$partnerBooking = Booking::where('couple_code', '=', $coupleCode)->first();

				$booking->room_id     = $partnerBooking->room_id;
				$booking->couple_code = $coupleCode;
			}

			$booking->save();

			if ($booking->booking_id === null) {
				throw new InfoException('Buchung konnte nicht erstellt werden');
			}

			$bookingInfo             = new BookingInfo();
			$bookingInfo->booking_id = $booking->booking_id;
			$bookingInfo->allergies  = $allergies;
			$bookingInfo->stuff      = $stuff;
			$bookingInfo->wishes     = $wishes;
			$bookingInfo->night_hike  = $nightHike;
			$bookingInfo->save();

			if ($bookingInfo->booking_info_id === null) {
				$booking->delete();
				throw new InfoException('Buchung konnte nicht erstellt werden');
			}

			return $booking;
		}

		/**
		 * @param \Model\Booking $booking
		 * @param string $reason
		 *
		 * @return void
		 */
		public function cancelBooking(Booking $booking, string $reason): void {
			$user = $booking->user;

			$booking->delete();

			$this->sendBookingCanceledEmail($user, $reason);
		}

		/**
		 * @param \Model\User $user
		 * @param string $reason
		 *
		 * @return void
		 */
		protected function sendBookingCanceledEmail(User $user, string $reason): void {
			$bookingCanceledEmailMessage = $this->renderer->fetch(
				'/mailer/booking/canceled/canceled.php',
				[
					'reason' => $reason
				]
			);

			try {
				$this->mailer->sendMail(
					'BRG-Meetup Buchung wurde storniert',
					$user->email,
					$user->username,
					$bookingCanceledEmailMessage
				);
			} catch (\Exception\MailNotSendException $exception) {
				throw new InfoException('Fehler beim senden der E-Mail Benachrichtigung nach Stornierung');
			}
		}

		/**
		 * @param string $coupleCode
		 * @param int $roomId
		 * @param bool $nightHike
		 * @param null|Booking $booking
		 *
		 * @return void
		 */
		public function validateBookingArguments(
			string $coupleCode,
			int $roomId,
			bool $nightHike,
			Booking $booking = null
		): void {
			$room = Room::where('room_id', '=', $roomId)->first();

			if (!isset($room)) {
				throw new InfoException('Unbekanntes Zimmer');
			}

			if ($booking && $booking->room_id === $room->room_id) {
				throw new InfoException('Buchung läuft bereits auf dieses Zimmer');
			}

			switch ($room->roomType->type_code) {
				case 'normal':
					$this->validateNormalRoomBookingArguments();
					break;

				case 'female':
					$this->validateFemaleRoomBookingArguments();
					break;

				case 'couple':
					$this->validateCoupleRoomBookingArguments($coupleCode, $room);
					break;
			}

			if ($room->bookings->count() >= $room->bed_count) {
				throw new InfoException('In diesem Zimmer sind keine Betten mehr verfügbar');
			}

			$this->validateNightHikeBooking($booking, $nightHike);
		}

		/**
		 * @return void
		 */
		public function validateNormalRoomBookingArguments(): void {
			if (
				$this->auth->user()->userInfo->gender->gender_code === 'female' &&
				!$this->allowUnisexRooms
			) {
				throw new InfoException('Dieses Zimmer ist nicht für weibliche Besucher verfügbar');
			}
		}

		/**
		 * @return void
		 */
		public function validateFemaleRoomBookingArguments(): void {
			if ($this->auth->user()->userInfo->gender->gender_code !== 'female') {
				throw new InfoException('Dieses Zimmer ist nur für weibliche Besucher verfügbar');
			}
		}

		/**
		 * @param string $coupleCode
		 * @param \Model\Room $room
		 *
		 * @return void
		 */
		public function validateCoupleRoomBookingArguments(string $coupleCode, Room $room): void {
			if ($room->bookings->count() > 0 && $coupleCode === '') {
				throw new InfoException('Um dieses Zimmer zu buchen benötigst du ein Pärchencode');
			}

			if ($room->bookings->count() > 0) {
				$this->validateCoupleCode($coupleCode);
			}

			if ($room->bookings->count() >= $room->bed_count) {
				throw new InfoException('In diesem Zimmer sind keine Betten mehr verfügbar');
			}
		}

		/**
		 * @param string $coupleCode
		 *
		 * @return void
		 */
		public function validateCoupleCode(string $coupleCode): void {
			$partnerBooking = Booking::where('couple_code', '=', $coupleCode)->first();

			if (!isset($partnerBooking)) {
				throw new InfoException('Ungültiger Pärchencode');
			}
		}

		/**
		 * @param null|\Model\Booking $booking
		 * @param bool $nightHike
		 *
		 * @return void
		 */
		public function validateNightHikeBooking(?Booking $booking, bool $nightHike): void {
			if (!$nightHike) {
				return;
			}

			$bookingsWithNightHike = Booking::join(
					'booking_info',
					'booking.booking_id',
					'=',
					'booking_info.booking_id'
				)
				->where('night_hike', '=', true)
				->count();
			$availableNightHikePlaces = $this->nightHikePlaces - $bookingsWithNightHike;

			if ($availableNightHikePlaces > 0) {
				return;
			}

			if ($booking === null || !$booking->bookingInfo->night_hike) {
				throw new InfoException('Es sind keine Plätze mehr für die Nachtwanderung verfügbar');
			}
		}
	}
?>
