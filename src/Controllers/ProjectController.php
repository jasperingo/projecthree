<?php
namespace Jasper\Projecthree\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Jasper\Projecthree\Models\Department;

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

}
