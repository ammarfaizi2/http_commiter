<?php
namespace System;

use Curl\CMCurl;

class GitHub
{
	
	public function __construct($user, $pass)
	{

	}

	public function login()
	{
		$ch = new CMCurl('https://github.com/login');
	}
}