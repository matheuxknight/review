<?php

///////////////////////////////////////////////////////////////

function getRecordTime($course, $user)
{
	$folder = userRecordingFolder($course, $user);
	$count = $folder->duration/1000;
	
// 	$activities = getdbolist('VCourse',
// 		"type=".CMDB_OBJECTTYPE_ACTIVITY.
// 		" and parentlist like '%, {$course->id}, %'");
	
// 	foreach($activities as $activity)
// 	{
// 		$f = userRecordingFolder($activity, $user);
// 		$count += $f->duration/1000;
// 	}
	
	return $count;
}

///////////////////////////////////////////
//
// get the total play time of everything below

function getPlayTimeObject($starttime, $endtime, $object, $user)
{
	if($user)
		$sql = app()->db->createCommand(
			"select sum(FileSession.duration) as duration ".
			"from FileSession, Object where ".
			"FileSession.starttime > '{$starttime}' and ".
			"FileSession.starttime < '{$endtime}' and ". 
			"FileSession.userid=$user->id and FileSession.fileid=Object.id and ".
			"Object.parentList like '%, $object->id, %' ");
	else
		$sql = app()->db->createCommand(
			"select sum(FileSession.duration) as duration ".
			"from FileSession, Object where ".
			"FileSession.starttime > '{$starttime}' and ".
			"FileSession.starttime < '{$endtime}' and ".
			"FileSession.fileid=Object.id and ".
			"Object.parentList like '%, $object->id, %' ");

	return $sql->queryScalar();
}

function getPlayTime($semester, $object, $user = null)
{
	if(!$semester)
		$semester = getCurrentSemester();

	return getPlayTimeDate($semester->starttime, $semester->endtime, $object, $user);
}

function getPlayTimeDate($starttime, $endtime, $object, $user = null)
{
	$total = getPlayTimeObject($starttime, $endtime, $object, $user);

	$objects = getdbolist('Object', "parentid={$object->id} and type=".CMDB_OBJECTTYPE_LINK);
	//Object::model()->findAll("parentid={$object->id} and type=".CMDB_OBJECTTYPE_LINK);
	if($objects) foreach($objects as $rc)
		$total += getPlayTimeObject($starttime, $endtime, $rc->link, $user);
		
	if(!$object->model) return $total;

	$parent = $object->parent;
	while($parent && $parent->model)
	{
		$objects = $objects = getdbolist('Object', "parentid={$parent->id} and type=".CMDB_OBJECTTYPE_LINK);
		//Object::model()->findAll("parentid={$parent->id} and type=".CMDB_OBJECTTYPE_LINK);
		if($objects) foreach($objects as $rc)
			$total += getPlayTimeObject($starttime, $endtime, $rc->link, $user);

		$parent = $parent->parent;
	}

	return $total;
}

////////////////////////////////////////////////////////////////////

function getOpenCountObject($starttime, $endtime, $object, $user)
{
//	echo "doing $object->name [$object->id]<br>";
	if($user)
		$sql = app()->db->createCommand(
			"select count(*) ".
			"from FileSession, Object where ".
			"FileSession.starttime > '{$starttime}' and ".
			"FileSession.starttime < '{$endtime}' and ". 
			"FileSession.userid=$user->id and FileSession.fileid=Object.id and ".
			"Object.parentList like '%, $object->id, %' ");
	else
		$sql = app()->db->createCommand(
			"select count(*) ".
			"from FileSession, Object where ".
			"FileSession.starttime > '{$starttime}' and ".
			"FileSession.starttime < '{$endtime}' and ".
			"FileSession.fileid=Object.id and ".
			"Object.parentList like '%, $object->id, %' ");

	return $sql->queryScalar();
}

function getOpenCount($semester, $object, $user = null)
{
	if(!$semester)
		$semester = getCurrentSemester();

	return getOpenCountDate($semester->starttime, $semester->endtime, $object, $user);
}

function getOpenCountDate($starttime, $endtime, $object, $user = null)
{
	$total = getOpenCountObject($starttime, $endtime, $object, $user);

	$objects = getdbolist('Object',"parentid={$object->id} and type=".CMDB_OBJECTTYPE_LINK);
	//Object::model()->findAll("parentid={$object->id} and type=".CMDB_OBJECTTYPE_LINK);
	if($objects) foreach($objects as $rc)
		$total += getOpenCountObject($starttime, $endtime, $rc->link, $user);
		
	if(!$object->model) return $total;

	$parent = $object->parent;
	while($parent && $parent->model)
	{
		$objects = getdbolist('Object',"parentid={$parent->id} and type=".CMDB_OBJECTTYPE_LINK);
		//Object::model()->findAll("parentid={$parent->id} and type=".CMDB_OBJECTTYPE_LINK);
		if($objects) foreach($objects as $rc)
			$total += getOpenCountObject($starttime, $endtime, $rc->link, $user);

		$parent = $parent->parent;
	}

	return $total;
}


