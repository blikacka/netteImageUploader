<?php

namespace App\Presenters;

use Nette;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

	public function startup() {
		parent::startup();
		if ((!$this->user->isLoggedIn())) {
			if ($this->name != "Sign") {
				 $this->redirectOut();
			} else {
				if ($this->request->getParameters()['action'] != "in") {
					$this->redirectOut();
				}
			}
		}
	}

	public function redirectOut() {
		$this->flashMessage("Pro pokračování se přihlaš");
		$this->redirect("Sign:in");
	}

	public function handleLogout() {
		$this->user->logout(true);
		$this->flashMessage("Byli jste odhlášení");
		$this->redirect("this");
	}

}
