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
		$src = $this->get_page($url);
		#file_put_contents('a.tmp', $src);
		#$a = file_get_contents('a.tmp');
		$a = explode('class="js-blob-form" data-github-confirm-unload="Your edits will be lost." id="new_blob" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" />', $src, 2);
		$act = explode("<form", $a[0]);
		$act = preg_match("#action=\"(.*)\"#", end($act), $n);
		$act = "https://github.com".html_entity_decode($n[1], ENT_QUOTES, 'UTF-8');
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
		$_p = str_replace("content_changed=","content_changed=true",str_replace("Update+", urlencode($val), $_p));
		$_p .= "message=&description=&commit-choice=direct&filename=index.py&value=".urlencode("print \"".$val."\"");
		return $this->get_page($act, $_p, array(52=>false))
	}
}