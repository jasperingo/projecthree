<?php
namespace Jasper\Projecthree\Models;

use DateTime;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Jasper\Projecthree\Repositories\DepartmentRepository;

#[
	Entity(repositoryClass: DepartmentRepository::class),
	Table(name: 'departments')
]
class Department {
	
	#[
		Id, 
		Column(type: 'integer', name: 'id'), 
		GeneratedValue(strategy: 'IDENTITY')
	]
	public int $id;
	
	#[Column(type: 'string', name: 'name', nullable: false)]
	public string $name;

	#[Column(type: 'string', name: 'acronym', nullable: false)]
	public string $acronym;

	#[Column(type: 'datetime', name: 'created_at')]
	public DateTime $createdAt;

	#[OneToMany(targetEntity: Project::class, mappedBy: 'department')]
	public PersistentCollection $projects;
}
