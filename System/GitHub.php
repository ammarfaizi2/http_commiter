<?php
namespace System;

use Curl\CMCurl;

class GitHub
{

	public function __construct($user, $pass)
	{
		$this->user = $user;
		$this->pass = $pass;
		$this->hash = sha1($user.$pass);
	}

	public function get_page($url, $post=null, $op=null)
	{
		$ch = new CMCurl($url);
		$ch->set_useragent("Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:46.0) Gecko/20100101 Firefox/46.0");
		$ch->set_cookie(data . "/" . $this->hash . ".txt");
		if ($post) {
			$ch->set_post($post);
		}
		if ($op) {
			$ch->set_optional($op);
		}
		$src = $ch->execute();
		return $src;
	}

	public function login()
	{
		#$a = file_get_contents('a.tmp');
		$src = $this->get_page("https://github.com/login");
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
		$src = $this->get_page("https://github.com/session", $_p, array(CURLOPT_REFERER=>"https://github.com/login"));
		return $src;
	}


	public static function rstr($n=32)
	{
		$a = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM-___";
		$rt = "" xor $st = strlen($a)-1;
		for ($i=0; $i < $n; $i++) { 
			$rt .= $a[rand(0,$st)];
		}
		return $rt;
	}

	public function edit_file($url, $content)
	{
		#$src = $this->get_page($url);
		#file_put_contents('a.tmp', $src);
		$a = file_get_contents('a.tmp');
		$a = explode('class="js-blob-form" data-github-confirm-unload="Your edits will be lost." id="new_blob" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" />', $a, 2);
		$a = explode("</form", $a[1]);
		$a = explode("<input type=\"hidden\"", $a[0]);
		$_p = "utf8=%E2%9C%93&";
		for ($i=0; $i < count($a); $i++) { 
			preg_match("#name=\"(.*)\"#", $a[$i], $n);
			$b = explode("\"", $n[1], 2);
			$b = urlencode(html_entity_decode($b[0], ENT_QUOTES, 'UTF-8'));
			preg_match("#value=\"(.*)\"#", $a[$i], $n);
			$c = explode("\"", $n[1], 2);
			$c = urlencode(html_entity_decode($c[0], ENT_QUOTES, 'UTF-8'));
			$_p .=  $b . "=" . $c . "&";
		}
		$val = self::rstr(72);
		$_p = str_replace("Update+", urlencode($val), $_p);
		print $_p;


/*
	Array
(
    [0] => utf8=%E2%9C%93
    [1] => authenticity_token=Sbdg4K%2Fn5Caz1ifyWcbs5myEDXap5aFMyep40VulX7tjSItmoKJt069BTWdGmtk70UZgZa0hN1T3FoACaRu%2FUA%3D%3D
    [2] => filename=index.py
    [3] => new_filename=index.py
    [4] => commit=38bfce80da7f6ea8f81c4f9ef28ce7dd4aa1313f
    [5] => same_repo=1
    [6] => pr=
    [7] => content_changed=true
    [8] => value=print+%22133s%22%0D%0A
    [9] => message=
    [10] => placeholder_message=Update+index.py
    [11] => description=
    [12] => commit-choice=direct
    [13] => target_branch=master
    [14] => quick_pull=
)*/

	}
}