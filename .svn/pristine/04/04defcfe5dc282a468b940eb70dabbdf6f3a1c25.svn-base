<?php

//debuglog($_SERVER['REQUEST_URI']);
include 'data.php';
include "variables.php";

header('Content-type: text/csv');
header('Content-disposition: attachment;filename=custom.csv');

$table_names = array(
	CMDB_EXPORTTYPE_SESSION=>'session',
	CMDB_EXPORTTYPE_FILESESSION=>'filesession',
	CMDB_EXPORTTYPE_RECORDSESSION=>'recordsession',
);

$table_name = $table_names[$export->type];

$params = "from $table_name, user, vfile where ".
	"$table_name.starttime + interval $table_name.duration second >= '$after' and ".
	"$table_name.starttime < '$before' and $table_name.userid != 1 and ".
	"$table_name.userid=user.id and $table_name.fileid=vfile.id";

if(!empty($users))
	$params .= " and (user.name like '%$users%' or user.logon like '%$users%' or user.custom1 like '%$users%')";

$sessions = dbolist("select $table_name.* $params order by $table_name.id");

if(!empty($export->titleformat))
	echo "$export->titleformat\r\n";

foreach($sessions as $model)
{
	$user = getdbo('User', $model['userid']);
	$file = getdbo('VFile', $model['fileid']);
	$course = getRelatedCourse($file, $user, $semester);
		
	$count = preg_match_all('/\$([a-z]+)\.([a-z]+)/', $export->dataformat, $matches);
	$a = CustomGetValueTable($export, $user, $file, $course, $model);

	for($i = 0; $i < $count; $i++)
		for($i = 0; $i < $count; $i++)
		{
			$value = $a[$matches[1][$i]][$matches[2][$i]];
			echo "$value,";
		}
	
	echo "\r\n";
}



