<?php 

$pathname = "c:\\db\\hofstra\\roster1.txt";
$file = fopen($pathname, 'r');

// Hofstra import script
debuglog("import-roster-hofstra started");

$namemap = array
(
	'ARAB'=>'Arabic',
	'CHIN'=>'Chinese',
	'FREN'=>'French',
	'GAEL'=>'Gaelic',
	'GERM'=>'German',
	'GRK' =>'Greek',
	'HEBR'=>'Hebrew',
	'ITAL'=>'Italian',
	'JPAN'=>'Japanese',
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

$semester = getCurrentSemester();
$languagecourses = safeCreateObject("Language Courses", CMDB_OBJECTROOT_ID);

$titles = array();
$descriptions = array();

$cleaned = array();
while(!feof($file))
{
	// 200907,FREN002,70046,LNELSO2,700281891,Nelson La'Verne,S
	$line = fgetcsv($file);
	if(!$line) continue;

	$foldername = $line[1];
	$coursename = "{$line[1]} ({$line[2]})";
	$logonname = strtolower($line[3]);
	$username = $line[5];

	if(empty($logonname)) continue;

//	debuglog("$logonname");
	if($line[6] == 'F')
	{
		$roleid = SSPACE_ROLE_TEACHER;
		$emailname = "{$logonname}@hofstra.edu";
	}
	else
	{
		$roleid = SSPACE_ROLE_STUDENT;
		$emailname = "{$logonname}@pride.hofstra.edu";
	}
	
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
	
	$user = safeCreateUser($logonname, $username, $emailname, $domain->id);
	
	if(!isset($cleaned[$course->id]))
	{
		dborun("delete from CourseEnrollment where objectid=$course->id");
		$cleaned[$course->id] = true;
	}
	
	safeCourseEnrollment($user->id, $roleid, $course->id);
}

debuglog("import-roster-hofstra completed");







// if(!$useremotesite) continue;

// if(!isset($descriptions[$foldername]))
// {
// 	$b = preg_match('/([A-Z]*)([0-9]*)/', $foldername, $matches);
// 	if(!$b) continue;

// 	$url = "http://www.hofstra.edu/forms/FORMS_courseDescriptionForm.cfm?course={$matches[1]}&coursenum={$matches[2]}";
// 	$contents = @file_get_contents($url);

// 	if($contents)
// 	{
// 		$start = strpos($contents, '<table');
// 		$end = strrpos($contents, '</table>');
			
// 		$text = substr($contents, $start, $end - $start);
// 		$text = str_replace('#0B1E73', '#FFF4BF', $text);
// 		$text = str_replace('#000066', '#FFF4BF', $text);
			
// 		$b = preg_match('/class="resultCourse"><u>(.*?)<\/u>/i',
// 				$contents, $matches);
			
// 		$titles[$foldername] = "<b>{$matches[1]}</b><br>";
// 		$descriptions[$foldername] = $text;
// 	}
// 	else
// 		$useremotesite = false;


