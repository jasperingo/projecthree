<?php
namespace Jasper\Projecthree\Routes;

use Slim\Routing\RouteCollectorProxy;
use Jasper\Projecthree\Controllers\ProjectController;
use Jasper\Projecthree\Middlewares\Auth\AuthMiddleware;

class ProjectRoute {

  public function __invoke(RouteCollectorProxy $route)
  {
    $route->get('/create', [ProjectController::class, 'add'])
      ->add(AuthMiddleware::class);

    $route->post('/create', [ProjectController::class, 'create'])
      ->add(AuthMiddleware::class);

    $route->get('/{id}', [ProjectController::class, 'read']);
  }
  
}
