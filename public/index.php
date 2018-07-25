<?php

require '../vendor/autoload.php';

use BronyRadioGermany\Meetup\Middleware\Auth\AuthMiddleware;
use BronyRadioGermany\Meetup\Middleware\Session\SessionMiddleware;
use BronyRadioGermany\Meetup\Service\Auth\Auth;
use BronyRadioGermany\Meetup\Service\ErrorHandler\ErrorHandler;
use BronyRadioGermany\Meetup\Service\Factory\Eloquent\EloquentFactory;
use BronyRadioGermany\Meetup\Service\Factory\Flysystem\FlysystemFactory;
use BronyRadioGermany\Meetup\Service\Mailer\Mailer;
use Slim\Views\PhpRenderer;

$app = new \Slim\App(require_once __DIR__ . '/../config/config.php');

$container                    = $app->getContainer();
$container['auth']            = new Auth($container);
$container['database']        = EloquentFactory::create($container->config['database']);
$container['errorHandler']    = new ErrorHandler();
$container['gallery']         = FlysystemFactory::create($container->config['flysystem']['gallery']);
$container['mailer']          = new Mailer($container->config['mailer']);
$container['phpErrorHandler'] = new ErrorHandler();
$container['renderer']        = new PhpRenderer('../template');

$app->add(new AuthMiddleware($container));
$app->add(new SessionMiddleware($container));
$app->add(new RKA\Middleware\IpAddress(false, []));

require_once '../config/routes.php';

$app->run();
