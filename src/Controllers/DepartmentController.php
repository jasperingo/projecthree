<?php
namespace Jasper\Projecthree\Controllers;

use function strtoupper;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Jasper\Projecthree\Models\Department;

class DepartmentController extends BaseController {

  public function index(Response $response) 
  {
    return $this->renderer->render($response, 'department/index.php', [
      'title' => 'Departments'
    ]);
  }

  public function add(Response $response) {
    return $this->renderer->render($response, 'department/create.php', [
      'title' => 'Add_department',
      'name' => $this->session->getFlash('name'),
      'acronym' => $this->session->getFlash('acronym'),
      'form_error' => $this->session->getFlash('form_error'),
      'name_error' => $this->session->getFlash('name_error'),
      'acronym_error' => $this->session->getFlash('acronym_error'),
    ]);
  }

  public function create(Request $request, Response $response) {
    $data = $request->getParsedBody();

    $department = new Department;
    $department->name = $data['name'];
    $department->acronym = strtoupper($data['acronym']);
    $department->createdAt = new DateTime;

    $this->entityManager->getRepository(Department::class)->save($department);

    return $response
      ->withHeader('Location', "/departments/{$department->id}")
      ->withStatus(302);
  }

  public function read(Request $request, Response $response) {
    $department = $request->getAttribute('department');

    return $this->renderer->render($response, 'department/department.php', [
      'title' => $department->name,
      'data' => $department,
    ]);
  }
}
