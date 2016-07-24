<?php

namespace App\Presenters;

use Nette;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

	public function handleLogout() {
		$this->user->logout(true);
		$this->flashMessage("Byli jste odhlášení");
		$this->redirect("this");
	}

}
