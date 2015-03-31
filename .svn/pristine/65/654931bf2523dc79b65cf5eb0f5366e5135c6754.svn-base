<?php

$other_table = array(
	'0'=>'Predefined',
	'1'=>'Last 24 Hours',
	'2'=>'Last 48 Hours',
	'3'=>'Last 7 Days',
	'4'=>'Last 14 Days',
	'5'=>'Last 30 Days',
);

$month_table = array(
	'0'=>'Month',
	'1'=>'January',
	'2'=>'February',
	'3'=>'March',
	'4'=>'April',
	'5'=>'May',
	'6'=>'June',
	'7'=>'July',
	'8'=>'August',
	'9'=>'September',
	'10'=>'October',
	'11'=>'November',
	'12'=>'December',
);

///////////////////////////////////////////////////////////////////////////////////

$group_table = array(
	'0'=>'Group by',
	'1'=>'Folder',
);

$build_table = array(
	1 => array(2*24*60*60, "+1 hour"),
	2 => array(6*24*60*60, "+2 hour"),
	3 => array(12*24*60*60, "+4 hour"),
	4 => array(24*24*60*60, "+8 hour"),
	5 => array(80*24*60*60, "+1 day"),
	6 => array(400*24*60*60, "+7 days"),
	7 => array(0, "+1 month"),
	8 => array(0, "+3 months"),
);

$scale_table = array(
	'0'=>'Auto',
	'1'=>'Hourly',
	'2'=>'2 Hours',
	'3'=>'4 Hours',
	'4'=>'8 Hours',
	'5'=>'Daily',
	'6'=>'Weekly',
	'7'=>'Monthly',
	'8'=>'Quarterly',
);

$type_table = array(
	'0'=>'Views',
	'1'=>'Hours',
);

$searchfiles = 'Search files';

///////////////////////////////////////////////////////////////////////////////////

$objectid = getparam('id');
$object = getdbo('Object', $objectid);

$course = $object->course;
if(!$course) $course = getContextCourse();

$semester = $course->semester;
if(!$semester) $semester = getCurrentSemester();

$after = getparam('after');
$before = getparam('before');

$group = getparam('group');
$scale = getparam('scale');
$type = getparam('type');

$files = getparam('files');
if($files == $searchfiles) $files = '';

$starttime = strtotime($after);
$endtime = strtotime($before);
$totallength = $endtime - $starttime;




