<?php

$domain = getdbo('Domain', 1);
$pathname = "c:\\db\\southington\\JFK_SANS_PICCO_EXPORT.csv";
$file = fopen($pathname, 'r');

// southington import script
debuglog("import-roster-southington started");

$languagecourses = safeCreateObject("Language Courses", CMDB_OBJECTROOT_ID);
$semester = getCurrentSemester();

// skip first line
$line = fgetcsv($file);

while(!feof($file))
{
	$line = fgetcsv($file);
	if(!$line) continue;

//	old format that was provided once
// 	if(count($line) == 11)
// 	{
// 		$coursename = "{$line[1]} ({$line[4]} {$line[3]})";
// 		$logonname = strtolower($line[10]);
// 		$username = $line[7];
// 	}

//	$coursename = "{$line[1]} ({$line[5]}) Period {$line[3]}";
	$coursename = "{$line[1]} ({$line[5]} {$line[3]})";
	$foldername = $line[1];
	$logonname = strtolower($line[12]);
	$username = $line[8];
	$emailname = "{$logonname}@southingtonschools.org";
	$siteid = $line[0];

	$languagename = 'New Courses';
	if(ereg("(^[A-Za-z]+)", $line[1], $match))
		$languagename = $match[1];
	
	/////////////////////////////////////////////////////////////////////
	
	$language = safeCreateObject($languagename, $languagecourses->id);
	$language->model = true;
	$language->save();
	
	$folder = safeCreateObject($foldername, $language->id);
	$folder->model = true;
	$folder->save();
	
	$course = safeCreateCourse($coursename, $folder->id, $semester->id);
	$course->model = true;
	$course->semesterid = $semester->id;
	$course->save();
	
	$objectext = $course->object->ext;
	$objectext->custom = "$siteid";
	$objectext->save();
	
	if(!isset($cleaned[$course->id]))
	{
		dborun("delete from CourseEnrollment where objectid=$course->id and roleid=".SSPACE_ROLE_STUDENT);
		$cleaned[$course->id] = true;
	}
	
	$user = safeCreateUser($logonname, $username, $emailname, $domain->id);
	safeCourseEnrollment($user->id, SSPACE_ROLE_STUDENT, $course->id);
}

debuglog("import-roster-southington completed");

