<?php
namespace Jasper\Projecthree\Models;

use DateTime;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\GeneratedValue;
use Jasper\Projecthree\Repositories\ProjectRepository;

#[Entity(repositoryClass: ProjectRepository::class), Table(name: 'projects')]
class Project {

  #[
		Id, 
		Column(type: 'integer', name: 'id'), 
		GeneratedValue(strategy: 'IDENTITY')
	]
	public int $id;

	#[Column(type: 'string', name: 'topic', nullable: false)]
	public string $topic;

	#[Column(type: 'string', name: 'description', nullable: false)]
	public string $description;

  #[Column(type: 'datetime', name: 'created_at')]
	public DateTime $createdAt;

  #[ManyToOne(targetEntity: Department::class, inversedBy: 'projects')]
  public Department $department;

  #[OneToMany(targetEntity: Collaborator::class, mappedBy: 'project')]
	public ArrayCollection $collaborators;
}
