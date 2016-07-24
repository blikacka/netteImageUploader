<?php

namespace App\Services\Security;

use Kdyby\Doctrine\EntityDao;
use Nette\Object;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;

/**
 * @author Jakub Cieciala <jakub.cieciala@gmail.com>
 */
class Authenticator extends Object implements IAuthenticator{

	/** @var EntityDao */
	private $userDao;

	/** @var Passwords */
	private $password;



	function __construct(EntityDao $userDao, Passwords $passwords) {
		$this->userDao = $userDao;
		$this->password = $passwords;
	}

	/**
	 * Performs an authentication
	 * @param  array
	 * @return IIdentity
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials) {
		$login = $credentials[0];
		$password = $credentials[1];
		/** @var \App\Entities\User $user */
		$user = $this->userDao->findOneBy(array("login" => $login));
		if ($user === null) {
			throw new AuthenticationException("Špatný login", self::IDENTITY_NOT_FOUND);
		}
		if (!$this->password->verify($password, $user->password)) {
			throw new AuthenticationException("Špatné heslo", self::INVALID_CREDENTIAL);
		}

		return $user;
	}

}
