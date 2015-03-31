<?php

//debuglog($_SERVER['REQUEST_URI']);
require('data.php');

$at = strtotime($after);
$bt = strtotime($before);

$days = round(($bt - $at)/60/60/24);

$as = strftime("%A %B %d %Y", $at);
$bs = strftime("%A %B %d %Y", $bt);

$downloadlink = l(mainimg('16x16_bottom.png'),
	array('summarycsv',
		'id'=>$objectid,
		'userid'=>$userid,
		'after'=>$after,
		'before'=>$before,
	),
	array('title'=>'Download CSV', 'target'=>'_blank'));

echo "Summary for the $days days period between $as and $bs.&nbsp;&nbsp;$downloadlink<br><br>";

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

showTableSorter('maintable', '{headers: {0: {sorter: false}, 2: {sorter: false}}}');

echo "<thead class='ui-widget-header'><tr>";
echo "<th width=20></th>";
echo "<th>File</th>";
echo "<th width=20></th>";
echo "<th>Folder</th>";
echo "<th>Views</th>";
echo "<th>Time</th>";
echo "</tr></thead><tbody>";

$totalopen = 0;
$totalplay = 0;

foreach($listfile as $model)
{
	$object = getdbo('Object', $model['id']);
	$opencount = $model['count(*)'];
	$playtime = $model['sum(filesession.duration)'];

	echo "<tr class='ssrow'>";
	echo "<td>".objectImage($object, 18)."</td>";

	echo "<td style='font-weight: bold;'>";
	showObjectMenuContext($object);
	echo "</td>";

	echo "<td>".objectImage($object->parent, 18)."</td>";

	echo "<td style='font-weight: bold;'>";
	showObjectMenuContext($object->parent);
	echo "</td>";

	$totalopen += $opencount;
	$totalplay += $playtime;

	echo "<td>$opencount</td>";
	echo "<td>".sectoa($playtime)."</td>";

	echo "</tr>";
}

echo "</tbody>";
echo "<tr>";
echo "<th></th>";
echo "<th><b>Total: ".count($listfile)."</b></th>";

echo "<th></th>";
echo "<th></th>";

echo "<th>$totalopen</th>";
echo "<th>".sectoa($totalplay)."</th>";

echo "</tr>";
echo "</table>";



