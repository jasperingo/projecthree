<?php
namespace Jasper\Projecthree\Controllers;

use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Aura\Session\Segment as SessionSegment;
use Doctrine\ORM\EntityManager;
use Jasper\Projecthree\Models\User;
use DateTime;

class UsersController extends BaseController {

  public function __construct(private EntityManager $em, PhpRenderer $renderer)
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

  public function store(Request $request, Response $response, EntityManager $em)
  {
    $data = $request->getParsedBody();

    $user = new User;
    $user->firstName = $data['first_name'];
    $user->lastName = $data['last_name'];
    $user->email = $data['email'];
    $user->password = $data['password'];
    $user->createdAt = new DateTime;

    $em->getRepository(User::class)->save($user);
    
    return $this->renderer->render($response, "user/user.php", [
      'title' => $user->firstName, 
      'data' => $user
    ]);
  }
}
