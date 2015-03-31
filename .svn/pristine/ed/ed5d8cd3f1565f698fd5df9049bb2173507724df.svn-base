<?php

define ('SERVER_LOCALHOST', '127.0.0.1');

function sendMessageSansspace($message, $params = '')
{
//	debuglog("sendMessageSansspace($message, $params)");
	$fp = @fsockopen(SERVER_LOCALHOST, SANSSPACE_SANSSPACEPORT, $errno, $errstr, 10);
	if(!$fp) return null;

	$sitename = SANSSPACE_SITENAME;

	$out = "$message WSP/2.0\r\n$params\r\nHost: $sitename\r\n\r\n";
	fwrite($fp, $out);

	$in = ''; while(!feof($fp)) $in .= fgets($fp);

	fclose($fp);
	return $in;
}

function sendMessageSansspaceAsync($message, $params = '')
{
	$fp = @fsockopen(SERVER_LOCALHOST, SANSSPACE_SANSSPACEPORT, $errno, $errstr, 10);
	if(!$fp) return null;

	$sitename = SANSSPACE_SITENAME;

	$out = "$message WSP/2.0\r\n$params\r\nHost: $sitename\r\n\r\n";
	fwrite($fp, $out);

	fclose($fp);
}

function sendHttpRequestAsync($message, $params = '')
{
	$fp = @fsockopen(SERVER_LOCALHOST, SANSSPACE_HTTPIPORT, $errno, $errstr, 10);
	if(!$fp) return false;

	$sitename = SANSSPACE_ALIASNAME;
	if($message[0] != '/') $message = '/'.$message;

	$out = "GET $message HTTP/1.1\r\n";
    $out.= "Host: $sitename\r\n";
    $out.= "Content-Length: 0\r\n";
    $out.= "Connection: Close\r\n\r\n";

    fwrite($fp, $out);
    fclose($fp);

	return true;
}

////////////////////////////////////////////////////////////////

function getSansspaceIdentification()
{
	$result = sendMessageSansspace("GET Identification");
	return textToArray($result, '= ');
}

function textToArray($data, $separator)
{
	$result = array();
	$data1 = explode("\r\n", $data);

	foreach($data1 as $i=>$item)
	{
		$n = strpos($item, $separator);
		if($n)
		{
			$temp = explode($separator, $item);
			$result[$temp[0]] = $temp[1];
		}
	}

	return $result;
}

/////////////////////////////////////////////////////////////////

function initSimpleXml($url, $username, $password)
{
//	debuglog("initSimpleXml($url, $username, ...)");
	libxml_use_internal_errors(true);
	
	$xmlrequest = "<?xml version='1.0' encoding='utf-8'?>
		<methodCall>
			<methodName>login</methodName>
			<params>
				<logon>$username</logon>
				<password>$password</password>
			</params>
		</methodCall>";
	
	$res = postHttpRequest("$url/simplexml", $xmlrequest);
	
	$xml = simplexml_load_string($res);
//	debuglog($xml);
	if($xml === null || (int)$xml->status != 200) return null;
	
	$simplexml = array();
	
	$simplexml['url'] = $url;
	$simplexml['token'] = (string)$xml->token;

	return $simplexml;
}

function callSimpleXml($simplexml, $funcname, $params)
{
//	debuglog("callSimpleXml({$simplexml['url']}, $funcname)");
	
	$xmlrequest = "<?xml version='1.0' encoding='utf-8'?>
		<methodCall>
			<token>{$simplexml['token']}</token>
			<methodName>$funcname</methodName>
			<params>";

	foreach($params as $i=>$v)
		$xmlrequest .= "<$i>$v</$i>";
			
	$xmlrequest .= "</params></methodCall>";
//	debuglog($xmlrequest);

	$res = postHttpRequest("{$simplexml['url']}/simplexml", $xmlrequest);
//	debuglog($res);

	$xml = simplexml_load_string($res);
//	debuglog($xml);
	if($xml === null || (int)$xml->status != 200) return null;

	return $xml;
}

////////////////////////////////////////////////////////////////////////////////

function postHttpRequest($url, $data)
{
	$params = array('http' => array(
		'method' => 'POST',
		'content' => $data,
	));
	
	$ctx = stream_context_create($params);
	
	$fp = @fopen($url, 'rb', false, $ctx);
	if(!$fp) throw new Exception("Problem with $php_errormsg");

	$response = @stream_get_contents($fp);
	if($response === false) throw new Exception("Problem reading data from $url, $php_errormsg");

	return $response;
}

