<?php
namespace Handler;

use System\GitHub;

class ActionHandler
{	

	private $github;

	/**
	* @param	string	$user
	* @param	string	$pass
	*/
	public function __construct($user, $pass)
	{
		$this->github = new GitHub($user, $pass);
	}

	public function login_action()
}