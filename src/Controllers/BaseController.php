<?php
namespace Jasper\Projecthree\Controllers;

use Slim\Views\PhpRenderer;
use Doctrine\ORM\EntityManager;
use Aura\Session\Segment as SessionSegment;

class BaseController {

  public function __construct(
    protected PhpRenderer $renderer,
    protected EntityManager $entityManager, 
    protected SessionSegment $session,
  ) {
    $this->renderer->setLayout('layout.php');
  }

}
