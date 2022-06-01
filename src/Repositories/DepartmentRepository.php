<?php
namespace Jasper\Projecthree\Repositories;

use Doctrine\ORM\EntityRepository;
use Jasper\Projecthree\Models\Department;

class DepartmentRepository extends EntityRepository {
  public function save(Department $department) {
    $this->getEntityManager()->persist($department);
    $this->getEntityManager()->flush();
  }

  public function existsByName(string $name) {
    $department = $this->findOneBy(['name' => $name]);
    return $department !== null;
  }

  public function existsByAcronym(string $acronym) {
    $department = $this->findOneBy(['acronym' => $acronym]);
    return $department !== null;
  }
}
