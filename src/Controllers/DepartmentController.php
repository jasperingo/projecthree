<?php
namespace Jasper\Projecthree\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DepartmentController extends BaseController {

  public function index(Response $response) 
  {
    return $this->renderer->render($response, "department/index.php", [
      'title' => 'Departments'
    ]);
  }
}
