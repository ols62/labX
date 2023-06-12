<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true,
                'logError' => true,
                'logErrorDetails' => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'connectionParams' => [
                    'dbname' => 'labx',
                    'user' => '****',
                    'password' => '***',
                    'host' => 'localhost',
                    'port' => '3306',
                    'driver' => 'pdo_mysql',
                    'charset' => 'utf8',
                ],
                'pwSalt' => 'CrOK|9fB1=;-U#/E8i"^>}APHzrWhH.M+0CSM$*hC=mo!904XHgVZYeRjoBK9CT',
            ]);
        },
    ]);
};