<?php

//debuglog($_SERVER['REQUEST_URI']);

require('data.php');
require('lib.php');

header('Content-type: text/csv');
header('Content-disposition: attachment;filename=filesessions.csv');

$params = "from filesession, user, vfile where ".
	"filesession.starttime + interval filesession.duration second >= '$after' and ".
	"filesession.starttime < '$before' and ".
	"filesession.userid=user.id and filesession.fileid=vfile.id and ".
	"vfile.parentlist like '%, $objectid, %'";

if(!empty($users))
	$params .= " and (user.name like '%$users%' or user.logon like '%$users%' or user.custom1 like '%$users%')";

if($sessionid)
	$params .= " and filesession.sessionid=$sessionid";

$params .= ' order by filesession.id';
$sessions = dbolist("select filesession.* $params");

echo "File,User,Start Time,Duration,Session\r\n";
foreach($sessions as $model)
{
	$user = getdbo('User', $model['userid']);
	$object = getdbo('Object', $model['fileid']);
	$starttime = $model['starttime'];
	$sessionid = $model['sessionid'];
	
	echo "\"$object->name\",\"$user->name\",";
	echo "$starttime,".sectoa($model['duration']).",$sessionid\r\n";
}







