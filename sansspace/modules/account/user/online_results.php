<?php

$order = getparam('order');
if(empty($order)) $order = 'duration';

$connected = CMDB_SESSIONSTATUS_CONNECTED;

$sessioncount = getdbocount('Session', "status=$connected and not isguest");
$guestcount = getdbocount('Session', "status=$connected and isguest");

if(getparam('guest') == 'checked')
	$sessionlist = getdbolist('Session', "status=$connected order by $order");
else
	$sessionlist = getdbolist('Session', "status=$connected and not isguest order by $order");

echo "<font color=green>$sessioncount authenticated user(s) and $guestcount anonymous guest(s).</font><br>";
echo "<br>";

echo "<table id='maintable' class='dataGrid2'>";
echo "<thead class='ui-widget-header'><tr>";

echo "<th width=20></th>";
echo "<th><a style='color: #555;' href='javascript:online_setorder(\"userid\");'>Name</a></th>";
echo "<th><a style='color: #555;' href='javascript:online_setorder(\"duration\");'>Duration</a></th>";
echo "<th><a style='color: #555;' href='javascript:online_setorder(\"timepage desc\");'>Idle</a></th>";
echo "<th><a style='color: #555;' href='javascript:online_setorder(\"clientid\");'>Client</a></th>";
echo "<th><a style='color: #555;' href='javascript:online_setorder(\"platform\");'>Platform</a></th>";
echo "<th><a style='color: #555;' href='javascript:online_setorder(\"lastpage\");'>Current Page</a></th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($sessionlist as $n=>$model)
{
	$user = $model->user;
	echo "<tr class='ssrow'>";

	echo "<td>".userImage($model->user, 18)."</td>";
	echo "<td style='font-weight: bold;'>";
//	showUserMenuContext($model->user, array('user/update', 'id'=>$model->user->id));

	$username = $user->name;
	if($model->phpsessid == controller()->identity->session->phpsessid)
		$username .= " (me)";
	
	echo l($username, array('user/update', 'id'=>$user->id));
	echo "</td>";

	echo "<td width=80>".sectoa($model->duration)."</td>";
	echo "<td width=80>".sectoa(time() - $model->timepage)."</td>";
	
	echo "<td>".l($model->client->remotename, array('session/', 'clients'=>$model->client->remoteip),
		array('title'=>$model->client->remoteip))."</td>";

	echo "<td>{$model->platform}</td>";
	echo "<td>".l(substr($model->lastpage, 0, 30), $model->lastpage)."</td>";

	if(!$model->isguest && !$model->forcelogout)
		echo "<td><a href='javascript:online_logoff($model->id)' title='Force this user to logout'>".
			mainimg('16x16_delete.png')."</a></td>";
	else
		echo "<td></td>";
}

echo "</tbody></table>";





