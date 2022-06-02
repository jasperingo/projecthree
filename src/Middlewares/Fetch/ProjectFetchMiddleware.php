<?php
namespace Jasper\Projecthree\Middlewares\Fetch;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
use Jasper\Projecthree\Models\Project;
use Slim\Exception\HttpNotFoundException;

class ProjectFetchMiddleware {
  public function __construct(private EntityManager $entityManager) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $routeContext = RouteContext::fromRequest($request);
    $projectId = (int) $routeContext->getRoute()->getArgument('id');

    $project = $this->entityManager->getRepository(Project::class)->find($projectId);

    if ($project === null) {
      throw new HttpNotFoundException($request);
    }

    return $handler->handle($request->withAttribute('project', $project));
  }
}
