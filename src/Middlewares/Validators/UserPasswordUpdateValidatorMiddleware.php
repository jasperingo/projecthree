<?php
namespace Jasper\Projecthree\Middlewares\Validators;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Aura\Session\Segment;
use Doctrine\ORM\EntityManager;
use Laminas\Validator\ValidatorChain;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;
use Laminas\Validator\Identical;

class UserPasswordUpdateValidatorMiddleware {
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

    $password = new ValidatorChain;
    $password->attach($notEmpty, true);
    $password->attach(
      (new StringLength(['min' => 5, 'max' => 15]))->setMessage('error_Password_incorrect'),
      true
    );
    $password->attach(
      (new Identical($user->password))->setMessage('error_Password_incorrect')
    );

    if (!$password->isValid($data['password'])) {
      $error = true;
      foreach ($password->getMessages() as $message) {
        $this->session->setFlash('password_error', $message);
      }
    }

    $newPassword = new ValidatorChain;
    $newPassword->attach($notEmpty, true);
    $newPassword->attach(
      (new StringLength(['min' => 5, 'max' => 15]))
        ->setMessage('error_Password_short', StringLength::TOO_SHORT)
        ->setMessage('error_Password_long', StringLength::TOO_LONG), 
      true
    );
    $newPassword->attach(
      (new Identical($data['new_password_confirmation']))->setMessage('error_Password_unmatch')
    );

    if (!$newPassword->isValid($data['new_password'])) {
      $error = true;
      foreach ($newPassword->getMessages() as $message) {
        $this->session->setFlash('new_password_error', $message);
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
