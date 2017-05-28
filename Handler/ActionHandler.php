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

	private function login_action()
	{
		$this->github->login();
	}


	public function run()
	{
		#$this->login_action();
		$this->github->edit_file("https://github.com/ammarfaizi2/rgp/edit/master/index.py","print \"".rand(0,99999)."\"");
	}
}