<?php
namespace Jasper\Projecthree\Routes;

use Slim\Routing\RouteCollectorProxy;
use Jasper\Projecthree\Controllers\DepartmentController;

class DepartmentRoute {

  public function __invoke(RouteCollectorProxy $route)
  {
    $route->get('/', [DepartmentController::class, 'index']);
  }

}
