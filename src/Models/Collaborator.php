<?php
namespace Jasper\Projecthree\Models;

use DateTime;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\GeneratedValue;
use Jasper\Projecthree\Repositories\CollaboratorRepository;

#[Entity(repositoryClass: CollaboratorRepository::class), Table(name: 'collaborators')]
class Collaborator {
	
	#[
		Id, 
		Column(type: 'integer', name: 'id'), 
		GeneratedValue(strategy: 'IDENTITY')
	]
	public int $id;

	#[ManyToOne(targetEntity: User::class, inversedBy: 'collaborations')]
	public User $user;

	#[ManyToOne(targetEntity: Project::class, inversedBy: 'collaborators')]
	public Project $project;
	
	#[Column(type: 'datetime', name: 'created_at')]
	public DateTime $createdAt;

}
