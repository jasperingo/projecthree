<?php
namespace Jasper\Projecthree\Repositories;

use Doctrine\ORM\EntityRepository;
use Jasper\Projecthree\Models\Project;

class ProjectRepository extends EntityRepository {

  public function save(Project $project) {
    $this->getEntityManager()->persist($project);
    $this->getEntityManager()->flush();
  }

}
