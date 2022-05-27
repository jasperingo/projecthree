<?php
namespace Jasper\Projecthree\Controllers;

use Slim\Views\PhpRenderer;

class BaseController {

  public function __construct(protected PhpRenderer $renderer)
  {
    $this->renderer->setLayout('layout.php');
  }

}
