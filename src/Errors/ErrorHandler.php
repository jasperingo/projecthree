<?php
namespace Jasper\Projecthree\Errors;

use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Views\PhpRenderer;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;

class ErrorHandler extends SlimErrorHandler
{

  private PhpRenderer $viewRenderer;

  public function __construct(App $app, PhpRenderer $viewRenderer)
  {
    parent::__construct($app->getCallableResolver(), $app->getResponseFactory());
    $this->viewRenderer = $viewRenderer;
  }

  protected function respond(): ResponseInterface
  {
      $response = $this->responseFactory->createResponse();

      return $this->viewRenderer->render($response, 'error.php', [
        'code' => $this->statusCode,
        'message' => $this->exception->getMessage(),
        'stack' => $this->exception->getTrace()
      ]);
  }
}
