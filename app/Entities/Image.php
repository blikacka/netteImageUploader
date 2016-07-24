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
 * @property string $imagePath
 * @property string $imageName
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
	 * @ORM\Column(length=1000, name="image_path")
	 * @var string
	 */
	protected $imagePath;

	/**
	 * @ORM\Column(length=200, name="image_name")
	 * @var string
	 */
	protected $imageName;

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