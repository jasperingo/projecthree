<?php
namespace Jasper\Projecthree\Repositories;

use Doctrine\ORM\EntityRepository;
use Jasper\Projecthree\Models\Project;

class ProjectRepository extends EntityRepository {

  public function save(Project $project) {
    $this->getEntityManager()->persist($project);
    $this->getEntityManager()->flush();
  }

  public function findBySearch(string $param) {
    $query = $this->getEntityManager()->createQuery(
      'SELECT p FROM '. Project::class .' p WHERE p.topic LIKE :topic1'
    );
    $query->setParameter('topic1', "%$param%");
    return $query->getResult();
  }

}
