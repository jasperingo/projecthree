<?php
namespace Jasper\Projecthree\Middlewares\Permissions;

use Aura\Session\Segment;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpForbiddenException;

class UserUpdatePermissionMiddleware {
  public function __construct(private Segment $session) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $user = $this->session->get('user');

    $fetchedUser = $request->getAttribute('user');
    
    if ($user->id !== $fetchedUser->id) {
      throw new HttpForbiddenException($request);
    }

    return $handler->handle($request);
  }
}
