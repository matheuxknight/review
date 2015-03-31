<?php

define('LDAP_OPT_DIAGNOSTIC_MESSAGE', 0x0032);

function _ldapdebug($string)
{
//	debuglog($string);
}

function _ldapconnect($servername, $ssl=false)
{
	if(!function_exists('ldap_set_option'))
	{
		debuglog('php_ldap.dll not loaded');
		return null;
	}
	
	@ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 0);
	$ldap = null;
	
	if($ssl)
	{
		$names = explode(' ', $servername);
		for($i = 0; $i < count($names); $i++) $names[$i] = "ldaps://".$names[$i];

		$string = implode(' ', $names);
		$ldap = @ldap_connect($string);
	}
	
	else
		$ldap = @ldap_connect($servername);
	
	if(!$ldap)
	{
		debuglog("ldap_connect($servername): ".ldap_errno($ldap).' '.ldap_error($ldap));
		return null;
	}
	
	@ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
	@ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
	
	return $ldap;
}

function _ldapbind($ldap, $username=null, $password=null)
{
//	_ldapdebug("ldap_bind($username)");
	
	$b = @ldap_bind($ldap, $username, $password);
	if($b) return true;

	debuglog("ldap_bind($username): ".ldap_errno($ldap).' '.ldap_error($ldap));
	
	@ldap_get_option($ldap, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error);
	debuglog("ldap_extended: $extended_error");
	
	return false;
}

////////////////////////////////////////////////////////////////////

function SansLdapAuthenticate($domain, $username, $password)
{
	_ldapdebug("SansLdapAuthenticate($domain->name, $username)");

	if(empty($username) || empty($password)) return null;
//	if(empty($username)) return null;
	
	$ldap = _ldapconnect($domain->ldapserver, $domain->ldapssl);
	if(!$ldap) return null;
	
	$b = _ldapbind($ldap, "$domain->ldapuid=$username,$domain->ldapdn", $password);
	if(!$b)
	{
		$b = _ldapbind($ldap, "$domain->name\\$username", $password);
		if(!$b) return null;
	}
	
	_ldapdebug("LDAP: ACCESS GRANTED");
	$attributes = array($domain->ldapdisplayname, $domain->ldapemail);

	$result = @ldap_search($ldap, $domain->ldapdn, "$domain->ldapuid=$username", $attributes);
	$info = @ldap_get_entries($ldap, $result);
	
	$name = $info[0][$domain->ldapdisplayname][0];
	$email = $info[0][$domain->ldapemail][0];
	
	ldap_unbind($ldap);
	$username2 = addslashes($username);
	
	$user = getdbosql('User', "logon='$username2'");
	if(!$user)
	{
		$user = new User;
		$user->domainid = $domain->id;
		$user->logon = $username;
		$user->password = '';
		$user->enable = true;
		$user->status = CMDB_USERSTATUS_OFFLINE;
		$user->name = empty($name)? $username: $name;
		$user->email = $email;
		$user->updated = now();
		$user->created = now();
		$user->accessed = now();
		$user->used = now();
		$user->startdate = nowDate();
		$user->enddate = nowDate();
		
		if(!$user->validate())
		{
			mydumperror($user->getErrors());
			return null;
		}
		
		$user->save();
		$user = getdbosql('User', "logon='$username2'");
	}
	
	else
	{
		if(!empty($name))
			$user->name = $name;

		if(!empty($email))
			$user->email = $email;		
		
		$user->domainid = $domain->id;
		$user->save();
	}
	
	return $user;
}

////////////////////////////////////////////////////////////////////

function SansLdapTestConnection($servername, $ssl)
{
	$ldap = _ldapconnect($servername, $ssl);
	if(!$ldap) return null;

	$b = _ldapbind($ldap);
	if(!$b) return null;

	$result = @ldap_read($ldap, NULL, 'objectClass=*',
		array('defaultnamingcontext', 'namingcontexts'));
	if(!$result) return null;

	$entries = @ldap_get_entries($ldap, $result);
	if(!$entries) return null;

	ldap_unbind($ldap);
	debuglog($entries, 10);

	if(isset($entries[0]['defaultnamingcontext'][0]))
		return $entries[0]['defaultnamingcontext'][0];

	else if(isset($entries[0]['namingcontexts'][0]))
		return $entries[0]['namingcontexts'][0];

	return "";
}




