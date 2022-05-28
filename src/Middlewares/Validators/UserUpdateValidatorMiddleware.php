<?php
namespace Jasper\Projecthree\Middlewares\Validators;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Aura\Session\Segment;
use Doctrine\ORM\EntityManager;
use Laminas\Validator\ValidatorChain;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\EmailAddress;
use Jasper\Projecthree\Validators\EmailUniqueValidator;

class UserUpdateValidatorMiddleware {
  public function __construct(
    private Segment $session, 
    private EntityManager $entityManager
  ) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $error = false;
    
    $user = $this->session->get('user');

    $data = (array) $request->getParsedBody();

    $notEmpty = (new NotEmpty)->setMessage('Field_is_required');

    $firstName = new ValidatorChain;
    $firstName->attach($notEmpty);

    if (!$firstName->isValid($data['first_name'])) {
      $error = true;
      foreach ($firstName->getMessages() as $message) {
        $this->session->setFlash('first_name_error', $message);
      }
    }

    $lastName = new ValidatorChain;
    $lastName->attach($notEmpty);

    if (!$lastName->isValid($data['last_name'])) {
      $error = true;
      foreach ($lastName->getMessages() as $message) {
        $this->session->setFlash('last_name_error', $message);
      }
    }

    $email = new ValidatorChain;
    $email->attach($notEmpty, true);
    $email->attach((new EmailAddress)->setMessage('error_Email_invalid'), true);
    if ($user->email !== $data['email']) {
      $email->attach(
        (new EmailUniqueValidator)
          ->setEntityManager($this->entityManager)
          ->setMessage('error_Email_exists')
      );
    }
    
    if (!$email->isValid($data['email'])) {
      $error = true;
      foreach ($email->getMessages() as $message) {
        $this->session->setFlash('email_error', $message);
      }
    }
    
    if ($error) {
      return (new Response)
        ->withHeader('Location', "/users/{$user->id}/update")
        ->withStatus(302);
    }

    return $handler->handle($request);
  }
}
