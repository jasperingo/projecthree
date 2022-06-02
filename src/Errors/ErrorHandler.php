<?php
namespace Jasper\Projecthree\Errors;

use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Views\PhpRenderer;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;

class ErrorHandler extends SlimErrorHandler
{

  public function __construct(private PhpRenderer $viewRenderer, App $app)
  {
    parent::__construct($app->getCallableResolver(), $app->getResponseFactory());
    $this->viewRenderer->setLayout('layout.php');
  }

  protected function respond(): ResponseInterface
  {
      $response = $this->responseFactory->createResponse();

      return $this->viewRenderer->render($response, 'error.php', [
        'title' => "{$this->statusCode} Error",
        'code' => $this->statusCode,
        'smallHeader' => $this->statusCode,
        'message' => $this->exception->getMessage(),
        'stack' => $this->exception->getTrace()
      ]);
  }
}
