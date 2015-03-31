<?php

//debuglog($_SERVER['REQUEST_URI']);

require('data.php');
require('lib.php');

header('Content-type: text/csv');
header("Content-disposition: attachment;filename=$object->name-log.csv");

$listuser = dbocolumn("select userid from courseenrollment where objectid=$object->id");
$stringuser = implode(',', $listuser);

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

////////////////////////////////////////////////////////////////////////

$extraparams = '';
if(!empty($files))
	$extraparams .= " and vfile.name like '%$files%'";

$params = "from filesession, user, vfile where ".
		"filesession.starttime + interval filesession.duration second >= '$after' and ".
		"filesession.starttime < '$before' and ".
		"filesession.userid=user.id and filesession.fileid=vfile.id and ".
		"($stringparent) and user.id in ($stringuser) $extraparams";

$params .= ' order by filesession.id';
$sessions = dbolist("select filesession.* $params");

echo "File,User,Start Time,Duration\r\n";
foreach($sessions as $model)
{
	$user = getdbo('User', $model['userid']);
	$object = getdbo('Object', $model['fileid']);
	$starttime = $model['starttime'];

	echo "\"$object->name\",\"$user->name\",";
	echo "$starttime,".sectoa($model['duration'])."\r\n";
}





