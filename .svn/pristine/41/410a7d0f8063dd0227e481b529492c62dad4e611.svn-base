<?php

require('data.php');
require('lib.php');

$params = "from filesession, user, vfile where ".
	"filesession.starttime + interval filesession.duration second >= '$after' and ".
	"filesession.starttime < '$before' and ".
	"filesession.userid=user.id and filesession.fileid=vfile.id and ".
	"vfile.parentlist like '%, $objectid, %'";

if(!empty($users))
	$params .= " and (user.name like '%$users%' or user.logon like '%$users%' or user.custom1 like '%$users%')";

if($sessionid)
	$params .= " and filesession.sessionid=$sessionid";

$pages = new CPagination(dboscalar("select count(*) $params"));
$pages->pageSize = 30;

$params .= ' order by filesession.id';
$params .= ' limit '.$pages->currentPage*$pages->pageSize.', '.$pages->pageSize;

$sessions = dbolist("select filesession.* $params");

$downloadlink = l(mainimg('16x16_bottom.png'),
	array('logcsv',
		'sessionid'=>$sessionid,
		'userid'=>$userid,
		'clientid'=>$clientid,
		'id'=>$objectid,
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
echo "<th></th>";
echo "<th>File</th>";
echo "<th>User</th>";
echo "<th>Start Time</th>";
echo "<th>Duration</th>";
echo "<th>Session</th>";
echo "</tr></thead><tbody>";

foreach($sessions as $model)
{
	$user = getdbo('User', $model['userid']);
	$object = getdbo('Object', $model['fileid']);

	echo "<tr class='ssrow'>";
	echo "<td width=20>".objectImage($object, 18)."</td>";

	echo "<td><b>";
	showObjectMenuContext($object);
	echo "</b></td>";

	echo "<td><b>".l("{$user->name}", array('user/update', 'id'=>$user->id))."</b></td>";

	echo "<td nowrap>".datetoa($model['starttime'])."</td>";
	echo "<td nowrap>".sectoa($model['duration'])."</td>";
	echo "<td>".l($model['sessionid'], array('filesession/', 'sessionid'=>$model['sessionid']))."</td>";

	echo "</tr>";
}

echo "</tbody></table>";

echo "<br>";
$this->widget('CLinkPager', array('pages'=>$pages));

echo "<script>$(function(){
	$('a', '.yiiPager').click(function()
	{
		SansspaceFileSessionToolbar.pageChanged($(this));
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



