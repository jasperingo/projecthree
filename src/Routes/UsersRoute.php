<?php
namespace Jasper\Projecthree\Routes;

use Slim\Routing\RouteCollectorProxy;
use Jasper\Projecthree\Controllers\UsersController;
use Jasper\Projecthree\Middlewares\Validators\UserCreateValidatorMiddleware;
use Jasper\Projecthree\Middlewares\Auth\GuestMiddleware;

class UsersRoute {

  public function __invoke(RouteCollectorProxy $route)
  {
    $route->get('/create', [UsersController::class, 'create'])
      ->add(GuestMiddleware::class);

    $route->post('/create', [UsersController::class, 'store'])
      ->add(GuestMiddleware::class)
      ->add(UserCreateValidatorMiddleware::class);

    $route->get('/{id}', [UsersController::class, 'read']);
  }
}
