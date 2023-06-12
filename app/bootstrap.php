<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new ContainerBuilder();
$settings = require __DIR__ . '/settings.php';
$settings($container);
$dependencies = require __DIR__ . '/dependencies.php';
$dependencies($container);
$container = $container->build();

AppFactory::setContainer($container);
$app = AppFactory::create();

// Register routes
$routes = require __DIR__ . '/routes.php';
$routes($app);
// Add  Middlewares
$middleware = require __DIR__ . '/middleware.php';
$middleware($app);

// Add  Error handlers
$middleware = require __DIR__ . '/errors.php';
$middleware($app);

//$app->setBasePath('/public-html');

$app->run();