<?php
	return array(
		'settings' => array(
			'determineRouteBeforeAppMiddleware' => true,
			'displayErrorDetails' => false
		),
		'config' => array(
			'session' => array(
				'name'     => 'BRG_MEETUP_SESSID',
				'lifetime' => 1200,
				'path'     => '/',
				'domain'   => 'localhost',
				'secure'   => true,
				'httponly' => true
			),
			'database' => array(
				'driver'    => '',
				'host' 	    => '',
				'database' 	=> '',
				'username' 	=> '',
				'password' 	=> '',
				'charset'   => 'utf8mb4',
				'collation' => 'utf8mb4_unicode_ci',
				'prefix'    => '',
				'port'      => 3306
			),
			'auth' => array(
				'cookie' => array(
					'name'     => 'remember',
					'expire'   => 2592000,
					'domain'   => '',
					'secure'   => true,
					'httponly' => true
				),
				'routes' => array(
					'account',
					'booking.details',
					'dashboard' => array(
						'admin'
					),
					'backoffice.bookings' => array(
						'admin'
					),
					'backoffice.cancelations' => array(
						'admin'
					),
					'backoffice.rooms' => array(
						'admin'
					),
					'backoffice.room.details' => array(
						'admin'
					),
					'backoffice.waiting-list' => array(
						'admin'
					),
					'api.backoffice.booking.cancel' => array(
						'admin'
					),
					'api.backoffice.booking.confirm' => array(
						'admin'
					),
					'api.backoffice.booking.confirm.remove' => array(
						'admin'
					),
					'api.backoffice.booking.delete' => array(
						'admin'
					),
					'api.backoffice.booking.disable' => array(
						'admin'
					),
					'api.backoffice.booking.export' => array(
						'admin'
					),
					'api.backoffice.booking.enable' => array(
						'admin'
					),
					'api.backoffice.booking.get' => array(
						'admin'
					),
					'api.backoffice.booking.move' => array(
						'admin'
					),
					'api.backoffice.booking.paid' => array(
						'admin'
					),
					'api.backoffice.booking.unpaid' => array(
						'admin'
					),
					'api.backoffice.room.delete' => array(
						'admin'
					),
					'api.backoffice.room.get' => array(
						'admin'
					),
					'api.backoffice.room.save' => array(
						'admin'
					),
					'api.backoffice.waiting-list.delete' => array(
						'admin'
					),
					'api.backoffice.waiting-list.disable' => array(
						'admin'
					),
					'api.backoffice.waiting-list.enable' => array(
						'admin'
					),
					'api.booking.cancel',
					'api.booking.create',
					'api.booking.info.save',
					'api.booking.move',
					'api.user.update',
					'api.user.info.update'
				),
				'local' => array(
				)
			),
			'flysystem' => array(
				'files' => array(
					'adapter' => 'League\Flysystem\Adapter\Local',
					'arguments' => array(
						__DIR__ . '/../files'
					),
					'config' => array(
					)
				),
				'gallery' => array(
					'adapter' => 'League\Flysystem\Adapter\Local',
					'arguments' => array(
						__DIR__ . '/../public/img/meetup'
					),
					'config' => array(
					)
				)
			),
			'recaptcha' => array(
				'key' => '',
				'secret' => ''
			),
			'maps' => array(
				'key' => ''
			),
			'mailer' => array(
				'from' => '',
				'fromAddress' => '',
				'username' => '',
				'password' => '',
				'host' => '',
				'port' => 587,
				'security' => 'tls',
				'authMode' => 'login'
			),
			'meetupCost' => 42,
			'meetupDate' => '2018-08-31',
			'allowUnisexRooms' => false,
			'nightHike' => array(
				'places' => 18
			),
			'payment' => array(
				'paypal' => '',
				'bankTransfer' => array(
					'recipient' => '',
					'iban' => '',
					'bic' => ''
				)
			)
		)
	);
?>
