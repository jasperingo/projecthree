<?php
namespace Jasper\Projecthree\Routes;

use Slim\Routing\RouteCollectorProxy;
use Jasper\Projecthree\Controllers\UsersController;
use Jasper\Projecthree\Middlewares\Validators\UserCreateValidatorMiddleware;

class UsersRoute {

  public function __invoke(RouteCollectorProxy $route)
  {
    $route->get('/create', [UsersController::class, 'create']);
    $route->post('/create', [UsersController::class, 'store'])->add(UserCreateValidatorMiddleware::class);
    $route->get('/{id}', [UsersController::class, 'read']);
  }
}
