<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;
use Nette\Security\IIdentity;

/**
 * @author Jakub Cieciala <jakub.cieciala@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="user")
 *
 * @property-read int $id
 * @property string $login
 * @property string $password
 * @property string $name
 */
class User extends BaseEntity implements IIdentity {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	public $id;

	/**
	 * @ORM\Column(length=50, unique=true, name="login")
	 * @var string
	 */
	public $login;

	/**
	 * @ORM\Column(length=100, unique=true, name="password")
	 * @var string
	 */
	public $password;

	/**
	 * @ORM\Column(length=50, unique=false, name="name")
	 * @var string
	 */
	public $name;

	/**
	 * @return int
	 */
	function getId() {
		return $this->id;
	}

	function getRoles() {
		// TODO: Implement getRoles() method.
	}


}