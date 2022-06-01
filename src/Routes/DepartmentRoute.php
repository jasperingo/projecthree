<?php
namespace Jasper\Projecthree\Routes;

use Slim\Routing\RouteCollectorProxy;
use Jasper\Projecthree\Controllers\DepartmentController;
use Jasper\Projecthree\Middlewares\Auth\AuthMiddleware;
use Jasper\Projecthree\Middlewares\Validators\DepartmentCreateValidatorMiddleware;
use Jasper\Projecthree\Middlewares\Fetch\DepartmentFetchMiddleware;
use Jasper\Projecthree\Middlewares\Validators\DepartmentUpdateValidatorMiddleware;

class DepartmentRoute {

  public function __invoke(RouteCollectorProxy $route)
  {
    $route->get('/', [DepartmentController::class, 'index']);

    $route->get('/create', [DepartmentController::class, 'add'])
      ->add(AuthMiddleware::class);

    $route->post('/create', [DepartmentController::class, 'create'])
      ->add(DepartmentCreateValidatorMiddleware::class)
      ->add(AuthMiddleware::class);

    $route->get('/{id}', [DepartmentController::class, 'read'])
      ->add(DepartmentFetchMiddleware::class);

    $route->get('/{id}/update', [DepartmentController::class, 'edit'])
      ->add(DepartmentFetchMiddleware::class)
      ->add(AuthMiddleware::class);
    
    $route->post('/{id}/update', [DepartmentController::class, 'update'])
      ->add(DepartmentUpdateValidatorMiddleware::class)
      ->add(DepartmentFetchMiddleware::class)
      ->add(AuthMiddleware::class);
  }

}
