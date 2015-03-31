<?php

require_once('cfile.php');
require_once('generic.php');
require_once('server1.php');
require_once('server.php');

////////////////////////////////////////////////////////////////

function WebdavAuthenticate()
{
	if(isset($_SERVER['PHP_AUTH_USER']))
	{
		$username = $_SERVER['PHP_AUTH_USER'];
		$password = $_SERVER['PHP_AUTH_PW'];
		$remotename = $_SERVER['REMOTE_HOST'];
		$remoteip = $_SERVER['REMOTE_ADDR'];
		
		$user = getdbosql('User', "logon='$username'");
		if(!$user) dieunauthorized();
		
		$identity = new UserIdentity($username, $password);
		$scache = getdbosql('SessionCache', 
			"username='$username' and remotename='$remotename' and remoteip='$remoteip'");
		if(!$scache)
		{
			$identity->authenticate();
			
			if($identity->errorCode != UserIdentity::ERROR_NONE) 
				dieunauthorized();
			
			$scache = getdbosql('SessionCache', 
				"remotename='$remotename' and remoteip='$remoteip'");
		
			if(!$scache)
			{
				$scache = new SessionCache;
				$scache->remotename = $remotename;
				$scache->remoteip = $remoteip;
			}
			
			$scache->username = $username;
			$scache->userid = $user->id;
			$scache->updated = now();
			$scache->save();
		}
		else
			$identity->setuser($user);
		
		user()->login($identity);
	}
	
	else if($_SERVER['REQUEST_METHOD'] != 'OPTIONS')
		dieunauthorized();
}

function dieunauthorized()
{
	header('HTTP/1.1 401 Unauthorized');
	header("WWW-Authenticate: Basic realm='SANSSPACE WEBDAV'");
	
	die;
}




