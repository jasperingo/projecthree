<?php
namespace Jasper\Projecthree\Controllers;

use function current;
use function array_filter;
use function sprintf;
use function pathinfo;

use DateTime;
use Psr\Http\Message\UploadedFileInterface as UploadedFile;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Doctrine\ORM\EntityManager;
use Jasper\Projecthree\Models\Department;
use Jasper\Projecthree\Models\Project;
use Jasper\Projecthree\Models\Collaborator;
use Jasper\Projecthree\Models\User;

class ProjectController extends BaseController {

  const DOCUMEMNT_DIR = __DIR__ . '/../../public/res/documents';

  private function saveDocument(UploadedFile $file, Project $project) 
  {
    $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);

    $filename = sprintf('%s.%0.8s', "document-{$project->id}", $extension);

    $file->moveTo(self::DOCUMEMNT_DIR . DIRECTORY_SEPARATOR . $filename);
  }

  public function add(Response $response) 
  {

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
      'document_error' => $this->session->getFlash('document_error'),
    ]);
  }

  public function create(Request $request, Response $response) 
  {
    $data = $request->getParsedBody();

    $file = $request->getUploadedFiles()['document'];

    $project = new Project;
    $project->topic = $data['topic'];
    $project->description = $data['description'];
    $project->createdAt = new DateTime;

    $project->department = $this->entityManager
      ->getRepository(Department::class)
      ->find($data['department_id']);

    $this->entityManager->transactional(function (EntityManager $entityManager) use ($project, $file) {
  
      $entityManager->getRepository(Project::class)->save($project);

      $collaborator = new Collaborator;
      $collaborator->project = $project;
      $collaborator->createdAt = new DateTime;
      $collaborator->user =  $entityManager
        ->getRepository(User::class)
        ->find($this->session->get('user')->id);

      $entityManager->getRepository(Collaborator::class)->save($collaborator);

      $this->saveDocument($file, $project);
    });

    return $response
      ->withHeader('Location', "/projects/{$project->id}")
      ->withStatus(302);
  }

  public function edit(Request $request, Response $response) 
  {
    $project = $request->getAttribute('project');

    $departments = $this->entityManager->getRepository(Department::class)->findAll();

    return $this->renderer->render($response, 'project/update.php', [
      'title' => 'Edit_project',
      'data' => $project,
      'departments' => $departments,
      'form_error' => $this->session->getFlash('form_error'),
      'form_success' => $this->session->getFlash('form_success'),
      'topic_error' => $this->session->getFlash('topic_error'),
      'description_error' => $this->session->getFlash('description_error'),
      'department_id_error' => $this->session->getFlash('department_id_error'),
      'document_error' => $this->session->getFlash('document_error'),
      'collaborator_form_error' => $this->session->getFlash('collaborator_form_error'),
      'collaborator_form_success' => $this->session->getFlash('collaborator_form_success'),
      'collaborator_email' => $this->session->getFlash('collaborator_email'),
      'collaborator_email_error' => $this->session->getFlash('collaborator_email_error'),
    ]);
  }

  public function update(Request $request, Response $response) 
  {
    $data = $request->getParsedBody();

    $file = $request->getUploadedFiles()['document'];

    $project = $request->getAttribute('project');

    $project->topic = $data['topic'];
    $project->description = $data['description'];
    $project->department = $this->entityManager
      ->getRepository(Department::class)
      ->find($data['department_id']);

    if (!empty($file->getClientFilename())) {
      $this->saveDocument($file, $project);
    }

    $this->entityManager->getRepository(Project::class)->save($project);
    
    $this->session->setFlash('form_success', 'Project_updated');
    
    return $response
      ->withHeader('Location', "/projects/{$project->id}/update")
      ->withStatus(302);
  }

  public function createCollaborator(Request $request, Response $response) 
  {
    $data = $request->getParsedBody();

    $project = $request->getAttribute('project');

    $collaborator = new Collaborator;
    $collaborator->project = $project;
    $collaborator->createdAt = new DateTime;
    $collaborator->user =  $this->entityManager
      ->getRepository(User::class)
      ->findOneBy(['email' => $data['collaborator_email']]);

    $this->entityManager->getRepository(Collaborator::class)->save($collaborator);
    
    $this->session->setFlash('collaborator_form_success', 'Collaborator_added');

    return $response
      ->withHeader('Location', "/projects/{$project->id}/update")
      ->withStatus(302);
  }

  public function read(Request $request, Response $response) 
  {
    $project = $request->getAttribute('project');

    $documentName = "document-{$project->id}.pdf";
    
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
      'documentUrl' => "/res/documents/$documentName",
    ]);
  }
}
