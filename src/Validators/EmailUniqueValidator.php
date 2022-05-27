<?php
namespace Jasper\Projecthree\Validators;

use Laminas\Validator\AbstractValidator;
use Doctrine\ORM\EntityManager;
use Jasper\Projecthree\Models\User;

class EmailUniqueValidator extends AbstractValidator {
  const EXISTS = 'exists';

  private EntityManager $entityManager;

  protected $messageTemplates = [
      self::EXISTS => "%value% already exists",
  ];

  public function setEntityManager(EntityManager $entityManager) {
    $this->entityManager = $entityManager;
    return $this;
  }

	public function isValid($value) {
    $this->setValue($value);

    if ($this->entityManager->getRepository(User::class)->existsByEmail($value)) {
      $this->error(self::EXISTS);
      return false;
    }

    return true;
	}
}
