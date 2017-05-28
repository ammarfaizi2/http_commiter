<?php
namespace Handler;



class ActionHandler
{	

	private $user;
	private $pass;

	/**
	* @param	string	$user
	* @param	string	$pass
	*/
	public function __construct($user, $pass)
	{
		$this->user = $user;
		$this->pass = $pass;
	}
}