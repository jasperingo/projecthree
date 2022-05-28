<?php
namespace Jasper\Projecthree\Routes;

use Slim\Routing\RouteCollectorProxy;
use Jasper\Projecthree\Controllers\AuthController;
use Jasper\Projecthree\Middlewares\Validators\LoginValidatorMiddleware;
use Jasper\Projecthree\Middlewares\Auth\GuestMiddleware;
use Jasper\Projecthree\Middlewares\Auth\AuthMiddleware;

class AuthRoute {

  public function __invoke(RouteCollectorProxy $route)
  {
    $route->get('/login', [AuthController::class, 'login'])
      ->add(GuestMiddleware::class);

    $route->post('/login', [AuthController::class, 'create'])
      ->add(LoginValidatorMiddleware::class)
      ->add(GuestMiddleware::class);

    $route->get('/logout', [AuthController::class, 'logout'])
      ->add(AuthMiddleware::class);

    $route->post('/logout', [AuthController::class, 'delete'])
      ->add(AuthMiddleware::class);
  }
}
