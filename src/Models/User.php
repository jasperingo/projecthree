<?php
namespace Jasper\Projecthree\Models;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\GeneratedValue;
use DateTime;

#[Entity, Table(name: 'users')]
class User {
	
	#[
		Id, 
		Column(type: 'integer', name: 'id'), 
		GeneratedValue(strategy: 'IDENTITY')
	]
	public int $id;

	#[Column(type: 'string', name: 'first_name', nullable: false)]
	public string $firstName;

	#[Column(type: 'string', name: 'last_name', nullable: false)]
	public string $lastName;
	
	#[Column(type: 'string', name: 'email',  unique: true, nullable: false)]
	public string $email;
	
	#[Column(type: 'string', name: 'password', nullable: false)]
	public string $password;
	
	#[Column(type: 'datetime', name: 'created_at')]
	public DateTime $createdAt;
}
