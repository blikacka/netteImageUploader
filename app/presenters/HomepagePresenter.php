<?php

namespace App\Presenters;

use App\Entities\Image;
use App\Services\Queries\ImageQueries;
use Kdyby\Doctrine\EntityManager;


class HomepagePresenter extends BasePresenter {

	/** @var EntityManager @inject */
	public $em;

	/** @var ImageQueries @inject */
	public $imageQueries;

	public function renderDefault() {

		$this->template->images = $this->imageQueries->getImages();

	}

}
