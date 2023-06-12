<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Log\LoggerInterface;
use Slim\App;

class AuthMiddeleware //implements Middleware
{
    protected LoggerInterface $logger;
    protected App $app;
    public function __construct(LoggerInterface $logger, App $app)
    {
        $this->logger = $logger;
        $this->app = $app;
    }
    //public function process(Request $request, RequestHandler $handler): Response
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('login');
        $uri = $request->getUri();
        $path = $uri->getPath();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
            $request = $request->withAttribute('session', $_SESSION);
        }
        $response = $handler->handle($request);
        if (($path != "/login" && $path != "/auth" && $path != "/register") && (!isset($_SESSION['usrname']))) {
            return $response->withHeader('Location', $url)
            ->withStatus(302);
        }
        return  $response;
    }
}