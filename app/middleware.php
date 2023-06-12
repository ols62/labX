<?php

declare(strict_types=1);

use App\Application\Middleware\AuthMiddeleware;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Psr\Log\LoggerInterface;
use App\Application\Settings\SettingsInterface;
use Slim\Middleware\MethodOverrideMiddleware;


return function (App $app) {
    $container = $app->getContainer();
    /** @var SettingsInterface $settings */
    $settings = $container->get(SettingsInterface::class);
    $displayErrorDetails = $settings->get('displayErrorDetails');
    $logError = $settings->get('logError');
    $logErrorDetails = $settings->get('logErrorDetails');
    // Add Body Parsing Middleware
    $app->addBodyParsingMiddleware();
    // Add Error Handling Middleware
    $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
    // Add MethodOverride middleware
//    $methodOverrideMiddleware = new MethodOverrideMiddleware();
//    $app->add($methodOverrideMiddleware);
    $logger = $app->getContainer()->get(LoggerInterface::class);
    $app->add(new AuthMiddeleware($logger, $app));
    // Add Twig Middleware     
    $twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
    $app->add(TwigMiddleware::create($app, $twig));
    // Add Routing Middleware
    $app->addRoutingMiddleware();
};