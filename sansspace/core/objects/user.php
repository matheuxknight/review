<?php

function userCreate($logon, $name, $email, $domainid)
{
//	debuglog("userCreate($logon, $name, $email, $domainid)");
	
	$user = new User;
	$user->logon = $logon;
	$user->name = $name;
	$user->email = $email;
	$user->password = '';
	$user->domainid = $domainid;
	$user->status = CMDB_USERSTATUS_OFFLINE;
	$user->enable = true;
	$user->updated = now();
	$user->created = now();
	$user->accessed = now();
	$user->used = now();
	$user->startdate = nowDate();
	$user->enddate = nowDate();

	$b = $user->save();
	if(!$b) debuglog("new user save failed");
	
	return $user;
}

function userCreateData($user, $data)
{
	$user->attributes = $data;
	if(!$user->validate()) return null;

	$user->domainid = CMDB_DEFAULT_DOMAINID;
	$user->status = CMDB_USERSTATUS_OFFLINE;
	$user->enable = true;
	$user->updated = now();
	$user->created = now();
	$user->accessed = now();
	$user->used = now();
	$user->startdate = nowDate();
	$user->enddate = nowDate();

	if($user->save()) return $user;
	return null;
}

function userUpdateData($user, $data)
{
	$user->attributes = $data;
	if(!$user->validate()) return null;

	if(empty($user->startdate) || empty($user->enddate))
	{
		$user->startdate = nowDate();
		$user->enddate = nowDate();
	}

	$user->updated = now();

	if($user->save()) return $user;
	return null;
}

function userDelete($user)
{
	// delete recordings

	dborun("delete from ChatUser where userid=$user->id");
	dborun("delete from ChatTextLog where userid=$user->id");

	dborun("delete from UserEnrollment where userid=$user->id");
	dborun("delete from ObjectEnrollment where userid=$user->id");
	dborun("delete from CourseEnrollment where userid=$user->id");
	
	dborun("delete from Favorite where userid=$user->id");
	
	dborun("delete from FileSession where userid=$user->id");
	dborun("delete from RecordSession where userid=$user->id");
	dborun("delete from Session where userid=$user->id");
	dborun("delete from PrivateMessage where authorid=$user->id");
	
	dborun("delete from QuizAttemptAnswer where attemptid in (select id from QuizAttempt where userid=$user->id)");
	dborun("delete from QuizAttempt where userid=$user->id");
	dborun("delete from SurveyAnswer where userid=$user->id");
	
	$user->delete();
}

function userImageFilename($user)
{
	return SANSSPACE_CONTENT."/avatar-{$user->id}.png";
}

function userImage($user, $size = 48, $text='')
{
	return img(userImageUrl($user), $text, array('width'=>$size));
}

function userImageUrl($user)
{
	$filename = userImageFilename($user);
	if(file_exists($filename))
		return "/contents/avatar-{$user->id}.png";
	else
		return iconurl('user.png');
}




