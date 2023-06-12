<?php

declare(strict_types=1);

use App\Application\Services\InstockService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use App\Application\Services\UserService;
use Slim\Views\Twig;


return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'main.html',['name' => isset($_SESSION['usrname']) ? $_SESSION['usrname']: '']);
    })->setName('main');

    $app->get('/login', function (Request $request, Response $response,array $args) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'login.html');
    })->setName('login');

    $app->get('/users', [UserService::class, 'getAll']); 
    $app->get('/user/{username}', [UserService::class, 'getById']);
    $app->post('/register', [UserService::class, 'addUser']);
    $app->post('/auth', [UserService::class, 'authUser']);
    $app->get('/logout', [UserService::class, 'logoutUser']);
    
    $app->get('/instock', [InstockService::class, 'getAll']);
};