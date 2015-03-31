<?php

require('data.php');
require('lib.php');

//debuglog($_SERVER['REQUEST_URI']);

$criteria = new CDbCriteria;

$criteria->condition = "session.starttime + interval session.duration second >= '$after' and ".
	"session.starttime < '$before'";

if(!empty($users))
	$criteria->condition .= " and (t1.name like '%$users%' or t1.logon like '%$users%')";

if(!empty($clients))
	$criteria->condition .= " and (t2.remotename like '%$clients%' or t2.remoteip like '%$clients%')";

if(!empty($platforms))
	$criteria->condition .= " and session.platform like '%$platforms%'";

$pages = new CPagination(Session::model()->with('user', 'client')->count($criteria));
$pages->pageSize = 30;
$pages->applyLimit($criteria);

$sessions = Session::model()->with('user', 'client')->findAll($criteria);

$downloadlink = l(mainimg('16x16_bottom.png'), 
	array('logcsv', 
		'userid'=>$userid,
		'clientid'=>$clientid,
		'after'=>$after,
		'before'=>$before,
		'users'=>$users,
		'clients'=>$clients,
		'platforms'=>$platforms,
	), 
	array('title'=>'Download CSV', 'target'=>'_blank'));

$currentPage = $pages->currentPage+1;
echo "<font color=green>".count($sessions)." / {$pages->itemCount} sessions found. Page {$currentPage} of {$pages->pageCount}</font>&nbsp;&nbsp;$downloadlink<br><br>";

$this->widget('CLinkPager', array('pages'=>$pages));
if($pages->pageCount > 1) echo "<br><br>";

showTableSorter('maintable', '{headers: {0: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th></th>";
echo "<th>User</th>";
echo "<th>Client</th>";
echo "<th>Platform</th>";
echo "<th>Start Time</th>";
echo "<th>Duration</th>";
echo "<th>Session</th>";
echo "</tr></thead><tbody>";

foreach($sessions as $model)
{
	$image = userImage($model->user, 18);

	echo "<tr class='ssrow'>";
	echo "<td align=center>$image</td>";
	echo "<td style='font-weight: bold;'>".
		l("{$model->user->name}", array('user/update', 'id'=>$model->user->id))."</td>";

	echo "<td>";
	echo l("{$model->client->remotename}", array('client/update', 'id'=>$model->client->id),
		array('title'=>$model->client->remoteip));
	echo "</td>";

	echo "<td>$model->platform</td>";
	echo "<td nowrap>".datetoa($model->starttime)."</td>";
	echo "<td nowrap>".sectoa($model->duration)."</td>";

	echo "<td>".l($model['id'], array('filesession/', 'sessionid'=>$model['id']))."</td>";
	echo "</tr>";
}

echo "</tbody></table>";

echo "<br>";
$this->widget('CLinkPager', array('pages'=>$pages));

echo "<script>$(function(){
	$('a', '.yiiPager').click(function()
	{
		SansspaceSessionToolbar.pageChanged($(this));
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
echo "<br>";



