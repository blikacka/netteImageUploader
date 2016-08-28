<?php
namespace App\Services\Queries;

use App\Entities\Image;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\QueryBuilder;

/**
 * @author Jakub Cieciala <jakub.cieciala@gmail.com>
 */
class ImageQueries {

	/** @var EntityManager */
	public $em;

	public function __construct(EntityManager $em) {
		$this->em = $em;
	}

	/**
	 * @return QueryBuilder
	 */
	public function imagesQuery() {
		$q = $this->em->createQueryBuilder()
		              ->select('i, u')
		              ->from(Image::class, 'i')
		              ->leftJoin('i.user', 'u');

		return $q;

	}

	/**
	 * @return array|Image[]
	 */
	public function getImages() {
		return $this->imagesQuery()
		            ->getQuery()
		            ->getResult();
	}

}