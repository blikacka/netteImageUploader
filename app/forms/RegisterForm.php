<?php


namespace App\Forms;
use App\Entities\User;
use Kdyby\Doctrine\EntityManager;
use Nette\Forms\Form;
use Nette\Object;
use Nette\Security\Passwords;


/**
 * @author Jakub Cieciala <jakub.cieciala@gmail.com>
 */

class RegisterForm extends Object{

	/** @var EntityManager */
	public $em;

	/** @var FormFactory */
	private $factory;

	/** @var \Nette\Security\User */
	private $userSecurity;

	public function __construct(EntityManager $em, FormFactory $factory, \Nette\Security\User $userSecurity) {
		$this->em = $em;
		$this->factory = $factory;
		$this->userSecurity = $userSecurity;
	}

	public function create() {
		$form = $this->factory->create();
		$form->addText('login', "Přezdívka")
			->setRequired("Login je povinný");
		$form->addPassword('password', "Heslo")
			->setRequired("Heslo je povinné");
		$form->addPassword('passwordAgain', "Heslo znova")
			->setRequired("Heslo znova je povinné")
			->addRule(Form::EQUAL, 'Hesla se neshodují', $form['password']);
		$form->addText("name", "Jméno")
			->setRequired("Jméno je povinné");
		$form->addSubmit("submit", "Registrovat se");

		$form->onSuccess[] = array($this, 'submitRegister');
		return $form;
	}

	public function submitRegister(Form $form, $values) {
		$userDao = $this->em->getDao(\App\Entities\User::getClassName());
		$existUser = $userDao->findOneBy(array("login"=>$values->login));
		if ($existUser != null) {
			$form->addError("Tento login je již obsazen!");
			return;
		}

		$user = new User();
		$user->login = $values->login;
		$user->password = Passwords::hash($values->password);
		$user->name = $values->name;
		$userDao->save($user);
		$this->userSecurity->login($values->login, $values->password);

	}


}