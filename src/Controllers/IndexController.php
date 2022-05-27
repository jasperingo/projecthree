<?php
namespace Jasper\Projecthree\Controllers;

use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends BaseController {

  public function index(Response $response) 
  {
    return $this->renderer->render($response, 'index.php', ['title' => 'app_name']);
  }

  public function menu(Response $response) 
  {
    return $this->renderer->render($response, 'menu.php', ['title' => 'Menu']);
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
