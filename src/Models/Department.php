<?php
namespace Jasper\Projecthree\Models;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Console\Helper\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Jasper\Projecthree\Repositories\DepartmentRepository;

#[Entity(repositoryClass: DepartmentRepository::class), Table(name: 'departments')]
class Department {
	
	#[
		Id, 
		Column(type: 'integer', name: 'id'), 
		GeneratedValue(strategy: 'IDENTITY')
	]
	public $id;
	
	#[Column(type: 'string', name: 'name', nullable: false)]
	public $name;

	#[Column(type: 'string', name: 'acronym', nullable: false)]
	public $acronym;
}
