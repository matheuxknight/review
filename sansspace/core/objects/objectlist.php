<?php

// special folders

function objectList($id)
{
//	debuglog("objectlist $id");
	$user = getUser();
	
	if(isset($_GET['semesterid']))
		$semesterid = $_GET['semesterid'];
	else
	{
		$semester = getCurrentSemester();
		$semesterid = $semester->id;
	}

	$objectlist = array();
	if($id == 'mycourses')
	{
		foreach($user->courseenrollments as $enrollment)
		{
			if($enrollment->object->type != CMDB_OBJECTTYPE_COURSE) continue;
			$course = $enrollment->object->course;
			
			if($course->semesterid != $semesterid && $course->semesterid != 0 && $semesterid != 0)
				continue;
			
			if(isCourseOutOfDate($enrollment->object)) continue;

			$objectlist[] = $course;
		}
	}

	else if($id == 'mylocations')
	{
		$objectids = $user->objectEnrollmentsExt2();
		foreach($objectids as $id=>$roleid)
		{
			$object = getdbo('Object', $id);
			if(!$object) continue;
			if($object->type == CMDB_OBJECTTYPE_COURSE) continue;
			
			$skip = false;
			foreach($objectlist as $o)
				if(strstr($object->parentlist, ", $o->id, "))
					$skip = true;
				
			if($skip) continue;
			$objectlist[] = $object;
		}
	}

	else if($id == 'myfolders')
	{
		foreach($user->courseenrollments as $enrollment)
		{
			if($enrollment->object->type != CMDB_OBJECTTYPE_COURSE) continue;
			$course = $enrollment->object->course;
			
			if($course->semesterid != $semesterid && $course->semesterid != 0 && $semesterid != 0) continue;
			if(isCourseOutOfDate($course)) continue;
				
			if($enrollment->roleid == SSPACE_ROLE_TEACHER)
				$object = getdbosql('Object', "recordings and parentid=$course->id");
			else
				$object = userRecordingFolder($course, $user);
			
			$objectlist[] = $object;
		}

		$object = $user->folder;
		if($object)
			$objectlist[] = $object;
	}

	else if($id == 'myfavorites')
	{
		foreach($user->favorites as $favorite)
			$objectlist[] = $favorite->object;
	}

	else
	{
		$object = getdbo('Object', $id);
		if(!$object) return null;

		if($object->type == CMDB_OBJECTTYPE_LINK)
			$id = $object->linkid;

// 		if($object->recordings || $object->parent->recordings)
// 			$sql = "parentid={$object->id}";
// 		else
// 			$sql = buildSimpleObjectQuery($user, $id);

// 		$objects = getdbolist('Object', $sql);
// 		$objects = filterSemesters($objects);
		
		$objects = objectContentList($object);
		
		foreach($objects as $object)
			$objectlist[] = $object;
	}

	$objectlist = filterRecordingNames($objectlist);
	return $objectlist;
}




