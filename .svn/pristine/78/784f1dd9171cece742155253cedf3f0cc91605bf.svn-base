<?php

function dateIncrementYear($s)
{
	$y = date("Y", strtotime($s));
	$m = date("m", strtotime($s));
	$d = date("d", strtotime($s));
	$t = mktime(0, 0, 0, $m, $d, intval($y)+1);
	return date('Y-m-d', $t);
}

function getCurrentSemester()
{
	$semester = getdbosql('Semester', "starttime < now() and endtime + interval 24 hour > now()");
	if(!$semester)
	{
		// update templates year
		$templates = getdbolist('Semestertemplate');
		foreach($templates as $template)
		{
			while(strtotime($template->endtime) < time())
			{
				$template->starttime = dateIncrementYear($template->starttime);
				$template->endtime = dateIncrementYear($template->endtime);
				
				$template->save();
			}
		}

		// create new semester using templates
		$template = getdbosql('Semestertemplate', "starttime < now() and endtime + interval 24 hour > now()");

		$year = date("Y", time());
		$semester = new Semester;
		$semester->name = "$template->name $year";
		$semester->starttime = $template->starttime;
		$semester->endtime = $template->endtime;
		
		$semester->save();
	}
	
//	debuglog("curretn semeter $semester->name");
	return $semester;
}


