<?php

class ProxyController extends CController
{
	public $defaultAction = 'index';
	
	public function actionIndex()
	{
 		$pattern = "/proxy?url=(.*)";
 		$pattern = preg_replace('/\//', '\/', $pattern);
 		$pattern = preg_replace('/\?/', '\?', $pattern);
		
 		$b = preg_match("/$pattern/", $_SERVER['REQUEST_URI'], $m);
 		if(!$b)
 		{
 			debuglog("no match");
 			return;
 		}
 		
 		$url = trim($m[1]);
 		$remotedomain = $url;
 		
 		$pos = strpos($remotedomain, '/', 8);
 		if($pos) $remotedomain = substr($remotedomain, 0, strpos($remotedomain, '/', 8));
 			
 		if($_SERVER['HTTPS'] == 'on')
 			$localdomain = 'https://'.$_SERVER['HTTP_HOST'];
 		else
			$localdomain = 'http://'.$_SERVER['HTTP_HOST'];
		
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_COOKIE, $_SERVER['HTTP_COOKIE']);
		
		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
		}

		$data = curl_exec($ch);
		if(curl_error($ch))
		{
			debuglog("error - $url");
			debuglog(curl_error($ch));
			
			return;
		}

		$status = curl_getinfo($ch);
		curl_close($ch);

		$a = explode(chr(13).chr(10).chr(13).chr(10), substr($data, 0, $status['header_size']));
		$header = $a[count($a)-2];
		
		$body = substr($data, $status['header_size']);
	
		$header_ar = explode(chr(10), $header);
		foreach($header_ar as $k=>$v)
		{
			$v = trim($v);
			if(empty($v)) continue;

			if(preg_match("/^Transfer-Encoding/", $v)) continue;
 			header(str_replace($remotedomain, $localdomain, $v));
		}
		
		$body = str_replace($remotedomain, "$localdomain/proxy?url=$remotedomain", $body);
		print $body;
	}		
	
	
	
}




