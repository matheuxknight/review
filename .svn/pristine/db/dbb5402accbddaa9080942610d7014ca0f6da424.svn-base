<?php 

$pathname = "c:\\db\\rutgers\\roster.txt";
$file = fopen($pathname, 'r');

// Rutgers import script

$semester = getCurrentSemester();
$languagecourses = safeCreateObject("Language Courses", CMDB_OBJECTROOT_ID);

$cleaned = array();
while(!feof($file))
{
	// GERMAN 101,elizthom,Elizabeth deWolfe,student
	$line = fgetcsv($file);
	if(!$line) continue;

	$coursename = $line[0];
	$logonname = strtolower($line[1]);
	$username = $line[2];
	$rolename = $line[3];
	$emailname = "$logonname@rutgers.edu";
	
	if(empty($logonname)) continue;

	$roleid = SSPACE_ROLE_STUDENT;
	$role = getdbosql('Role', "name='$rolename'");
	if($role) $roleid = $role->id;

	$languagename = 'New Courses';
	if(ereg("(^[A-Z]+)", $coursename, $match))
		$languagename = $match[1];

	/////////////////////////////////////////////////////////////////////
	
	$language = safeCreateObject($languagename, $languagecourses->id);
	$language->model = true;
	$language->save();

	$course = safeCreateCourse($coursename, $language->id, $semester->id);
	$course->model = true;
	$course->semesterid = $semester->id;
	$course->save();
	
	$user = safeCreateUser($logonname, $username, $emailname, $domain->id);
	
	if(!isset($cleaned[$course->id]))
	{
		dborun("delete from CourseEnrollment where objectid=$course->id");
		$cleaned[$course->id] = true;
	}
	
	safeCourseEnrollment($user->id, $roleid, $course->id);
}



