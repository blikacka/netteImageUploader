<?php

namespace App\Presenters;

use App\Forms\RegisterForm;
use Nette;
use App\Forms\SignFormFactory;


class SignPresenter extends BasePresenter {
	/** @var SignFormFactory @inject */
	public $factory;

	/** @var RegisterForm @inject */
	public $registerForm;

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm() {
		$form = $this->factory->create();
		$form->onSuccess[] = function ($form) {
			$form->getPresenter()->flashMessage("Byli jste přihlášeni");
			$form->getPresenter()
				->redirect('Homepage:');
		};
		return $form;
	}


	public function actionOut() {
		$this->getUser()
			->logout();
	}

	public function createComponentRegisterForm() {
		$form = $this->registerForm->create();
		$form->onSuccess[] = function ($form) {
			$form->getPresenter()->flashMessage("Uživatel byl úspěšně zaregistrován");
			$form->getPresenter()
				->redirect('Homepage:');
		};
		return $form;
	}



}
