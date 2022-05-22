<?php
namespace Jasper\Projecthree\Controllers;

use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;

class UsersController extends BaseController {

  public function __construct(PhpRenderer $renderer)
  {
    parent::__construct($renderer);
  }

  public function create(Response $response) 
  {
    return $this->renderer->render($response, "user/create.php", [
      'title' => 'register',
      'form_error' => '',
      'first_name' => '',
      'last_name' => '',
      'email' => '',
    ]);
  }

  public function show(Response $response)
  {

  }
}
