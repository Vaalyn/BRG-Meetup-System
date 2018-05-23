<?php

return [
	'settings' => [
		'determineRouteBeforeAppMiddleware' => true,
		'displayErrorDetails' => false,
		'routerCacheFile' => __DIR__ . '/../files/cache/fast-route-cache.php'
	],
	'config' => [
		'session' => [
			'name'     => 'BRG_MEETUP_SESSID',
			'lifetime' => 1200,
			'path'     => '/',
			'domain'   => 'localhost',
			'secure'   => true,
			'httponly' => true
		],
		'database' => [
			'driver'    => '',
			'host' 	    => '',
			'database' 	=> '',
			'username' 	=> '',
			'password' 	=> '',
			'charset'   => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix'    => '',
			'port'      => 3306
		],
		'auth' => [
			'cookie' => [
				'name'     => 'remember',
				'expire'   => 2592000,
				'domain'   => '',
				'secure'   => true,
				'httponly' => true
			],
			'routes' => require_once __DIR__ . '/routePermissions.php',
			'local' => []
		],
		'flysystem' => [
			'files' => [
				'adapter' => 'League\Flysystem\Adapter\Local',
				'arguments' => [
					__DIR__ . '/../files'
				],
				'config' => []
			],
			'gallery' => [
				'adapter' => 'League\Flysystem\Adapter\Local',
				'arguments' => [
					__DIR__ . '/../public/img/meetup'
				],
				'config' => []
			]
		],
		'recaptcha' => [
			'key' => '',
			'secret' => ''
		],
		'maps' => [
			'key' => ''
		],
		'mailer' => [
			'from' => '',
			'fromAddress' => '',
			'username' => '',
			'password' => '',
			'host' => '',
			'port' => 587,
			'security' => 'tls',
			'authMode' => 'login'
		],
		'meetupCost' => 42,
		'meetupDate' => '2018-08-31',
		'allowUnisexRooms' => false,
		'nightHike' => [
			'places' => 18
		],
		'payment' => [
			'paypal' => '',
			'bankTransfer' => [
				'recipient' => '',
				'iban' => '',
				'bic' => ''
			]
		]
	]
];
