<?php 

$domain = getdbo('Domain', 1);
$pathname = "c:\\db\\smc\\roster_data.txt";
$file = fopen($pathname, 'r');

// smc import script
debuglog("import-roster-smc started");

$namemap = array
(
	'ARAB'=>'Arabic',
	'CHIN'=>'Chinese',
	'FRENCH'=>'French',
	'GAEL'=>'Gaelic',
	'GERM'=>'German',
	'GRK' =>'Greek',
	'HEBR'=>'Hebrew',
	'ITAL'=>'Italian',
	'JAPAN'=>'Japanese',
	'LAT' =>'Latin',
	'MGRK'=>'Modern Greek',
	'PER' =>'Peru',
	'PORT'=>'Portuguese',
	'PUNJ'=>'Punji',
	'RUS' =>'Russian',
	'SPAN'=>'Spanish',
	'SWAH'=>'Swahli',
	'SED' =>'Education',
);

$languagecourses = safeCreateObject("Language Courses", CMDB_OBJECTROOT_ID);
$line = fgetcsv($file);

$semester = getdbosql('Semester', "name='{$line[0]}'");
if(!$semester)
{
	$semester = new Semester;
	$semester->name = $line[0];
}

$semester->starttime = date("Y-m-d", strtotime($line[1]));
$semester->endtime = date("Y-m-d", strtotime($line[2]));
$semester->save();

$cleaned = array();
while(!feof($file))
{
	$line = fgetcsv($file);
	if(!$line) continue;
	
	$foldername = $line[0];
	$semcode = $line[4];
	$section = $line[5];
	
	$teacherlogin = $line[3];
	$teachername = $line[1];
	$teacheremail = $line[2];
	
	$studentlogin = $line[7];
	$studentname = "{$line[10]} {$line[11]} {$line[9]}";
	$studentemail = $line[6];
	$studentid = $line[8];
	
	$coursename = "$foldername $teachername $section";
	if(empty($foldername)) continue;
	
	/////////////////////////////////////////////////////////////////////
	
	$languagename = 'New Courses';
	if(ereg("(^[A-Z]+)", $coursename, $match) && isset($namemap[$match[1]]))
		$languagename = $namemap[$match[1]];

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
	$objectext->custom = "$semcode, $section";
	$objectext->save();
	
	if(!isset($cleaned[$course->id]))
	{
		dborun("delete from CourseEnrollment where objectid=$course->id");
		$cleaned[$course->id] = true;
	}

	if(!empty($teacherlogin))
	{
		$teacher = safeCreateUser($teacherlogin, $teachername, $teacheremail, $domain->id);
		safeCourseEnrollment($teacher->id, SSPACE_ROLE_TEACHER, $course->id);
	}
	
	if(!empty($studentlogin))
	{
		$student = safeCreateUser($studentlogin, $studentname, $studentemail, $domain->id);
		$student->custom1 = $studentid;
		$student->save();
		
		safeCourseEnrollment($student->id, SSPACE_ROLE_STUDENT, $course->id);
	}

}

debuglog("import-roster-smc completed");


