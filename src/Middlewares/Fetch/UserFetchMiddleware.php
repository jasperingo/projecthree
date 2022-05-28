<?php
namespace Jasper\Projecthree\Middlewares\Fetch;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
use Doctrine\ORM\EntityManager;
use Slim\Exception\HttpNotFoundException;
use Jasper\Projecthree\Models\User;

class UserFetchMiddleware {

  public function __construct(private EntityManager $entityManager) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $routeContext = RouteContext::fromRequest($request);
    $userId = (int) $routeContext->getRoute()->getArgument('id');

    $user = $this->entityManager->getRepository(User::class)->find($userId);

    if ($user === null) {
      throw new HttpNotFoundException($request);
    }

    return $handler->handle($request->withAttribute('user', $user));
  }
}
