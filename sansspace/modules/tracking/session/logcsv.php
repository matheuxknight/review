<?php

require('data.php');
require('lib.php');

header('Content-type: text/csv');
header('Content-disposition: attachment;filename=sessions.csv');

$criteria = new CDbCriteria;

$criteria->condition = "session.starttime + interval session.duration second >= '$after' and ".
		"session.starttime < '$before'";

if(!empty($users))
	$criteria->condition .= " and (t1.name like '%$users%' or t1.logon like '%$users%')";

if(!empty($clients))
	$criteria->condition .= " and (t2.remotename like '%$clients%' or t2.remoteip like '%$clients%')";

if(!empty($platforms))
	$criteria->condition .= " and session.platform like '%$platforms%'";

$sessions = Session::model()->with('user', 'client')->findAll($criteria);

echo "User,Client,Platforms,Start Time,Duration,Session\r\n";
foreach($sessions as $model)
{
	echo "\"{$model->user->name}\",{$model->client->remotename},\"$model->platform\",";
	echo "$model->starttime,".sectoa($model->duration).",$model->id\r\n";
}







