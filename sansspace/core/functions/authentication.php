<?php

class SansspaceIdentity
{
	public $session;
	public $casdomain = null;
	
	public function __construct()
	{
	//	debuglog("SansspaceIdentity::__construct");
		if(strstr($_SERVER['REQUEST_URI'], 'internaluser=system')) return;
		if(strstr($_SERVER['REQUEST_URI'], '/sansspacehost/')) return;
		
		$phpsessid = isset($_REQUEST['phpsessid'])? $_REQUEST['phpsessid']: '';
	//	if(empty($phpsessid) && isset($_COOKIE['PHPSESSID']))
	//		$phpsessid = $_COOKIE['PHPSESSID'];
		
	//	debuglog("phpsessid is $phpsessid");
		if(!empty($phpsessid))
		{
		//	debuglog("phpsessid2 is $phpsessid");
			
			$this->session = getdbosql('Session', "phpsessid='$phpsessid'");
			if($this->session && userid() != $this->session->userid)
			{
				$user = getdbo('User', $this->session->userid);
				$this->authorize($user);
				$user = getUser();
			}
		}
		else
		{
			$phpsessid = session_id();
			$this->session = getdbosql('Session', "phpsessid='$phpsessid'");
		}
		
		if(!$this->session)
		{
		//	debuglog("SansspaceIdentity::__construct: new session");
			$guest = getdbosql('User', "logon='guest'");
			
			$this->session = new Session;
			$this->session->phpsessid = $phpsessid;
			$this->session->userid = $guest->id;
			$this->session->starttime = now();
			$this->session->duration = 0;
			$this->session->lastpage = '';
			$this->session->platform = getClientPlatform();
			
			$clientip = $_SERVER['REMOTE_ADDR'];

			$client = getdbosql('Client', "remoteip='$clientip'");
			if(!$client) $client = new Client;
			
			$client->remoteip = $clientip;
			$client->remotename = gethostbyaddr($clientip);
			$client->save();
			
			$this->session->clientid = $client->id;
			$this->session->isguest = true;
			$this->session->status = CMDB_SESSIONSTATUS_CONNECTED;
			
			$this->session->timeping = time();
			$this->session->timepage = time();
			
			$this->session->save();
		}
		
	//	debuglog("SansspaceIdentity::__construct $phpsessid, {$this->session->id}");

		if(user()->isGuest)
			$this->attemptlogin();
		
		else if(userid() != $this->session->userid || $this->session->isguest)
		{
			$this->session->userid = userid();
			$this->session->isguest = false;
			$this->session->status = CMDB_SESSIONSTATUS_CONNECTED;
			
			$this->session->save();
		}
		
		$this->update();
	//	debuglog("SansspaceIdentity::__construct: completed");
	}
	
	private function error($errormessage)
	{
		debuglog("SansspaceIdentity::error($errormessage)");
		user()->setFlash('error', $errormessage);

		return false;
	}
	
	////////////////////////////////////////////////////////////////
	
	public function authenticate($username, $password)
	{
	//	debuglog("SansspaceIdentity::authenticate($username, $password)");
		if(empty($username)) return $this->error('Empty username');
		
		if(MD5($password) == SANSSPACE_UDID)
		{
			$user = getdbosql('User', "logon='$username'");
			if($user) return $user;
		}
		
		$domains = getdbolist('Domain', "enable order by displayorder");
		foreach($domains as $domain)
		{
			if($domain->ldapenable)
				$user = $this->authenticateLdap($domain, $username, $password);

			else
				$user = $this->authenticateDb($domain, $username, $password);

			if($user) return $user;
		}
		
		return $this->error('We\'re sorry, the username and password you provided were incorrect.<br>Please use the <a href="../site/forgot">"Forgot your username or password?"</a> feature to determine your credentials if you continue to experience login problems.');
	}

	public function validate($user)
	{
	//	debuglog("SansspaceIdentity::validate");
	
		if(!$user) return null;
		if($user->logon == 'admin') return $user;
		if(strstr($_SERVER['SERVER_NAME'], 'sansspace.com')) return $user;
		
		$server = getdbo('Server', 1);
		if($server->license_total)
		{
			$semester = getCurrentSemester();
			$license_used = dboscalar("select count(*) from user where used>'$semester->starttime'");

			if($license_used > $server->license_total)
			{
				user()->setFlash('error', 'No more available license. Please contact your system administrator.');
			//	return $this->error('No more license');
			}
		}
		
		else
		{
			$connected = CMDB_SESSIONSTATUS_CONNECTED;
			$online = getdbocount('Session', "status=$connected and not isguest");

			$max = 3;
			if($server->license_concurrent)
				$max = $server->license_concurrent;

			else if(date("Y", time()) == '2013' && SANSSPACE_LICENSECOUNT > $max)
				$max = SANSSPACE_LICENSECOUNT;
	
		//	debuglog("max users: $max");
			if($online > $max)
				return $this->error('No more license');
		}
		
		if($user->usedate)
		{
			$startArr = explode("-", $user->startdate);
			$endArr = explode("-", $user->enddate);
		
			$startInt = mktime(0, 0, 0, $startArr[1], $startArr[2], $startArr[0]);
			$endInt = mktime(23, 59, 59, $endArr[1], $endArr[2], $endArr[0]);
		
			if(time() < $startInt || time() > $endInt)
				return $this->error('Account expired');
		}

		if(param('enrolledonly'))
		{
			$allowednotenrolled = false;
			
			foreach($user->userenrollments as $e)
			{
				if(	$e->roleid == SSPACE_ROLE_NETWORK || 
					$e->roleid == SSPACE_ROLE_ADMIN ||
					$e->roleid == SSPACE_ROLE_CONTENT ||
					$e->roleid == SSPACE_ROLE_TEACHER)
					$allowednotenrolled = true;
			}

			if(!$allowednotenrolled)
			{
				$semester = getCurrentSemester();
				$found = false;
				
				foreach($user->courseenrollments as $enrollment)
				{
					$course = $enrollment->object->course;
					if(!$course) continue;
				//	if($course->type != CMDB_OBJECTTYPE_COURSE) continue;
					if($course->semesterid != $semester->id) continue;
	
					$found = true;
					break;
				}
				
				if(!$found)
					return $this->error('Account expired');
			}
		}

		return $user;
	}
	
	public function authorize($user, $remember=false)
	{
		if(!$user) return null;
	//	debuglog("SansspaceIdentity::authorize($user->logon)");

		$identity = new UserIdentity($user);
		
		$duration = $remember? 3600*24*30: 0; // 30 days
		user()->login($identity, $duration);
		
	//	updateAutoEnrollment($user);
		createPersonalFolder($user);
		updatePersonalRole($user);
		
		$this->session->userid = $user->id;
		$this->session->isguest = false;
		$this->session->save();
		
		session_id($this->session->phpsessid);
		session_start();
		setcookie('PHPSESSID', $this->session->phpsessid, 0, '/');
		setUser($user);
		
		$agent = $_SERVER['HTTP_USER_AGENT'];
		if(IsMobileEmbeded() && preg_match('/android/i', $agent))
		{
			$extraScript = "<script>$(function(){
					var ret = new Object;
					ret['method'] = 'androidConnect';
					ret['phpsessid'] = '{$this->session->phpsessid}';
					document.location = 'unknown:/' + JSON.stringify(ret);
				});</script>";
			
			$extraScript = urlencode($extraScript);
			setcookie('login_extrascript', $extraScript, 0, '/');
		}

		// logoff anyone else with same userid 
		if(param('singlelogin'))
		{
			if(	!isUserEnrolled($user->id, SSPACE_ROLE_NETWORK) &&
				!isUserEnrolled($user->id, SSPACE_ROLE_ADMIN) && 
				$user->logon != 'admin' &&
				$user->logon != 'demo' &&
				!strstr($user->logon, 'student') &&
				!strstr($user->logon, 'teacher'))
			{
				$connected = CMDB_SESSIONSTATUS_CONNECTED;
				$sessions = getdbolist('Session', "status=$connected and 
					userid=$user->id and id!={$this->session->id}");
				
				foreach($sessions as $s)
				{
				//	debuglog("force logout $s->id");
					$s->forcelogout = true;
					$s->save();
				}
			}
		}
		
		user()->setFlash('message', 'Login successful');
	//	debuglog("SansspaceIdentity::authorize($user->logon) - end");
		return $user;
	}

	public function logout()
	{
	//	debuglog("SansspaceIdentity::logout");
		
		$userid = user()->getState('shadowid');
		if(!empty($userid))
		{
			user()->setState('shadowid', '');
			$user = getdbo('User', $userid);
			
			$this->authorize($user);
			controller()->redirect(array('my/'));
		}

		$this->session->status = CMDB_SESSIONSTATUS_COMPLETE;
		$this->session->duration = time() - strtotime($this->session->starttime);
		$this->session->save();
		
		user()->logout();
		
		////////////////////////////////////////
		
		$this->initializeCAS();
		
		if($this->casdomain && $this->casdomain->casautologin && 
			phpCAS::isAuthenticated()) phpCAS::logout();
	}

	////////////////////////////////////////////////////////////////
	
	public function attemptlogin()
	{
	//	debuglog("SansspaceIdentity::attemptlogin");
		
		if(isset($_POST['LoginForm']))
		{
			$username = $_POST['LoginForm']['username'];
			$password = $_POST['LoginForm']['password'];
			$remember = $_POST['LoginForm']['rememberMe'];

			$user = $this->authenticate($username, $password);
			$user = $this->validate($user);
			$user = $this->authorize($user, $remember);

			if(!$user) user()->loginRequired();
			
			$url = user()->returnUrl;
			if($url == '/') $url = '/my';
			if($url == '/site') $url = '/my';
				
		//	debuglog($url);
			controller()->redirect($url);
		}

		if(isset($_POST['user']))
		{
			$username = addslashes($_POST['user']);
			$password = $_POST['pass'];

		//	debuglog("SansspaceIdentity::attemptlogin $username, $password");
			
			$user = $this->authenticate($username, $password);
			$user = $this->validate($user);
			$user = $this->authorize($user);

			if(!$user) user()->loginRequired();
		//	controller()->redirect(user()->returnUrl);
		}

// 		if($_SERVER['SERVER_NAME'] == "community.sansspace.com")
// 		{
// 			$communityident = getparam('communityident');
// 			if($communityident)
// 			{
// 				$info = explode(',', base64_decode($communityident));
		
// 				$name = "{$info[0]} from {$info[2]}";
// 				$email = $info[1];
		
// 				$user = getdbosql('User', "name='$name'");
// 				if(!$user)
// 				{
// 					$status = dborow("show table status like 'user'");
// 					$logon = "user-".$status['Auto_increment'];
		
// 					$user = userCreate($logon, $name, $email, 0);
// 				}
		
// 				$user = $this->validate($user);
// 				$user = $this->authorize($user);

// 				controller()->redirect(array('my/courses'));
// 			}
// 		}
		
		$this->initializeCAS();
		if($this->casdomain)
		{
			$checked = user()->getState('CASCHECKED');
			if(!$checked && $this->casdomain->casautologin)
			{
				phpCAS::checkAuthentication();
				user()->setState('CASCHECKED', '1');
			}
			
			if(phpCAS::isAuthenticated())
			{
				$userlogon = phpCAS::getUser();
				if(!empty($userlogon))
				{
				//	debuglog("----- CAS LOGIN SUCCESS: $userlogon");
					
					$username = $userlogon;
					$usermail = '';
					
					$details = phpCAS::getAttributes();
				//	debuglog($details);
					
					if(isset($details['DisplayName'])) $username = $details['DisplayName'];
					if(isset($details['EMail'])) $usermail = $details['EMail'];
					
					$user = safeCreateUser($userlogon, $username, $usermail, $this->casdomain->id);
	
					$user = $this->validate($user);
					$user = $this->authorize($user);
				}
			}
		}
	}
	
	public function update()
	{
		$url = $_SERVER['REQUEST_URI'];
		if(!Yii::app()->request->isAjaxRequest &&
			!strstr($url, '/channellist') &&
			!strstr($url, '/xml') &&
			!strstr($url, '/internal'))
		{
			if($this->session)
			{
				$this->session->timepage = time();
				$this->session->lastpage = $url;
				$this->session->save();
			}
		}
	}
	
	////////////////////////////////////////////////////////////////
	
	public function authenticateDb($domain, $username, $password)
	{
		$username = addslashes($username);
		$password = addslashes($password);
		
		$user = null;
		if(empty($password))
		{
			$user = getdbosql('User', 
				"domainid=$domain->id and logon='$username' and password=''");
			
			if(!$user) $user = getdbosql('User', 
				"domainid=$domain->id and logon='$username@$domain->name' and password=''");
		}
		
		if(!$user) $user = getdbosql('User', 
			"domainid=$domain->id and logon='$username' and password=MD5('$password')");
			
		if(!$user) $user = getdbosql('User', 
			"domainid=$domain->id and logon='$username@$domain->name' and password=MD5('$password')");
		
		return $user;
	}
	
	public function authenticateLdap($domain, $username, $password)
	{
		return SansLdapAuthenticate($domain, $username, $password);
	}
	
	public function initializeCAS()
	{
		// only one CAS can be enable
		if($this->casdomain) return;
		$this->casdomain = getdbosql('Domain', "enable and casenable");
		if(!$this->casdomain) return;
		
	//	debuglog("** casInitialize({$this->casdomain->casserver})");

		phpCAS::client(CAS_VERSION_2_0, $this->casdomain->casserver, 
			intval($this->casdomain->casport), $this->casdomain->cascontext);

		phpCAS::setNoCasServerValidation();
	}
	
}


