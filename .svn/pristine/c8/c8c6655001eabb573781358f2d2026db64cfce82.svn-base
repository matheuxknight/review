<?php

//debuglog($_SERVER['REQUEST_URI']);
require('data.php');

header('Content-type: text/csv');
header("Content-disposition: attachment;filename=$object->name-summary.csv");

/////////////////////////////////////////////////////////////////////////////

$listparent = array($object->id);

$tmp = dbocolumn("select linkid from object where parentlist like '%, $object->id, %' and type=".CMDB_OBJECTTYPE_LINK);
$listparent = array_unique(array_merge($listparent, $tmp));

$parent = $object;
while($parent && $parent->model)
{
	$tmp = dbocolumn("select linkid from object where parentid = $parent->id and type=".CMDB_OBJECTTYPE_LINK);
	$listparent = array_unique(array_merge($listparent, $tmp));

	$parent = $parent->parent;
}

$tmp = dbocolumn("select id from object where parentid=$object->id and recordings");
$listparent = array_unique(array_merge($listparent, $tmp));

$stringparent = '0';
foreach($listparent as $id)
	$stringparent .= " or vfile.parentlist like '%, $id, %'";

/////////////////////////////////////////////////////////////////////////////

$extraparams = '';
if(!empty($files))
	$extraparams .= " and vfile.name like '%$files%'";

$criteria = new CDbCriteria;
$criteria->condition = 'courseenrollment.objectid='.$object->id;
$listuser = CourseEnrollment::model()->with('role', 'user')->findAll($criteria);

echo "User,Views,Time,Record,Status,Grade,Role\r\n";
foreach($listuser as $model)
{
	$recordtime = sectoa(getRecordTime($object, $model->user));

	$params = "select count(*), sum(filesession.duration) from filesession, user, vfile where ".
		"filesession.starttime + interval filesession.duration second >= '$after' and ".
		"filesession.starttime < '$before' and ".
		"filesession.userid=user.id and filesession.fileid=vfile.id and ".
		"($stringparent) and user.id={$model->user->id} $extraparams";

	$row = dborow($params);
	$opencount = $row['count(*)'];
	$playtime = sectoa($row['sum(filesession.duration)']);

	$totalopen += $opencount;
	$totalplay += $playtime;
	$totalrecord += $recordtime;

	echo "{$model->user->name},$opencount,$playtime,$recordtime,$model->statusText,$model->grade,";
	echo "{$model->role->description}\r\n";

}




