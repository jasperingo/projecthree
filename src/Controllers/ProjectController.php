<?php
namespace Jasper\Projecthree\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Jasper\Projecthree\Models\Department;
use Jasper\Projecthree\Models\Project;

class ProjectController extends BaseController {

  public function add(Response $response) {

    $departments = $this->entityManager->getRepository(Department::class)->findAll();

    return $this->renderer->render($response, 'project/create.php', [
      'title' => 'create_project',
      'departments' => $departments,
      'topic' => $this->session->getFlash('topic'),
      'description' => $this->session->getFlash('description'),
      'department_id' => $this->session->getFlash('department_id'),
      'form_error' => $this->session->getFlash('form_error'),
      'topic_error' => $this->session->getFlash('topic_error'),
      'description_error' => $this->session->getFlash('description_error'),
      'department_id_error' => $this->session->getFlash('department_id_error'),
    ]);
  }

  public function create(Response $response) {

    $project = new Project;
    $project->id = 1;

    return $response
      ->withHeader('Location', "/projects/{$project->id}")
      ->withStatus(302);
  }

  public function read(Request $request, Response $response) {
    $project = new Project; //$request->getAttribute('department');
    $project->topic = "Stew effect";
    $project->description = "lkdjnjsdnjkdsf  podasnfdskl dsakanfdskjjf";

    return $this->renderer->render($response, 'project/project.php', [
      'title' => $project->topic,
      'data' => $project,
    ]);
  }
}
