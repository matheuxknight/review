<?php

//debuglog($_SERVER['REQUEST_URI']);
include 'data.php';
include "variables.php";

$table_names = array(
	CMDB_EXPORTTYPE_SESSION=>'session',
	CMDB_EXPORTTYPE_FILESESSION=>'filesession',
	CMDB_EXPORTTYPE_RECORDSESSION=>'recordsession',
);

$table_name = $table_names[$export->type];

$params = "from $table_name, user, vfile where ".
	"$table_name.starttime + interval $table_name.duration second >= '$after' and ".
	"$table_name.starttime < '$before' and ".
	"$table_name.userid=user.id and $table_name.fileid=vfile.id ";

if(!empty($users))
	$params .= " and (user.name like '%$users%' or user.logon like '%$users%' or user.custom1 like '%$users%')";

$pages = new CPagination(dboscalar("select count(*) $params"));
$pages->pageSize = 30;

$params .= " order by $table_name.id";
$params .= ' limit '.$pages->currentPage*$pages->pageSize.', '.$pages->pageSize;

$sessions = dbolist("select $table_name.* $params");

$downloadlink = l(mainimg('16x16_bottom.png'),
	array('logcsv',
		'id'=>$export->id,
		'objectid'=>$objectid,
		'after'=>$after,
		'before'=>$before,
		'users'=>$users,
	),
	array('title'=>'Download CSV', 'target'=>'_blank'));

$currentPage = $pages->currentPage+1;
echo "<font color=green>".count($sessions)." / {$pages->itemCount} sessions found. Page {$currentPage} of {$pages->pageCount}</font>&nbsp;&nbsp;$downloadlink<br><br>";

$this->widget('CLinkPager', array('pages'=>$pages));
if($pages->pageCount > 1) echo "<br><br>";

showTableSorter('maintable', '{headers: {0: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";

if(!empty($export->titleformat))
{
	$titles = explode(',', $export->titleformat);
	foreach($titles as $title) echo "<th>$title</th>";
}

echo "</tr></thead><tbody>";

foreach($sessions as $model)
{
	$user = getdbo('User', $model['userid']);
	$file = getdbo('VFile', $model['fileid']);
	$course = getRelatedCourse($file, $user, $semester);
	
	$count = preg_match_all('/\$([a-z]+)\.([a-z]+)/', $export->dataformat, $matches);
	$a = CustomGetValueTable($export, $user, $file, $course, $model);
	
	echo "<tr class='ssrow'>";
	for($i = 0; $i < $count; $i++)
		for($i = 0; $i < $count; $i++)
		{
			$value = $a[$matches[1][$i]][$matches[2][$i]];
			echo "<td>$value</td>";
		}
	
	echo "</tr>";
}

echo "</tbody></table>";

echo "<br>";
$this->widget('CLinkPager', array('pages'=>$pages));

echo "<script>$(function(){
	$('a', '.yiiPager').click(function()
	{
		SansspaceCustomExportToolbar.pageChanged($(this));
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



