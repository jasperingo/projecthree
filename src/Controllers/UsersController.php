<?php
namespace Jasper\Projecthree\Controllers;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Jasper\Projecthree\Models\User;
use Slim\Exception\HttpNotFoundException;

class UsersController extends BaseController {

  public function create(Response $response) 
  {
    return $this->renderer->render($response, "user/create.php", [
      'title' => 'register',
      'first_name' => $this->session->getFlash('first_name'),
      'last_name' => $this->session->getFlash('last_name'),
      'email' => $this->session->getFlash('email'),
      'form_error' => $this->session->getFlash('form_error'),
      'first_name_error' => $this->session->getFlash('first_name_error'),
      'last_name_error' => $this->session->getFlash('last_name_error'),
      'email_error' => $this->session->getFlash('email_error'),
      'password_error' => $this->session->getFlash('password_error'),
      'password_confirmation_error' => $this->session->getFlash('password_confirmation_error'),
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

    $this->session->set('user', $user);
    
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
      'title' => ((object) $user)->getFullName(), 
      'data' => $user
    ]);
  }
}
