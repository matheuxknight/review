<?php

// smc sessions export script
debuglog("export-session-smc started");
//$filename = 'D:/SANSSPACE/userroster/stu_usage_data.csv';
$filename = 'c/db/smc/stu_usage_data.csv';

$semester = getCurrentSemester();
$courses = getdbolist('VCourse', "semesterid=$semester->id");

$fout = fopen($filename, 'w');
if(!$fout) return;

foreach($courses as $course)
{
	$objectext = $course->object->ext;
	foreach($course->enrollment as $e)
	{
		$user = $e->user;
		if(empty($user->custom1)) continue;
		
		$startreport = time()-24*60*60;
		$starttime = date('Y-m-d H:i', $startreport);
		
		$sql = "starttime + interval duration second>'$starttime' and userid=$user->id";
		$sessions = getdbolist('Session', $sql);
		
		foreach($sessions as $session)
		{
			$starttime = strtotime($session->starttime);
			if($starttime < $startreport)
			{
				$session->duration -= $startreport - $starttime;
				$starttime = $startreport;
			}

			$intime = date('Ymd H:i:s', $starttime);
			$outtime = date('Ymd H:i:s', $starttime+$session->duration);
			
		//	debuglog("$user->custom1, $objectext->custom, $intime, $outtime");
			fwrite($fout, "$user->custom1, $objectext->custom, $intime, $outtime");
		}
	}
}

fclose($fout);
debuglog("export-session-smc completed");
