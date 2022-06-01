<?php
namespace Jasper\Projecthree\Middlewares\Validators;

use Slim\Psr7\Response;
use Aura\Session\Segment;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Laminas\Validator\ValidatorChain;
use Laminas\Validator\NotEmpty;
use Jasper\Projecthree\Validators\DepartmentNameUniqueValidator;
use Jasper\Projecthree\Validators\DepartmentAcronymUniqueValidator;

class DepartmentUpdateValidatorMiddleware {
  public function __construct(
    private Segment $session, 
    private EntityManager $entityManager
  ) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $error = false;

    $department = $request->getAttribute('department');

    $data = (array) $request->getParsedBody();

    $notEmpty = (new NotEmpty)->setMessage('Field_is_required');

    $name = new ValidatorChain;
    $name->attach($notEmpty, true);
    if ($department->name !== $data['name']) {
      $name->attach(
        (new DepartmentNameUniqueValidator)
          ->setEntityManager($this->entityManager)
          ->setMessage('error_Name_exists')
      );
    }

    if (!$name->isValid($data['name'])) {
      $error = true;
      foreach ($name->getMessages() as $message) {
        $this->session->setFlash('name_error', $message);
      }
    }

    $acronym = new ValidatorChain;
    $acronym->attach($notEmpty, true);
    if ($department->acronym !== $data['acronym']) {
      $acronym->attach(
        (new DepartmentAcronymUniqueValidator)
          ->setEntityManager($this->entityManager)
          ->setMessage('error_Acronym_exists')
      );
    }

    if (!$acronym->isValid($data['acronym'])) {
      $error = true;
      foreach ($acronym->getMessages() as $message) {
        $this->session->setFlash('acronym_error', $message);
      }
    }
    
    if ($error) {
      return (new Response)
        ->withHeader('Location', "/departments/{$department->id}/update")
        ->withStatus(302);
    }

    return $handler->handle($request);
  }
}
