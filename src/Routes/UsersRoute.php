<?php
namespace Jasper\Projecthree\Routes;

use Slim\Routing\RouteCollectorProxy;
use Jasper\Projecthree\Controllers\UsersController;
use Jasper\Projecthree\Middlewares\Validators\UserCreateValidatorMiddleware;
use Jasper\Projecthree\Middlewares\Auth\GuestMiddleware;
use Jasper\Projecthree\Middlewares\Auth\AuthMiddleware;
use Jasper\Projecthree\Middlewares\Fetch\UserFetchMiddleware;
use Jasper\Projecthree\Middlewares\Permissions\UserUpdatePermissionMiddleware;
use Jasper\Projecthree\Middlewares\Validators\UserUpdateValidatorMiddleware;
use Jasper\Projecthree\Middlewares\Validators\UserPasswordUpdateValidatorMiddleware;

class UsersRoute {

  public function __invoke(RouteCollectorProxy $route)
  {
    $route->get('/create', [UsersController::class, 'register'])
      ->add(GuestMiddleware::class);

    $route->post('/create', [UsersController::class, 'create'])
      ->add(UserCreateValidatorMiddleware::class)
      ->add(GuestMiddleware::class);

    $route->get('/{id}', [UsersController::class, 'read'])
      ->add(UserFetchMiddleware::class);

    $route->get('/{id}/update', [UsersController::class, 'edit'])
      ->add(UserUpdatePermissionMiddleware::class)
      ->add(UserFetchMiddleware::class)
      ->add(AuthMiddleware::class);

    $route->post('/{id}/update', [UsersController::class, 'update'])
      ->add(UserUpdateValidatorMiddleware::class)
      ->add(UserUpdatePermissionMiddleware::class)
      ->add(UserFetchMiddleware::class)
      ->add(AuthMiddleware::class);

    $route->post('/{id}/password/update', [UsersController::class, 'updatePassword'])
      ->add(UserPasswordUpdateValidatorMiddleware::class)
      ->add(UserUpdatePermissionMiddleware::class)
      ->add(UserFetchMiddleware::class)
      ->add(AuthMiddleware::class);
  }
}
