<?php

//debuglog($_SERVER['REQUEST_URI']);
require('data.php');

header('Content-type: text/csv');
header("Content-disposition: attachment;filename=$object->name-$user->name-summary.csv");

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

$params = "select vfile.id, count(*), sum(filesession.duration) from filesession, vfile where ".
		"filesession.starttime + interval filesession.duration second >= '$after' and ".
		"filesession.starttime < '$before' and ".
		"filesession.userid=$userid and filesession.fileid=vfile.id and ".
		"($stringparent) $extraparams group by vfile.id order by vfile.name";

$listfile = dbolist("$params");

echo "File,Folder,Views,Time\r\n";
foreach($listfile as $model)
{
	$object = getdbo('Object', $model['id']);
	$opencount = $model['count(*)'];
	$playtime = sectoa($model['sum(filesession.duration)']);
	
	echo "$object->name,{$object->parent->name},$opencount,$playtime\r\n";
}



