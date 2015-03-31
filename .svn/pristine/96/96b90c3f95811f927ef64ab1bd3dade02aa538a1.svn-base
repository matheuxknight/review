<?php

debuglog("updatedatabase.php");

$personal_root = getdbosql('Object',
	'parentid='.CMDB_OBJECTROOT_ID.' and name=\''.CMDB_PERSONALFOLDERNAME.'\'');

if(!$personal_root)
{
	$personal_root = objectCreate(CMDB_PERSONALFOLDERNAME, CMDB_OBJECTROOT_ID);
	$personal_root->displayorder = 100;
}

$personal_root->recordings = true;
$personal_root->save();

//////////////////////////////////////////////////////////////////

$objects = getdbolist('Object', "parentlist = ''");
foreach($objects as $object)
{
	$object->scanstatus = CMDB_OBJECTSCAN_PENDING;
	$object->save();
}

//////////////////////////////////////////////////////////////////

$objects = getdbolist('Object', "doctext != '' or mp3tags != '' or views != -1");
foreach($objects as $object)
{
	$objectext = getdbo('ObjectExt', $object->id);
	if(!$objectext)
	{
		$objectext = new ObjectExt;
		$objectext->objectid = $object->id;

		$objectext->views = 0;
		$objectext->mp3tags = '';
		$objectext->doctext = '';
	}

	if(!empty($object->mp3tags))
		$objectext->mp3tags = $object->mp3tags;

	if(!empty($object->doctext))
		$objectext->doctext = $object->doctext;

	if($object->views != -1)
		$objectext->views = $object->views;

	$object->mp3tags = '';
	$object->doctext = '';
	$object->views = -1;

	$object->save();
	$objectext->save();

	unset($objectext->doctext);
	unset($object->doctext);

	unset($objectext);
	unset($object);
}

/////////////////////////////////////////////////////////////////////

$tabmenu = getdbosql('Tabmenu', "objectid=1");
if(!$tabmenu)
{
	$tabmenu = new Tabmenu;
	$tabmenu->objectid = 1;
	$tabmenu->name = 'All Resources';
	$tabmenu->save();
}

/////////////////////////////////////////////////////////////////////

$roletable = RbacDefaultRoles();
foreach($roletable as $roleitem)
{
	$role = getdbo('Role', $roleitem['id']);
	if($role) continue;
	
	$role = new Role;
	$role->id = $roleitem['id'];
	$role->name = $roleitem['name'];
	$role->description = $roleitem['description'];
	$role->type = $roleitem['type'];
	$role->save();
}

/////////////////////////////////////////////////////////////////////

$ce = getdbosql('CommandEnrollment');
if(!$ce)
{
	// first time init
	dborun("delete from Command");
	dborun("delete from CommandEnrollment");
	
	$commands = RbacDefaultCommands();
	foreach($commands as $c)
	{
		$command = new Command;
		$command->id = $c['id'];
		$command->name = $c['name'];
		$command->description = $c['description'];
		$command->url = $c['url'];
		$command->objecttype = $c['objecttype'];
		$command->createitem = $c['createitem'];
		$command->hideadmin = $c['hideadmin'];
		$command->icon = $c['icon'];
		$command->save();
		
		foreach($c['roles'] as $roleid)
		{
			$ce = new CommandEnrollment;
			$ce->roleid = $roleid;
			$ce->commandid = $command->id;
			$ce->objectid = 0;
			$ce->has = true;
			$ce->save();
		}
	}
}

else
{
	// update
	$commands = RbacDefaultCommands();
	foreach($commands as $c)
	{
		$isnew = false;
		$command = getdbo('Command', $c['id']);
		
		if(!$command)
		{
			$command = new Command;
			$command->id = $c['id'];
			$command->name = $c['name'];
			$command->title = $c['title'];
			$command->url = $c['url'];
			$isnew = true;
		}
		
		$command->description = $c['description'];
		$command->objecttype = isset($c['objecttype'])? $c['objecttype']: false;
		$command->createitem = isset($c['createitem'])? $c['createitem']: false;
		$command->hideadmin = isset($c['hideadmin'])? $c['hideadmin']: false;
		$command->icon = $c['icon'];
		$command->save();
	
		if($isnew)
		{
			dborun("delete from CommandEnrollment where commandid=$command->id");
			foreach($c['roles'] as $roleid)
			{
				$ce = new CommandEnrollment;
				$ce->roleid = $roleid;
				$ce->commandid = $command->id;
				$ce->objectid = 0;
				$ce->has = true;
				$ce->save();
			}
		}
	}
}

//////////////////////////////////////////////

$roletranslatetable = array(
	3=>SSPACE_ROLE_CONTENT,
	4=>SSPACE_ROLE_TEACHER,
	5=>SSPACE_ROLE_STUDENT,
	6=>SSPACE_ROLE_USER,
	7=>SSPACE_ROLE_ALL,
);

$list = getdbolist('CommandEnrollment', "roleid>2 and roleid<10");
foreach($list as $e)
{
	$e->roleid = $roletranslatetable[$e->roleid];
	$e->save();
}

$list = getdbolist('CourseEnrollment', "roleid>2 and roleid<10");
foreach($list as $e)
{
	$e->roleid = $roletranslatetable[$e->roleid];
	$e->save();
}

$list = getdbolist('ObjectEnrollment', "roleid>2 and roleid<10");
foreach($list as $e)
{
	$e->roleid = $roletranslatetable[$e->roleid];
	$e->save();
}

$list = getdbolist('UserEnrollment', "roleid>2 and roleid<10");
foreach($list as $e)
{
	$e->roleid = $roletranslatetable[$e->roleid];
	$e->save();
}

//////////////////////////////////////////////

safeObjectEnrollment(0, SSPACE_ROLE_NETWORK, CMDB_OBJECTROOT_ID);
safeObjectEnrollment(0, SSPACE_ROLE_ADMIN, CMDB_OBJECTROOT_ID);
//safeObjectEnrollment(0, SSPACE_ROLE_CONTENT, CMDB_OBJECTROOT_ID);

dborun("delete from Cronjob where name='Reset Sessions'");
dborun("delete from Cronjob where name='Check Update'");

dborun("update ObjectEnrollment set userid=0 where userid is null");

//////////////////////////////////////////

$st = getdbosql('Semestertemplate');
if(!$st)
{
	$st = new Semestertemplate;
	$st->name = 'Winter';
	$st->starttime = '2012-01-01';
	$st->endtime = '2012-04-01';
	$st->save();
	
	$st = new Semestertemplate;
	$st->name = 'Spring';
	$st->starttime = '2012-04-01';
	$st->endtime = '2012-07-01';
	$st->save();
	
	$st = new Semestertemplate;
	$st->name = 'Summer';
	$st->starttime = '2012-07-01';
	$st->endtime = '2012-09-01';
	$st->save();
	
	$st = new Semestertemplate;
	$st->name = 'Fall';
	$st->starttime = '2012-09-01';
	$st->endtime = '2013-01-01';
	$st->save();
}

$users = getdbolist('User', "used is null");
foreach($users as $user)
{
	$user->used = $user->accessed;
	$user->save();
}

//////////////////////////////////////////

$list = getdbolist('QuizQuestion', "bankid=0");
if(count($list))
{
	$bank = safeCreateObject("Default Question Bank", CMDB_OBJECTROOT_ID);
	$bank->type = CMDB_OBJECTTYPE_QUESTIONBANK;
	$bank->save();
	
	foreach($list as $question)
	{
		$question->bankid = $bank->id;
		$question->save();
	}
}

///////////////////////////////////////////

$list = getdbolist('VCourse', "type=".CMDB_OBJECTTYPE_ACTIVITY);
foreach($list as $a)
{
	$o = $a->object;
	switch($a->activitytype)
	{
		case CMDB_ACTIVITYTYPE_LESSON:
			$o->type = CMDB_OBJECTTYPE_LESSON;
			break;
		
		case CMDB_ACTIVITYTYPE_QUIZ:
			$o->type = CMDB_OBJECTTYPE_QUIZ;
			break;
	}
	
	$o->save();
	
	$list1 = getdbolist('CourseEnrollment', "objectid=$o->id");
	foreach($list1 as $e)
	{
		$recording = $a->recording;
		$folder = getdbosql('Object', "parentid=$recording->id and authorid=$e->userid");
		
		$object = $a->parent;
		while($object && $object->type != CMDB_OBJECTTYPE_COURSE)
			$object = $object->parent;
		
		$e->courseid = $object->id;
		$e->recordingid = $folder->id;
		
		$e->save();
	}
}

$list = getdbolist('CourseEnrollment', "courseid!=0");
foreach($list as $e)
{
	$object = getdbo('Object', $e->objectid);
	if($object->type != CMDB_OBJECTTYPE_COURSE) continue;
	
//	debuglog("fixing course enrollment $object->name");
	
	$e->courseid = 0;
	$e->save();
}

///////////////////////////////////////////

$server = getdbo('Server', 1);
$server->netmessage = '';
$server->save();

debuglog("update complete");









