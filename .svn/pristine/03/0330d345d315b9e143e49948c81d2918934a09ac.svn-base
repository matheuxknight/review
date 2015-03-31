<?php

//debuglog($_SERVER['REQUEST_URI']);

require('data.php');
require('lib.php');

header('Content-type: text/csv');
header('Content-disposition: attachment;filename=recordsessions.csv');

$params = "from recordsession, user, vfile where ".
	"recordsession.starttime + interval recordsession.duration second >= '$after' and ".
	"recordsession.starttime < '$before' and ".
	"recordsession.userid=user.id and recordsession.fileid=vfile.id";

if(!empty($users))
	$params .= " and (user.name like '%$users%' or user.logon like '%$users%' or user.custom1 like '%$users%')";

if($sessionid)
	$params .= " and recordsession.sessionid=$sessionid";

$params .= ' order by recordsession.id';
$sessions = dbolist("select recordsession.* $params");

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







