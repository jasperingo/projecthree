<?php
namespace Jasper\Projecthree\Controllers;

use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;

class UsersController {

  protected PhpRenderer $renderer;

  public function __construct(PhpRenderer $renderer)
  {
    $this->renderer = $renderer;
  }

  public function __invoke(Response $response) 
  {
    return $this->renderer->render($response, "index.php");
  }
}
