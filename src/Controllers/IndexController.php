<?php
namespace Jasper\Projecthree\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Jasper\Projecthree\Models\Project;
use Jasper\Projecthree\Models\Department;

class IndexController extends BaseController {

  public function index(Response $response) 
  {

    $projects = $this->entityManager
      ->getRepository(Project::class)
      ->findBy([], orderBy: ['createdAt' => 'DESC'], limit: 6);
    
    $departments = $this->entityManager
      ->getRepository(Department::class)
      ->findBy([], orderBy: ['createdAt' => 'DESC'], limit: 6);

    return $this->renderer->render($response, 'index.php', [
      'title' => 'app_name',
      'projects' => $projects,
      'departments' => $departments,
    ]);
  }

  public function menu(Response $response) 
  {
    return $this->renderer->render($response, 'menu.php', ['title' => 'Menu']);
  }

  public function about(Response $response)
  {
    return $this->renderer->render($response, 'about/about.php', [
      'title' => 'about',
      'smallHeader' => 'app_name',
    ]);
  }

  public function faq(Response $response)
  {
    return $this->renderer->render($response, 'about/faq.php', [
      'title' => 'faq',
      'smallHeader' => 'app_name',
    ]);
  }

  public function terms(Response $response)
  {
    return $this->renderer->render($response, 'about/terms.php', [
      'title' => 'terms',
      'smallHeader' => 'app_name',
    ]);
  }

  public function search(Request $request, Response $response) 
  {
    $projects = [];

    $query = $request->getQueryParams();

    if (isset($query['q'])) {
      $projects = $this->entityManager->getRepository(Project::class)->findBySearch($query['q']);
    }

    return $this->renderer->render($response, 'search.php', [
      'title' => 'search',
      'projects' => $projects,
    ]);
  }
}
