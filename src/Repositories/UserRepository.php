<?php
namespace Jasper\Projecthree\Repositories;

use Doctrine\ORM\EntityRepository;
use Jasper\Projecthree\Models\User;

class UserRepository extends EntityRepository {

  public function save(User $user) {
    $this->getEntityManager()->persist($user);
    $this->getEntityManager()->flush();
  }

  public function existsByEmail(string $email) {
    $user = $this->findOneBy(['email' => $email]);
    return $user !== null;
  }

}
