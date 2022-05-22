<?php
namespace Jasper\Projecthree\Controllers;

use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends BaseController {

  public function __construct(PhpRenderer $renderer)
  {
    parent::__construct($renderer);
  }

  public function index(Response $response) 
  {
    return $this->renderer->render($response, 'index.php', ['title' => 'app_name']);
  }

  private function aboutLayout() {
    $this->renderer->setLayout('about/layout.php');
  }

  public function about(Response $response)
  {
    $this->aboutLayout();
    return $this->renderer->render($response, 'about/about.php', ['title' => 'about']);
  }

  public function faq(Response $response)
  {
    $this->aboutLayout();
    return $this->renderer->render($response, 'about/faq.php', ['title' => 'faq']);
  }

  public function terms(Response $response)
  {
    $this->aboutLayout();
    return $this->renderer->render($response, 'about/terms.php', ['title' => 'terms']);
  }
}
