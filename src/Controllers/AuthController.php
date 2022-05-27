<?php
namespace Jasper\Projecthree\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController extends BaseController {

  public function login(Response $response) 
  {
    return $this->renderer->render($response, "auth/login.php", [
      'title' => 'log_in',
      'email' => $this->session->getFlash('email'),
      'form_error' => $this->session->getFlash('form_error'),
    ]);
  }

  public function create(Request $request, Response $response) 
  {
    $user = $request->getAttribute('user');

    $this->session->set('user', $user);
    
    return $response
      ->withHeader('Location', "/users/{$user->id}")
      ->withStatus(302);
  }

  public function logout(Response $response) 
  {
    return $this->renderer->render($response, "auth/logout.php", [
      'title' => 'log_out',
      'email' => $this->session->getFlash('email'),
      'form_error' => $this->session->getFlash('form_error'),
      'email_error' => $this->session->getFlash('email_error'),
      'password_error' => $this->session->getFlash('password_error'),
    ]);
  }

  public function delete(Response $response) 
  {
    $this->session->set('user', null);
    
    return $response
      ->withHeader('Location', "/")
      ->withStatus(302);
  }
}
