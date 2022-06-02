<?php
namespace Jasper\Projecthree\Routes;

use Slim\Routing\RouteCollectorProxy;
use Jasper\Projecthree\Controllers\IndexController;

class IndexRoute {

  public function __invoke(RouteCollectorProxy $route)
  {
    $route->get('/', [IndexController::class, 'index']);
    $route->get('/menu', [IndexController::class, 'menu']);
    $route->get('/about', [IndexController::class, 'about']);
    $route->get('/faq', [IndexController::class, 'faq']);
    $route->get('/terms', [IndexController::class, 'terms']);
    $route->get('/search', [IndexController::class, 'search']);
  }
}
