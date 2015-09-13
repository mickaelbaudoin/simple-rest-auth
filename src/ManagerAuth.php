<?php

class ManagerAuth{

	protected $login;

	protected $password;

	/**
	 * @var IAuth
	 */
	protected $auth;

	const AUTH_STANDART = "standart";
	const AUTH_FACEBOOK = "facebook";
	const AUTH_GMAIL = "gmail";
	const AUTH_LINKEDIN = "linkedin";

	/**
	 * @var string standart|facebook|gmail|linkedin
	 */
	protected $type;

	public function __construct($login, $password, $type)
	{
		$this->login = $login;
		$this->password = $password;
		$this->type = $type;
	}

	public function doLogin()
	{
		switch ($this->type) {
			case self::AUTH_FACEBOOK:
				# code... new AuthFacebook
				break;
			
			case self::AUTH_GMAIL:
				# code... new AuthGmail
				break;

			case self::AUTH_LINKEDIN:
				# code... new AuthLinkedin
				break;

			default:
				# code... new AuthStandart
				break;
		}
	}
}