<?php
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Response;

return function (App $app) {

  $app->add(function (ServerRequestInterface $request, RequestHandlerInterface $handler) {
    try {
      return $handler->handle($request);
    } catch (HttpNotFoundException $httpException) {
      $response = (new Response())->withStatus(404);
      $response->getBody()->write('404 Not found');
      return $response;
    }
  });

  $app->add(function (ServerRequestInterface $request, RequestHandlerInterface $handler) {
    try {
      return $handler->handle($request);
    } catch (HttpMethodNotAllowedException $httpException) {
      $response = (new Response())->withStatus(404);
      $response->getBody()->write('404 Not found');
      return $response;
    }
  });
};
