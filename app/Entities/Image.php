<?php


namespace App\Entities;

use Kdyby\Doctrine\Entities\BaseEntity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @author Jakub Cieciala <jakub.cieciala@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="image")
 *
 * @property-read int $id
 * @property User $user
 * @property string $path
 * @property string $name
 * @property string $thumb
 * @property string $lat
 * @property string $lng
 * @property \DateTime $created
 */
class Image extends BaseEntity {


	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(nullable=true, name="user_id")
	 * @var User
	 */
	protected $user;

	/**
	 * @ORM\Column(length=1000, name="path")
	 * @var string
	 */
	protected $path;

	/**
	 * @ORM\Column(length=200, name="name")
	 * @var string
	 */
	protected $name;

	/**
	 * @ORM\Column(length=200, name="thumb")
	 * @var string
	 */
	protected $thumb;

	/**
	 * @ORM\Column(nullable=true, length=50, name="latitude")
	 * @var string
	 */
	protected $lat;

	/**
	 * @ORM\Column(nullable=true, length=50, name="longitude")
	 * @var string
	 */
	protected $lng;

	/**
	 * @ORM\Column(type="datetime", name="date_from")
	 * @var string
	 */
	protected $created;

	public function __construct() {
		$this->created = new \DateTime();
	}


}