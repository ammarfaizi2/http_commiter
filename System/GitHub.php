<?php
namespace System;

use Curl\CMCurl;

class GitHub
{

	public function __construct($user, $pass)
	{
		$this->user = $user;
		$this->pass = $pass;
		$this->hash = md5($user.$pass);
	}

	public function login()
	{
		$ch = new CMCurl("https://github.com/login");
		$ch->set_useragent("Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:46.0) Gecko/20100101 Firefox/46.0");
		$ch->set_cookie(data . "/" . $this->hash . ".txt");
		$src = $ch->execute();
		#$a = file_get_contents('a.tmp');
		$a = explode("<form", $src);
		$a = explode("</form", $a[1]);
		$a = explode("<input", $a[0]);
		$_p = "commit=Sign+in&";
		for ($i=1; $i < 3; $i++) { 
			preg_match("#value=\"(.*)\"#", $a[$i], $n);
			$b = explode("\"", $n[1], 2);
			$b = urlencode(html_entity_decode($b[0], ENT_QUOTES, 'UTF-8'));
			preg_match("#name=\"(.*)\"#", $a[$i], $n);
			$c = explode("\"", $n[1], 2);
			$c = urlencode(html_entity_decode($c[0], ENT_QUOTES, 'UTF-8'));
			$_p .= $c . "=" . $b . "&";
		}
		$_p .= "login=".urlencode($this->user)."&password=".urlencode($this->pass);
		print $_p;
	}
}