<?php 

debuglog("export-session-smc started");
//$filename = 'D:/SANSSPACE/userroster/stu_usage_data.csv';
$filename = 'c:/db/smc/stu_usage_data.csv';

$fout = fopen($filename, 'w');
if(!$fout) return;

$startreport = time()-7*24*60*60;
$starttime = date('Y-m-d H:i', $startreport);

$semester = getCurrentSemester();
$courses = getdbolist('VCourse', "semesterid=$semester->id");

foreach($courses as $course)
{
	$objectext = $course->object->ext;

	$listuser = dbocolumn("select userid from courseenrollment where objectid=$course->id");
	$stringuser = implode(',', $listuser);
	
	$listparent = array($course->id);
	
	$tmp = dbocolumn("select linkid from object where parentlist like '%, $course->id, %' and type=".CMDB_OBJECTTYPE_LINK);
	$listparent = array_unique(array_merge($listparent, $tmp));
	
	$parent = $course->object;
	while($parent && $parent->model)
	{
		$tmp = dbocolumn("select linkid from object where parentid = $parent->id and type=".CMDB_OBJECTTYPE_LINK);
		$listparent = array_unique(array_merge($listparent, $tmp));
	
		$parent = $parent->parent;
	}
	
	$tmp = dbocolumn("select id from object where parentid=$course->id and recordings");
	$listparent = array_unique(array_merge($listparent, $tmp));

	$stringparent = '0';
	foreach($listparent as $id)
		$stringparent .= " or vfile.parentlist like '%, $id, %'";
	
	////////////////////////////////////////////////////////////////////////
	
	$params = "from filesession, user, vfile where ".
			"filesession.starttime + interval filesession.duration second >= '$starttime' and ".
			"filesession.userid=user.id and filesession.fileid=vfile.id and ".
			"($stringparent) and user.id in ($stringuser)";
	
	$sessions = dbolist("select filesession.* $params order by filesession.id");
	foreach($sessions as $model)
	{
		$user = getdbo('User', $model['userid']);
		$start = strtotime($model['starttime']);
		
		$intime = date('Ymd H:i:s', $start);
		$outtime = date('Ymd H:i:s', $start+$model['duration']);
		
	//	debuglog("$user->custom1, $objectext->custom, $intime, $outtime");
		fwrite($fout, "$user->custom1, $objectext->custom, $intime, $outtime");
	}
}

fclose($fout);
debuglog("export-session-smc completed");

