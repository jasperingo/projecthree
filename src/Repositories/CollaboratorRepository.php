<?php
namespace Jasper\Projecthree\Repositories;

use Doctrine\ORM\EntityRepository;
use Jasper\Projecthree\Models\Collaborator;

class CollaboratorRepository extends EntityRepository {

  public function save(Collaborator $collaborator) {
    $this->getEntityManager()->persist($collaborator);
    $this->getEntityManager()->flush();
  }

}
