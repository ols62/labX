<?php

declare(strict_types=1);

namespace App\Application\Services;

use DateTime;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use App\Application\Services\Service;
use \App\Domain\Entity\User;
use App\Application\Settings\SettingsInterface;
use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;


class UserService extends Service
{

  protected $repository;
  protected EntityManager $entityManager;

  private ContainerInterface $container;

  function __construct(LoggerInterface $logger, EntityManager $em, ContainerInterface $c)
  {
    parent::__construct($logger);
    $this->entityManager = $em;
    $this->repository = $em->getRepository(User::class);
    $this->container = $c;
  }

  /**
   * @throws HttpNotFoundException
   * @throws HttpBadRequestException
   */
  public function getAll(Request $request, Response $response, array $args): Response
  {
    $result = $this->repository->findAll();
    $arrayVar = array();
    foreach ($result as $item) {
      array_push($arrayVar, $item->toArray());
    }
    return $this->respondWithData($response, $arrayVar);
  }
  /**
   * @throws HttpNotFoundException
   * @throws HttpBadRequestException
   */
  public function getById(Request $request, Response $response, array $args): Response
  {
    $this->logger->info("started processing UserService.getById()");
    $username = $this->resolveArg('username', $request, $args);
    $arrayVar = array();
    $result = $this->repository->findOneBy(array('username' => $username));
    array_push($arrayVar, $result->toArray());
    return $this->respondWithData($response, $arrayVar);
  }

  public function addUser(Request $request, Response $response, array $args): Response
  {
    $message = '';
    $somebody = $this->getFormData($request);
    $this->logger->info("started processing UserService.addUser()");
    $result = $this->repository->findOneBy(array('username' => $somebody['name']));
    if (empty($result)) {
      $user = new User();
      $user->setUsername($somebody['name']);
      $passwd = $somebody['pass'];
      $pass = $this->_encode($passwd);
      $passwd = password_hash($pass, PASSWORD_DEFAULT);
      $user->setPassword($passwd);
      $user->setEmail('test@mail.com');
      $user->setCreated(new DateTime());
      $this->entityManager->persist($user);
      $this->entityManager->flush();
      $message = array('userStatus' => 'registred');
    } else {
      $message = array('userStatus' => 'exist');
    }
    return $this->respondWithData($response, $message, 200);
  }

  public function authUser(Request $request, Response $response, array $args): Response
  {
    $message = '';
    $somebody = $this->getFormData($request);
    $this->logger->info("started processing UserService.authUser() : " . $somebody['name']);
    $result = $this->repository->findOneBy(array('username' => $somebody['name']));
    if (!empty($result)) {
      $pass = $this->_encode($somebody['pass']);
      if (password_verify($pass, $result->getPassword())) {
        if (session_status() !== PHP_SESSION_ACTIVE)
          session_start();
        if (!isset($_SESSION['usrname']))
          $_SESSION['usrname'] = $result->getUsername();
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('main');
        return $response->withHeader('Location', $url)->withStatus(302);
      } else {
        $message = array('userStatus' => 'not verified');
      }
    } else {
      $message = array('userStatus' => 'not found');
    }
    return $this->respondWithData($response, $message, 200);
  }

  public function logoutUser(Request $request, Response $response, array $args): Response
  {
    $this->logger->info("started processing UserService.logoutUser() : " . $_SESSION['usrname']);
    session_unset();
    session_write_close();
    return $response;
  }
  private function _encode($password)
  {
    $settings = $this->container->get(SettingsInterface::class);
    $majorsalt = $settings->get('pwSalt');
    $_pass = str_split($password);

    foreach ($_pass as $_hashpass) {
      $hash = md5($_hashpass);
      $majorsalt .= md5($hash);
    }
    return md5($majorsalt);
  }
}