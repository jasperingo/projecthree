<?php
namespace Jasper\Projecthree\Middlewares\Fetch;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
use Jasper\Projecthree\Models\Department;
use Slim\Exception\HttpNotFoundException;

class DepartmentFetchMiddleware {
  public function __construct(private EntityManager $entityManager) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $routeContext = RouteContext::fromRequest($request);
    $departmentId = (int) $routeContext->getRoute()->getArgument('id');

    $department = $this->entityManager->getRepository(Department::class)->find($departmentId);

    if ($department === null) {
      throw new HttpNotFoundException($request);
    }

    return $handler->handle($request->withAttribute('department', $department));
  }
}
