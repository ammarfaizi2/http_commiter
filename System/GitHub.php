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
		/*$ch = new CMCurl("https://github.com/login");
		$ch->set_useragent("Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:46.0) Gecko/20100101 Firefox/46.0");
		$src = $ch->execute();*/
		$a = file_get_contents('a.tmp');
		$a = explode("<form", $a);
		$a = explode("</form", $a[1]);
		$a = explode("<input", $a[0]);
		$_p = "";
		for ($i=1; $i < 3; $i++) { 
			preg_match("#value=\"(.*)\"#", $a[$i], $n);
			print_r($n);
		}

	}
}