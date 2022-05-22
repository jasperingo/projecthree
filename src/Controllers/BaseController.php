<?php
namespace Jasper\Projecthree\Controllers;

use Slim\Views\PhpRenderer;

class BaseController {

  protected PhpRenderer $renderer;

  public function __construct(PhpRenderer $renderer)
  {
    $this->renderer = $renderer;
    $this->renderer->setLayout('layout.php');
  }

}
