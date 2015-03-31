<?php

function buildBaseString($baseURI, $method, $params)
{
	$r = array();
	ksort($params);
	foreach($params as $key=>$value){
		$r[] = "$key=" . rawurlencode($value);
	}
	return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}

function buildAuthorizationHeader($oauth)
{
	$r = 'Authorization: OAuth ';
	$values = array();
	foreach($oauth as $key=>$value)
		$values[] = "$key=\"" . rawurlencode($value) . "\"";
	$r .= implode(', ', $values);
	return $r;
}

function file_get_contents_curl($url, $user=null)
{
	$ch = curl_init($url);
	
	if($user)
	{
		$a = explode(',', $user->access_token);
		$oauth_token = $a[0];
		$oauth_token_secret = $a[1];
		
		$oauth = array(
			'oauth_consumer_key' => CONSUMER_KEY,
			'oauth_nonce' => md5(microtime().mt_rand()),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => time(),
			'oauth_token' => $oauth_token,
			'oauth_version' => '1.0');
			
		$base_info = buildBaseString($url, 'POST', $oauth);
		$composite_key = rawurlencode(CONSUMER_SECRET).'&'.rawurlencode($oauth_token_secret);
		$oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
		$header = buildAuthorizationHeader($oauth);
		
	//	debuglog($header);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
	}

	$maxallowed = 64*1024;
	$totalread = 0;
	$data = '';
	
	$callback = function($ch, $text) use(&$data, &$maxallowed, &$totalread)
	{
		$data .= $text;
		$count = strlen($text);
		$totalread += $count;
		
		if($totalread >= $maxallowed || stristr($data, '</head>'))
			return 0;
		
		return $count;
	};
	
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; SANSSPACE)');
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_ENCODING , "deflate,gzip");
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_WRITEFUNCTION, $callback);
	
	curl_exec($ch);
	curl_close($ch);

//	debuglog(" total read $totalread, ".strlen($data));
	return $data;
}

