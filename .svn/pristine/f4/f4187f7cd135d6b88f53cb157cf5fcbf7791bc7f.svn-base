<?php

function courseCreate($name, $parentid, $semesterid)
{
	$parent = getdbo('Object', $parentid);
	
	$object = objectCreate($name, $parentid);
	$object->type = CMDB_OBJECTTYPE_COURSE;
	$object->model = $parent->model;
	$object->save();

	$rcourse = new Course;
	$rcourse->objectid = $object->id;
	$rcourse->semesterid = $semesterid;
	
	$recording = objectCreate('Recordings', $object->id);
	$recording->recordings = true;
	$recording->parentlist = objectParentList($recording);
	$recording->save();
	
	$rcourse->recordingid = $recording->id;
	$rcourse->save();
	
	return getdbo('VCourse', $object->id);
}

function courseCreateData($course, $parentid, $data, $data2)
{
	$course->attributes = $data;
	if(!$course->validate()) return null;
	
//	debuglog("created");
//	return null;

	$object = new Object;
	$object->attributes = $data;
	$object->type = $course->type;
	
	$object = objectInit($object, $parentid);
	if(!$object) return null;

	$object->ext->attributes = $data2;
	$object->ext->save();
	
	$object->model = $course->model;
	$object->enrolltype = $course->enrolltype;
	$object->save();

	$rcourse = new Course;
	$rcourse->attributes = $data;
	$rcourse->objectid = $object->id;

	$recording = objectCreate('Recordings', $object->id);
	$recording->recordings = true;
	$recording->parentlist = objectParentList($recording);
	$recording->save();
	
	$rcourse->recordingid = $recording->id;
	$rcourse->save();
	
	return getdbo('VCourse', $object->id);
}

function courseUpdateData($course, $data, $data2)
{
	$object = getdbo('Object', $course->id);
	$rcourse = getdbo('Course', $course->id);

	$object->attributes = $data;
	$object->updated = now();
	
//	$parent = getdbo('Object', $object->parentid);
	if(	!controller()->rbac->objectAction($object, 'update') &&
		!controller()->rbac->objectAction($object, 'updateteacher'))
		return null;
	
	$object->ext->attributes = $data2;
	$object->ext->save();
	
	$rcourse->attributes = $data;
	if(empty($rcourse->startdate) || empty($rcourse->enddate))
	{
		$rcourse->startdate = nowDate();
		$rcourse->enddate = nowDate();
	}
	
	$ok = $object->validate() && $rcourse->validate();
	if(!$ok) return null;

	$object->save(false);
	$rcourse->save(false);
	
	$object = getdbo('Object', $object->id);
	$object->parentlist = objectParentList($object);
	
	return getdbo('VCourse', $object->id);
}

function courseDelete($course)
{
	if(!$course) return;

	dborun("delete from ChatTextLog where courseid=$course->id");
	objectDelete($course->recording);
	
	dborun("delete from SurveyAnswer where courseid=$course->id");
	dborun("delete from QuizAttemptAnswer where id in (select id from QuizAttempt where courseid=$course->id)");
	dborun("delete from QuizAttempt where courseid=$course->id");

	$rcourse = getdbo('Course', $course->id);
	if(!$rcourse) return;
	
	$rcourse->delete();
}

////////////////////////////////////////////////////////////////////

function CheckCourseStatus($course, $user)
{
	$enrollment = isCourseEnrolled($user->id, $course->id);
	if(!$enrollment) return;
	
	if(	$enrollment->status != CMDB_ENROLLSTATUS_NONE &&
		$enrollment->status != CMDB_ENROLLSTATUS_STARTED)
		return;
	
	$status = $enrollment->status;		// keep old value
	
	if(	$course->type == CMDB_OBJECTTYPE_COURSE &&
		$enrollment->status == CMDB_ENROLLSTATUS_NONE)
		$enrollment->status = CMDB_ENROLLSTATUS_STARTED;
	
	if($status != $enrollment->status)
		$enrollment->save();	
}



