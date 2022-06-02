<?php
namespace Jasper\Projecthree\Validators;

use Laminas\Validator\AbstractValidator;
use Doctrine\ORM\EntityManager;
use Jasper\Projecthree\Models\Department;

class DepartmentIdExistsValidator extends AbstractValidator {
  const NOT_EXIST = 'not_exist';

  private EntityManager $entityManager;

  protected $messageTemplates = [
    self::NOT_EXIST => "%value% don't exist",
  ];

  public function setEntityManager(EntityManager $entityManager) {
    $this->entityManager = $entityManager;
    return $this;
  }

	public function isValid($value) {
    $this->setValue($value);

    if (!$this->entityManager->getRepository(Department::class)->existsById($value)) {
      $this->error(self::NOT_EXIST);
      return false;
    }

    return true;
	}
}
