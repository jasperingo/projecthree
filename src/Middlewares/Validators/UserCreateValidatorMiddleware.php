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
use Laminas\Validator\Identical;
use Laminas\Validator\StringLength;
use Jasper\Projecthree\Validators\EmailUniqueValidator;

class UserCreateValidatorMiddleware {

  public function __construct(
    private Segment $session, 
    private EntityManager $entityManager
  ) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $error = false;

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
    $email->attach(
      (new EmailUniqueValidator)
        ->setEntityManager($this->entityManager)
        ->setMessage('error_Email_exists')
    );
    
    if (!$email->isValid($data['email'])) {
      $error = true;
      foreach ($email->getMessages() as $message) {
        $this->session->setFlash('email_error', $message);
      }
    }

    $password = new ValidatorChain;
    $password->attach($notEmpty, true);
    $password->attach(
      (new StringLength(['min' => 5, 'max' => 15]))
        ->setMessage('error_Password_short', StringLength::TOO_SHORT)
        ->setMessage('error_Password_long', StringLength::TOO_LONG), 
      true
    );
    $password->attach(
      (new Identical($data['password_confirmation']))->setMessage('error_Password_unmatch')
    );

    if (!$password->isValid($data['password'])) {
      $error = true;
      foreach ($password->getMessages() as $message) {
        $this->session->setFlash('password_error', $message);
      }
    }
    
    if ($error) {
      $this->session->setFlash('first_name', $data['first_name']);
      $this->session->setFlash('last_name', $data['last_name']);
      $this->session->setFlash('email', $data['email']);
      
      return (new Response)
        ->withHeader('Location', '/users/create')
        ->withStatus(302);
    }

    return $handler->handle($request);
  }
}
