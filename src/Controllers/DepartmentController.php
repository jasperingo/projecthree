<?php
namespace Jasper\Projecthree\Controllers;

use function strtoupper;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Jasper\Projecthree\Models\Department;
use Jasper\Projecthree\Models\Project;

class DepartmentController extends BaseController {

  public function index(Response $response) 
  {
    $departments = $this->entityManager->getRepository(Department::class)->findAll();

    return $this->renderer->render($response, 'department/index.php', [
      'title' => 'Departments',
      'departments' =>  $departments,
    ]);
  }

  public function add(Response $response) 
  {
    return $this->renderer->render($response, 'department/create.php', [
      'title' => 'Add_department',
      'name' => $this->session->getFlash('name'),
      'acronym' => $this->session->getFlash('acronym'),
      'form_error' => $this->session->getFlash('form_error'),
      'name_error' => $this->session->getFlash('name_error'),
      'acronym_error' => $this->session->getFlash('acronym_error'),
    ]);
  }

  public function create(Request $request, Response $response) 
  {
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

  public function edit(Request $request, Response $response) 
  {
    $department = $request->getAttribute('department');

    return $this->renderer->render($response, 'department/update.php', [
      'title' => 'Edit_department',
      'data' => $department,
      'form_error' => $this->session->getFlash('form_error'),
      'form_success' => $this->session->getFlash('form_success'),
      'name_error' => $this->session->getFlash('name_error'),
      'acronym_error' => $this->session->getFlash('acronym_error'),
    ]);
  }

  public function update(Request $request, Response $response) 
  {
    $data = $request->getParsedBody();

    $department = $request->getAttribute('department');

    $department->name = $data['name'];
    $department->acronym = strtoupper($data['acronym']);

    $this->entityManager->getRepository(Department::class)->save($department);
    
    $this->session->setFlash('form_success', 'Department_updated');
    
    return $response
      ->withHeader('Location', "/departments/{$department->id}/update")
      ->withStatus(302);
  }

  public function read(Request $request, Response $response) 
  {
    $department = $request->getAttribute('department');

    $projects = $this->entityManager->
      getRepository(Project::class)->
      findBy(['department' => $department]);

    return $this->renderer->render($response, 'department/department.php', [
      'title' => $department->name,
      'data' => $department,
      'projects' => $projects,
    ]);
  }
}
