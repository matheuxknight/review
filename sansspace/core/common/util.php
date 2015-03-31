<?php

/*
 * userid 0 is SYSTEM
 *
 * guest and admin user based on login name
 *
 */

function userid()
{
	return getUser()->id;
}

function username()
{
	return user()->getName();
}

function controller()
{
	return app()->getController();
}

function getparam($p)
{
	return isset($_REQUEST[$p])? $_REQUEST[$p]: '0';
}

$_currentuser = null;

function setUser($user)
{
	global $_currentuser;
	$_currentuser = $user;
}

function getUser()
{
	global $_currentuser;

	if($_currentuser)
		return $_currentuser;

	if(user()->isGuest)
	{
		$_currentuser = getdbosql('User', "logon='guest'");
		if(!$_currentuser)
		{
			$_currentuser = new User;
			$_currentuser->logon = 'guest';
			$_currentuser->name = 'Guest User';
			$_currentuser->domainid = 0;
			$_currentuser->save();
		}
	}

	else
		$_currentuser = getdbo('User', user()->getId());

	return $_currentuser;
}

//////////////////////////////////////////////////////

function downloadFile($url, &$size)
{
	$data = file_get_contents($url);
	$tempname = gettempfile('.ext');

	file_put_contents($tempname, $data);
	$size = dos_filesize($tempname);

	unlink($tempname);
	return $data;
}

function getServerName()
{
	if(strpos($_SERVER['SERVER_NAME'], ':'))
		return substr($_SERVER['SERVER_NAME'], 0, strpos($_SERVER['SERVER_NAME'], ':'));

	return $_SERVER['SERVER_NAME'];
}

function getFullServerName()
{
	if(isset($_SERVER['HTTPS']) && !strcasecmp($_SERVER['HTTPS'], 'on'))
		$protocol = 'https';
	else
		$protocol = 'http';

	return $protocol.'://'.$_SERVER['HTTP_HOST'];
}

function getPlayerConnect()
{
	return 'rtmp://'.getServerName().':'.SANSSPACE_RTMPPORT.'/'.SANSSPACE_SITENAME;
}

function getPlayerConnectRtmpt()
{
	return 'rtmpt://'.getServerName().':'.SANSSPACE_RTMPPORT.'/'.SANSSPACE_SITENAME;
//	return 'rtmpt://'.$_SERVER['HTTP_HOST'].'/'.SANSSPACE_SITENAME;
}

///////////////////

function getClientPlatform()
{
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version= "";

	if(preg_match('/ipad/i', $agent))
		$platform = 'Ipad';

	else if(preg_match('/iphone/i', $agent))
		$platform = 'Iphone';

	else if(preg_match('/android/i', $agent))
		$platform = 'Android';

	else if(preg_match('/linux/i', $agent))
		$platform = 'Linux';

	elseif(preg_match('/macintosh|mac os x/i', $agent))
		$platform = 'Mac';

	elseif(preg_match('/windows|win32/i', $agent))
		$platform = 'Windows';

    //////////////////////////////////////////////////////////////////////

    if(preg_match('/MSIE/i',$agent) && !preg_match('/Opera/i',$agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$agent))
    {
        $bname = 'Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$agent))
    {
        $bname = 'Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$agent))
    {
        $bname = 'Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

	preg_match_all($pattern, $agent, $matches);

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($agent,"Version") < strripos($agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return "$platform, $bname $version";
}

function IsMobileDevice()
{
	$agent = $_SERVER['HTTP_USER_AGENT'];

	return preg_match('/ipad/i', $agent) ||
		preg_match('/iphone/i', $agent) ||
		preg_match('/android/i', $agent);
}

function IsMobileEmbeded()
{
	if(user()->getState('noheader'))
		return true;
	
	return false;
}





