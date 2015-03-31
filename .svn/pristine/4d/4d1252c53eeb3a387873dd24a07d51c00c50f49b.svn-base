<?php

//debuglog($_SERVER['REQUEST_URI']);
require('data.php');

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

$pages = new CPagination(dboscalar("select count(*) $params"));
$pages->pageSize = 30;

$params .= ' order by filesession.id';
$params .= ' limit '.$pages->currentPage*$pages->pageSize.', '.$pages->pageSize;

$sessions = dbolist("select filesession.* $params");

$downloadlink = l(mainimg('16x16_bottom.png'),
	array('logcsv',
		'id'=>$objectid,
		'userid'=>$userid,
		'after'=>$after,
		'before'=>$before,
	),
	array('title'=>'Download CSV', 'target'=>'_blank'));

$currentPage = $pages->currentPage+1;
echo "<font color=green>".count($sessions)." / {$pages->itemCount} sessions found. Page {$currentPage} of {$pages->pageCount}</font>&nbsp;&nbsp;$downloadlink<br><br>";

$this->widget('CLinkPager', array('pages'=>$pages));
if($pages->pageCount > 1) echo "<br><br>";

showTableSorter('maintable', '{headers: {0: {sorter: false}, 2: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th></th>";
echo "<th>File</th>";
echo "<th></th>";
echo "<th>Folder</th>";
echo "<th>Start Time</th>";
echo "<th>Duration</th>";
echo "</tr></thead><tbody>";

foreach($sessions as $model)
{
	$object = getdbo('Object', $model['fileid']);

	echo "<tr class='ssrow'>";
	echo "<td width=20>".objectImage($object, 18)."</td>";

	echo "<td><b>";
	showObjectMenuContext($object);
	echo "</b></td>";

	echo "<td width=20>".objectImage($object->parent, 18)."</td>";

	echo "<td><b>";
	showObjectMenuContext($object->parent);
	echo "</b></td>";

	echo "<td nowrap>".datetoa($model['starttime'])."</td>";
	echo "<td nowrap>".sectoa($model['duration'])."</td>";

	echo "</tr>";
}

echo "</tbody></table>";

echo "<br>";
$this->widget('CLinkPager', array('pages'=>$pages));

echo "<script>$(function(){
	$('a', '.yiiPager').click(function()
	{
		SansspaceCourseStudent.pageChanged($(this));
		return false;
	});
});</script>";

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";



