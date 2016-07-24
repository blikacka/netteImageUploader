<?php

namespace App\Presenters;

use App\Entities\Joke;
use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;


class HomepagePresenter extends BasePresenter {

	/** @var EntityManager @inject */
	public $em;

	public function renderDefault() {

		$this->template->anyVariable = 'any value';
	}

}
