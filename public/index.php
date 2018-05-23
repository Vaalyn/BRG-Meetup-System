<?php

require '../vendor/autoload.php';

use Service\ErrorHandler\ErrorHandler;
use Service\Factory\Eloquent\EloquentFactory;
use Service\Factory\Flysystem\FlysystemFactory;
use Service\Mailer\Mailer;
use Slim\Views\PhpRenderer;

$app = new \Slim\App(require_once __DIR__ . '/../config/config.php');

$container                    = $app->getContainer();
$container['auth']            = new \Service\Auth\Auth($container);
$container['database']        = EloquentFactory::create($container->config['database']);
$container['errorHandler']    = new ErrorHandler();
$container['gallery']         = FlysystemFactory::create($container->config['flysystem']['gallery']);
$container['mailer']          = new Mailer($container->config['mailer']);
$container['phpErrorHandler'] = new ErrorHandler();
$container['renderer']        = new PhpRenderer('../template');

$app->add(new Middleware\Auth\AuthMiddleware($container));
$app->add(new Middleware\Session\SessionMiddleware($container));
$app->add(new RKA\Middleware\IpAddress(false, []));

require_once '../config/routes.php';

$app->run();
