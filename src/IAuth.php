<?php 

interface IAuth{

	public function verify($login, $password, $token = null);

	public function saveInSession();
}