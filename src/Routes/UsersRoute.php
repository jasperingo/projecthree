<?php
namespace Jasper\Projecthree\Routes;

use Jasper\Projecthree\Controllers\UsersController;
use Slim\Routing\RouteCollectorProxy;

class UsersRoute {

  public function __invoke(RouteCollectorProxy $route)
  {
    $route->get('/create', [UsersController::class, 'create']);
    $route->post('/create', [UsersController::class, 'store']);
  }
}
