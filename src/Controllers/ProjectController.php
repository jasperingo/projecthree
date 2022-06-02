<?php
namespace Jasper\Projecthree\Controllers;

use function current;
use function array_filter;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Doctrine\ORM\EntityManager;
use Jasper\Projecthree\Models\Department;
use Jasper\Projecthree\Models\Project;
use Jasper\Projecthree\Models\Collaborator;
use Jasper\Projecthree\Models\User;

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

  public function create(Request $request, Response $response) {
    $data = $request->getParsedBody();

    $project = new Project;
    $project->topic = $data['topic'];
    $project->description = $data['description'];
    $project->createdAt = new DateTime;

    $project->department = $this->entityManager
      ->getRepository(Department::class)
      ->find($data['department_id']);

    $this->entityManager->transactional(function (EntityManager $entityManager) use ($project) {
  
      $entityManager->getRepository(Project::class)->save($project);

      $collaborator = new Collaborator;
      $collaborator->project = $project;
      $collaborator->createdAt = new DateTime;
      $collaborator->user =  $entityManager
        ->getRepository(User::class)
        ->find($this->session->get('user')->id);

      $entityManager->getRepository(Collaborator::class)->save($collaborator);
    });

    return $response
      ->withHeader('Location', "/projects/{$project->id}")
      ->withStatus(302);
  }

  public function read(Request $request, Response $response) {
    $project = $request->getAttribute('project');
    
    $user = $this->session->get('user');

    $canEdit = false;

    if (
      $user !== null && 
      current(
        array_filter(
          $project->collaborators->getValues(), 
          fn($collaborator) => $collaborator->user->id === $user->id
        )
      )
    ) {
      $canEdit = true;
    }

    return $this->renderer->render($response, 'project/project.php', [
      'title' => $project->topic,
      'data' => $project,
      'canEdit' => $canEdit,
    ]);
  }
}
