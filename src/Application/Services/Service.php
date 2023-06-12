<?php

declare(strict_types=1);

namespace App\Application\Services;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;


abstract class Service
{
  protected LoggerInterface $logger;


  public function __construct(LoggerInterface $logger)
  {
    $this->logger = $logger;
  }


  /**
   * @return array|object
   */
  protected function getFormData(Request $request)
  {
    return $request->getParsedBody();
  }

  /**
   * @return mixed
   * @throws HttpBadRequestException
   */
  protected function resolveArg(string $name,Request $request, array $args)
  {
    if (!isset($args[$name])) {
      throw new HttpBadRequestException($request, "Could not resolve argument `{$name}`.");
    }
    return $args[$name];
  }

  /**
   * @param array|object|null $data
   */
  protected function respondWithData(Response $Response, $data = null, int $statusCode = 200, ): Response
  {
    $payload = new ServicePayload($statusCode, $data);

    return $this->respond($payload, $Response);
  }

  protected function respond(ServicePayload $payload,Response $response): Response
  {
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $response->getBody()->write($json);
    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus($payload->getStatusCode());
  }
}