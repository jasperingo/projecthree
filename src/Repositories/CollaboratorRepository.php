<?php
namespace Jasper\Projecthree\Repositories;

use Doctrine\ORM\EntityRepository;
use Jasper\Projecthree\Models\Collaborator;

class CollaboratorRepository extends EntityRepository {

  public function save(Collaborator $collaborator) {
    $this->getEntityManager()->persist($collaborator);
    $this->getEntityManager()->flush();
  }

  public function findWithProjectByUserId(int $userId) {
    $query = $this->getEntityManager()->createQuery(
      'SELECT c, p FROM '. Collaborator::class .' c JOIN c.project p JOIN c.user u WHERE u.id = :id1'
    );
    $query->setParameter('id1', $userId);
    return $query->getResult();
  }
}
