<?php
namespace Jasper\Projecthree\Middlewares\Auth;

use Slim\Psr7\Response;
use Aura\Session\Segment;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class GuestMiddleware {
  public function __construct(private Segment $session) {}

  public function __invoke(Request $request, RequestHandler $handler) 
  {
    $user = $this->session->get('user');
    
    if ($user !== null) {
      return (new Response)
        ->withHeader('Location', "/users/{$user->id}")
        ->withStatus(302);
    }

    return $handler->handle($request);
  }
}
