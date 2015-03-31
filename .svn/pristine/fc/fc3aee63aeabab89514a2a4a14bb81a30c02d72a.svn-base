<?php

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

$other_table = array(
	'0'=>'Others',
	'1'=>'Last 24 Hours',
	'2'=>'Last 48 Hours',
	'3'=>'Last 7 Days',
	'4'=>'Last 14 Days',
	'5'=>'Last 30 Days',
	'6'=>'Last 60 Days',
	'7'=>'Last 90 Days',
	'8'=>'Last 12 Months',
	'9'=>'All Data',
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

$searchusers = 'Search users';

///////////////////////////////////////////////////////////////////////////////////

$semesterid = getparam('semesterid');
$sessionid = getparam('sessionid');
$userid = getparam('userid');
$clientid = getparam('clientid');

$year = getparam('year');
$month = getparam('month');
$other = getparam('other');
$after = getparam('after');
$before = getparam('before');

$group = getparam('group');
$scale = getparam('scale');
$type = getparam('type');

$users = getparam('users');
if($users == $searchusers) $users = '';

$starttime = strtotime($after);
$endtime = strtotime($before);
$totallength = $endtime - $starttime;

///////////////////////////////////////////////////////////////////////////////////

$title = '';
if($semesterid)
{
	$semester = getdbo('Semester', $semesterid);
	$title .= $semester->name.' ';
}

if($month)
	$title .= GetMonthString($month).' ';

if($year)
	$title .= $year;

if($other)
	$title .= $other_table[$other];

if(empty($title))
	$title = 'Custom Dates';



