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

class LoginValidatorMiddleware {

  public function __construct(
    private Segment $session, 
    private EntityManager $entityManager
  ) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $error = false;

    $user = null;

    $data = (array) $request->getParsedBody();

    $notEmpty = new NotEmpty;

    $email = new ValidatorChain;
    $email->attach($notEmpty, true);
    $email->attach(new EmailAddress);
    
    if (!$email->isValid($data['email'])) {
      $error = true;
    }

    $password = new ValidatorChain;
    $password->attach($notEmpty, true);
    $password->attach(new StringLength(['min' => 5, 'max' => 15]));

    if (!$password->isValid($data['password'])) {
      $error = true;
    }

    if (!$error) {
      $user = $this->entityManager->getRepository(User::class)->findOneByEmail($data['email']);

      if ($user === null || ((object) $user)->password !== $data['password']) {
        $error = true;
      }
    }
    
    if ($error) {
      $this->session->setFlash('email', $data['email']);
      $this->session->setFlash('form_error', 'Incorrect_email_or_password');

      return (new Response)
        ->withHeader('Location', '/auth/login')
        ->withStatus(302);
    }
    
    return $handler->handle($request->withAttribute('user', $user));
  }
}
