<?php


namespace App\Forms;
use App\Entities\User;
use Kdyby\Doctrine\EntityManager;
use Nette\Forms\Form;
use Nette\Object;
use Nette\Security\Passwords;
use Nette\Utils\Html;


/**
 * @author Jakub Cieciala <jakub.cieciala@gmail.com>
 */

class UploadImageForm extends Object{

	/** @var EntityManager */
	public $em;

	/** @var FormFactory */
	private $factory;

	public function __construct(EntityManager $em, FormFactory $factory) {
		$this->em = $em;
		$this->factory = $factory;
	}

	public function create() {
		$form = $this->factory->create();

		$form->addMultiUpload('upload', 'Obrázky');

		$form->addSubmit("submit", "Odeslat");

		return $form;
	}

}