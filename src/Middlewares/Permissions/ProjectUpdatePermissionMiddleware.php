<?php
namespace Jasper\Projecthree\Middlewares\Permissions;

use function current;
use function array_filter;

use Aura\Session\Segment;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpForbiddenException;

class ProjectUpdatePermissionMiddleware {
  public function __construct(private Segment $session) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $user = $this->session->get('user');

    $project = $request->getAttribute('project');

    if (
      !current(
        array_filter(
          $project->collaborators->getValues(), 
          fn($collaborator) => $collaborator->user->id === $user->id
        )
      )
    ) {
      throw new HttpForbiddenException($request);
    }

    return $handler->handle($request);
  }
}
