<?php
namespace Jasper\Projecthree\Routes;

use Slim\Routing\RouteCollectorProxy;
use Jasper\Projecthree\Controllers\ProjectController;
use Jasper\Projecthree\Middlewares\Auth\AuthMiddleware;
use Jasper\Projecthree\Middlewares\Validators\ProjectCreateValidatorMiddleware;
use Jasper\Projecthree\Middlewares\Fetch\ProjectFetchMiddleware;

class ProjectRoute {

  public function __invoke(RouteCollectorProxy $route)
  {
    $route->get('/create', [ProjectController::class, 'add'])
      ->add(AuthMiddleware::class);

    $route->post('/create', [ProjectController::class, 'create'])
      ->add(ProjectCreateValidatorMiddleware::class)
      ->add(AuthMiddleware::class);

    $route->get('/{id}', [ProjectController::class, 'read'])
      ->add(ProjectFetchMiddleware::class);
  }
  
}
