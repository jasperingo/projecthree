<?php
namespace Jasper\Projecthree\Middlewares\Validators;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Laminas\Validator\NotEmpty;
use Doctrine\ORM\EntityManager;
use Aura\Session\Segment;
use Laminas\Validator\ValidatorChain;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\StringLength;
use Jasper\Projecthree\Models\User;
use Jasper\Projecthree\Validators\EmailExistsValidator;

class CollaboratorCreateValidatorMiddleware {

  public function __construct(
    private Segment $session, 
    private EntityManager $entityManager
  ) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $error = false;
    
    $project = $request->getAttribute('project');

    $data = (array) $request->getParsedBody();

    $email = new ValidatorChain;
    $email->attach((new NotEmpty)->setMessage('Field_is_required'), true);
    $email->attach((new EmailAddress)->setMessage('error_Email_invalid'), true);
    $email->attach(
      (new EmailExistsValidator)
        ->setEntityManager($this->entityManager)
        ->setMessage('error_Email_not_exist')
    );
    
    if (!$email->isValid($data['collaborator_email'])) {
      $error = true;
      foreach ($email->getMessages() as $message) {
        $this->session->setFlash('collaborator_email_error', $message);
      }
    }

    if ($error) {
      $this->session->setFlash('collaborator_email', $data['collaborator_email']);

      return (new Response)
        ->withHeader('Location', "/projects/{$project->id}/update")
        ->withStatus(302);
    }
    
    return $handler->handle($request);
  }
}
