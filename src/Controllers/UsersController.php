<?php
namespace Jasper\Projecthree\Controllers;

use DateTime;
use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Aura\Session\Segment as SessionSegment;
use Doctrine\ORM\EntityManager;
use Jasper\Projecthree\Models\User;
use Slim\Exception\HttpNotFoundException;

class UsersController extends BaseController {

  public function __construct(private EntityManager $entityManager, PhpRenderer $renderer)
  {
    parent::__construct($renderer);
  }

  public function create(Response $response, SessionSegment $session) 
  {
    return $this->renderer->render($response, "user/create.php", [
      'title' => 'register',
      'first_name' => $session->getFlash('first_name'),
      'last_name' => $session->getFlash('last_name'),
      'email' => $session->getFlash('email'),
      'form_error' => $session->getFlash('form_error'),
      'first_name_error' => $session->getFlash('first_name_error'),
      'last_name_error' => $session->getFlash('last_name_error'),
      'email_error' => $session->getFlash('email_error'),
      'password_error' => $session->getFlash('password_error'),
      'password_confirmation_error' => $session->getFlash('password_confirmation_error'),
    ]);
  }

  public function store(Request $request, Response $response)
  {
    $data = $request->getParsedBody();

    $user = new User;
    $user->firstName = $data['first_name'];
    $user->lastName = $data['last_name'];
    $user->email = $data['email'];
    $user->password = $data['password'];
    $user->createdAt = new DateTime;

    $this->entityManager->getRepository(User::class)->save($user);
    
    return $response
      ->withHeader('Location', "/users/{$user->id}")
      ->withStatus(302);
  }

  public function read(Request $request, Response $response, int $id) {
    $user = $this->entityManager->getRepository(User::class)->find($id);

    if ($user === null) {
      throw new HttpNotFoundException($request);
    }

    return $this->renderer->render($response, "user/user.php", [
      'title' => ((object) $user)->firstName, 
      'data' => $user
    ]);
  }
}
