<?php
namespace Jasper\Projecthree\Middlewares\Validators;

use Slim\Psr7\Response;
use Aura\Session\Segment;
use Doctrine\ORM\EntityManager;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\ValidatorChain;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Jasper\Projecthree\Validators\DepartmentIdExistsValidator;
use Laminas\Validator\File\UploadFile;
use Laminas\Validator\File\Extension;

class ProjectUpdateValidatorMiddleware {
  public function __construct(
    private Segment $session, 
    private EntityManager $entityManager
  ) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $error = false;

    $project = $request->getAttribute('project');

    $data = (array) $request->getParsedBody();

    $notEmpty = (new NotEmpty)->setMessage('Field_is_required');

    $topic = new ValidatorChain;
    $topic->attach($notEmpty, true);

    if (!$topic->isValid($data['topic'])) {
      $error = true;
      foreach ($topic->getMessages() as $message) {
        $this->session->setFlash('topic_error', $message);
      }
    }

    $description = new ValidatorChain;
    $description->attach($notEmpty, true);

    if (!$description->isValid($data['description'])) {
      $error = true;
      foreach ($description->getMessages() as $message) {
        $this->session->setFlash('description_error', $message);
      }
    }

    $department = new ValidatorChain;
    $department->attach($notEmpty, true);
    $department->attach(
      (new DepartmentIdExistsValidator)
        ->setEntityManager($this->entityManager)
        ->setMessage('error_Department_do_not_exist')
    );

    if (!$department->isValid($data['department_id'])) {
      $error = true;
      foreach ($department->getMessages() as $message) {
        $this->session->setFlash('department_id_error', $message);
      }
    }
    
    $files = $request->getUploadedFiles();

    if (!empty($files['document']->getClientFilename())) {
      $document = new ValidatorChain;
      $document->attach((new UploadFile)->setMessage('Field_is_required'), true);
      $document->attach((new Extension(['pdf']))->setMessage('error_Document_type'));

      if (!$document->isValid($files['document'])) {
        $error = true;
        foreach ($document->getMessages() as $message) {
          $this->session->setFlash('document_error', $message);
        }
      }
    }
    
    if ($error) {
      return (new Response)
        ->withHeader('Location', "/projects/{$project->id}/update")
        ->withStatus(302);
    }

    return $handler->handle($request);
  }

}
