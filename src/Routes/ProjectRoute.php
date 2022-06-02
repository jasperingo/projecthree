<?php
namespace Jasper\Projecthree\Routes;

use Slim\Routing\RouteCollectorProxy;
use Jasper\Projecthree\Controllers\ProjectController;
use Jasper\Projecthree\Middlewares\Auth\AuthMiddleware;
use Jasper\Projecthree\Middlewares\Validators\ProjectCreateValidatorMiddleware;
use Jasper\Projecthree\Middlewares\Fetch\ProjectFetchMiddleware;
use Jasper\Projecthree\Middlewares\Permissions\ProjectUpdatePermissionMiddleware;
use Jasper\Projecthree\Middlewares\Validators\ProjectUpdateValidatorMiddleware;
use Jasper\Projecthree\Middlewares\Validators\CollaboratorCreateValidatorMiddleware;

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

    $route->get('/{id}/update', [ProjectController::class, 'edit'])
      ->add(ProjectUpdatePermissionMiddleware::class)
      ->add(ProjectFetchMiddleware::class)
      ->add(AuthMiddleware::class);

    $route->post('/{id}/update', [ProjectController::class, 'update'])
      ->add(ProjectUpdateValidatorMiddleware::class)
      ->add(ProjectUpdatePermissionMiddleware::class)
      ->add(ProjectFetchMiddleware::class)
      ->add(AuthMiddleware::class);

    $route->post('/{id}/collaborator/create', [ProjectController::class, 'createCollaborator'])
      ->add(CollaboratorCreateValidatorMiddleware::class)
      ->add(ProjectUpdatePermissionMiddleware::class)
      ->add(ProjectFetchMiddleware::class)
      ->add(AuthMiddleware::class);
  }
  
}
