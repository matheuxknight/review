<?php

//debuglog($_SERVER['REQUEST_URI']);
require('data.php');

header('Content-type: text/csv');
header("Content-disposition: attachment;filename=$object->name-$user->name-log.csv");

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

$params = "from filesession, vfile where ".
	"filesession.starttime + interval filesession.duration second >= '$after' and ".
	"filesession.starttime < '$before' and ".
	"filesession.userid=$userid and filesession.fileid=vfile.id and ".
	"($stringparent) $extraparams";

$params .= ' order by filesession.id';
$sessions = dbolist("select filesession.* $params");

echo "File,Folder,Start Time,Duration\r\n";
foreach($sessions as $model)
{
	$object = getdbo('Object', $model['fileid']);
	$duration = sectoa($model['duration']);
	echo "$object->name,{$object->parent->name},{$model['starttime']},$duration\r\n";
}

