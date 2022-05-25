<?php
namespace Jasper\Projecthree\Controllers;

use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Aura\Session\Segment as SessionSegment;
use Doctrine\ORM\EntityManager;
// use Jasper\Projecthree\Models\User;

class UsersController extends BaseController {

  public function __construct(PhpRenderer $renderer)
  {
    parent::__construct($renderer);
  }

  public function create(Response $response, SessionSegment $session) 
  {
    return $this->renderer->render($response, "user/create.php", [
      'title' => 'register',
      'form_error' => '',
      'first_name' => $session->get('first_name'),
      'last_name' => $session->get('last_name'),
      'email' => 'jasperanels@gmail.com',
    ]);
  }

  public function store(Request $request, Response $response, EntityManager $em)
  {
    $request->getBody();
  }
}
