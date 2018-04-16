<?php
	use Routes\Api;
	use Routes\Frontend;

	$app->group('/api', function() {
		$this->post('/booking/enable', Api\Backoffice\SettingController::class . ':enableBookingProcessAction')->setName('api.backoffice.booking.enable');
		$this->post('/booking/disable', Api\Backoffice\SettingController::class . ':disableBookingProcessAction')->setName('api.backoffice.booking.disable');
		$this->get('/booking/export', Api\Backoffice\BookingController::class . ':exportBookingsAction')->setName('api.backoffice.booking.export');
		$this->post('/booking/create', Api\BookingController::class . ':createBookingAction')->setName('api.booking.create');
		$this->get('/booking/{id}', Api\Backoffice\BookingController::class . ':getBookingAction')->setName('api.backoffice.booking.get');
		$this->post('/booking/{id}/confirm', Api\Backoffice\BookingController::class . ':confirmRoomAction')->setName('api.backoffice.booking.confirm');
		$this->post('/booking/{id}/confirm/remove', Api\Backoffice\BookingController::class . ':removeRoomConfirmationAction')->setName('api.backoffice.booking.confirm.remove');
		$this->post('/booking/{id}/paid', Api\Backoffice\BookingController::class . ':setBookingPaidAction')->setName('api.backoffice.booking.paid');
		$this->post('/booking/{id}/unpaid', Api\Backoffice\BookingController::class . ':setBookingUnpaidAction')->setName('api.backoffice.booking.unpaid');
		$this->post('/booking/room/save', Api\BookingController::class . ':moveBookingToRoomAction')->setName('api.booking.move');
		$this->post('/booking/{bookingId}/move/room/{roomId}', Api\Backoffice\BookingController::class . ':moveBookingToRoomAction')->setName('api.backoffice.booking.move');
		$this->post('/booking/cancel', Api\BookingController::class . ':cancelBookingAction')->setName('api.booking.cancel');
		$this->post('/booking/{id}/cancel', Api\Backoffice\BookingController::class . ':cancelBookingAction')->setName('api.backoffice.booking.cancel');
		$this->delete('/booking/{id}', Api\Backoffice\BookingController::class . ':deleteBookingAction')->setName('api.backoffice.booking.delete');

		$this->post('/booking/info/save', Api\BookingInfoController::class . ':updateBookingInfoAction')->setName('api.booking.info.save');

		$this->post('/login', Api\LoginController::class . ':loginAction')->setName('api.login');

		$this->get('/room/{id}', Api\Backoffice\RoomController::class . ':getRoomAction')->setName('api.backoffice.room.get');
		$this->delete('/room/{id}', Api\Backoffice\RoomController::class . ':deleteRoomAction')->setName('api.backoffice.room.delete');
		$this->post('/room/save', Api\Backoffice\RoomController::class . ':saveRoomAction')->setName('api.backoffice.room.save');

		$this->post('/registration', Api\UserController::class . ':createUserAction')->setName('api.user.create');

		$this->post('/user/update', Api\UserController::class . ':updateUserAction')->setName('api.user.update');
		$this->post('/user/info/update', Api\UserInfoController::class . ':updateUserInfoAction')->setName('api.user.info.update');
		$this->post('/user/password/forgot', Api\UserController::class . ':forgotPasswordAction')->setName('api.user.password.forgot');
		$this->post('/user/password/reset', Api\UserController::class . ':resetPasswordAction')->setName('api.user.password.reset');

		$this->post('/waiting-list/enable', Api\Backoffice\SettingController::class . ':enableWaitingListAction')->setName('api.backoffice.waiting-list.enable');
		$this->post('/waiting-list/disable', Api\Backoffice\SettingController::class . ':disableWaitingListAction')->setName('api.backoffice.waiting-list.disable');
		$this->post('/waiting-list/add', Api\WaitingListController::class . ':addWaitingListEntryAction')->setName('api.waiting-list.add');
		$this->delete('/waiting-list/{id}', Api\Backoffice\WaitingListController::class . ':deleteWaitingListEntryAction')->setName('api.backoffice.waiting-list.delete');
	});

	$app->group('/backoffice', function() {
		$this->get('/bookings', Frontend\Backoffice\BookingController::class)->setName('backoffice.bookings');
		$this->get('/cancelations', Frontend\Backoffice\CancelationController::class)->setName('backoffice.cancelations');
		$this->get('/dashboard', Frontend\Backoffice\DashboardController::class)->setName('dashboard');
		$this->get('/rooms', Frontend\Backoffice\RoomController::class)->setName('backoffice.rooms');
		$this->get('/room/{id}/details', Frontend\Backoffice\RoomDetailsController::class)->setName('backoffice.room.details');
		$this->get('/waiting-list', Frontend\Backoffice\WaitingListController::class)->setName('backoffice.waiting-list');
	});

	$app->get('/', Frontend\HomeController::class)->setName('home');

	$app->get('/anmeldung', Frontend\BookingController::class)->setName('booking');

	$app->get('/account', Frontend\AccountController::class)->setName('account');

	$app->get('/datenschutz', Frontend\PrivacyProtectionController::class)->setName('privacy-protection');

	$app->get('/gallerie[/{year}]', Frontend\GalleryController::class)->setName('gallery');

	$app->get('/haftungsausschluss', Frontend\DisclaimerController::class)->setName('disclaimer');

	$app->get('/impressum', Frontend\ImprintController::class)->setName('imprint');

	$app->get('/login', Frontend\LoginController::class . ':getLoginAction')->setName('login');
	$app->post('/login', Frontend\LoginController::class . ':loginAction')->setName('post.login');

	$app->get('/logout', Frontend\LogoutController::class)->setName('logout');

	$app->get('/nachtwanderung', Frontend\NightHikeController::class)->setName('night-hike');

	$app->get('/meine-buchung', Frontend\BookingDetailsController::class)->setName('booking.details');

	$app->get('/packliste', Frontend\PackingListController::class)->setName('packing-list');

	$app->get('/password-reset/{code}', Frontend\PasswordResetController::class)->setName('password-reset');

	$app->get('/preis', Frontend\PriceController::class)->setName('price');

	$app->get('/programm', Frontend\ScheduleController::class)->setName('schedule');

	$app->get('/registrierung', Frontend\RegistrationController::class)->setName('registration');

	$app->get('/veranstaltungsort', Frontend\LocationController::class)->setName('location');

	$app->get('/verpflegung', Frontend\CateringController::class)->setName('catering');

	$app->get('/warteliste', Frontend\WaitingListController::class)->setName('waiting-list');

	$app->get('/zimmer', Frontend\RoomController::class)->setName('room');
?>
