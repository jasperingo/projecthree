<?php
namespace Jasper\Projecthree\Controllers;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Jasper\Projecthree\Models\User;

class UsersController extends BaseController {

  public function register(Response $response) 
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
    ]);
  }

  public function create(Request $request, Response $response)
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

  public function read(Request $request, Response $response) {
    $user = $request->getAttribute('user');

    return $this->renderer->render($response, "user/user.php", [
      'title' => ((object) $user)->getFullName(), 
      'data' => $user
    ]);
  }

  public function edit(Request $request, Response $response) {
    $user = $request->getAttribute('user');

    return $this->renderer->render($response, "user/update.php", [
      'title' => $user->getFullName(), 
      'data' => $user,
      'profile_form_error' => $this->session->getFlash('profile_form_error'),
      'password_form_error' => $this->session->getFlash('password_form_error'),
      'profile_form_success' => $this->session->getFlash('profile_form_success'),
      'password_form_success' => $this->session->getFlash('password_form_success'),
      'first_name_error' => $this->session->getFlash('first_name_error'),
      'last_name_error' => $this->session->getFlash('last_name_error'),
      'email_error' => $this->session->getFlash('email_error'),
      'password_error' => $this->session->getFlash('password_error'),
      'new_password_error' => $this->session->getFlash('new_password_error'),
    ]);
  }

  public function update(Request $request, Response $response) {
    $data = $request->getParsedBody();

    $user = $request->getAttribute('user');

    $user->email = $data['email'];
    $user->lastName = $data['last_name'];
    $user->firstName = $data['first_name'];

    $this->entityManager->getRepository(User::class)->save($user);
    
    $this->session->set('user', $user);
    $this->session->setFlash('profile_form_success', 'Profile_updated');
    
    return $response
      ->withHeader('Location', "/users/{$user->id}/update")
      ->withStatus(302);
  }

  public function updatePassword(Request $request, Response $response) {
    $data = $request->getParsedBody();

    $user = $request->getAttribute('user');

    $user->password = $data['new_password'];

    $this->entityManager->getRepository(User::class)->save($user);
    
    $this->session->set('user', $user);
    $this->session->setFlash('password_form_success', 'Password_updated');
    
    return $response
      ->withHeader('Location', "/users/{$user->id}/update")
      ->withStatus(302);
  }
}
