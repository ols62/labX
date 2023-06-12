<?php

declare(strict_types=1);

namespace App\Application\Services;


use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use App\Application\Services\Service;
use \App\Domain\Entity\Instock;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;




class InstockService extends Service
{

  protected $repository;


  function __construct(LoggerInterface $logger, EntityManager $em )
  {
    parent::__construct($logger);
    $this->repository = $em->getRepository(Instock::class);
  }

    /**
   * @throws HttpNotFoundException
   * @throws HttpBadRequestException
   */
  public function getAll(ServerRequestInterface $request, ResponseInterface $response, array $args): Response
  {
    $result = $this->repository->findAll();
    $arrayVar = array();
    foreach ($result as $item) {
      array_push($arrayVar, $item->toArray());
    }
    return $this->respondWithData($response,$arrayVar);
  }
}