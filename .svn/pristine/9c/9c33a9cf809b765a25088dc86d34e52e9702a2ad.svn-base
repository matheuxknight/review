<?php

$order = getparam('order');
if($order == '0') $order = 'customername';

$sansspacehosts = getdbolist('Sansspacehost', "sans order by $order");

echo "<table id='maintable' class='dataGrid2'>";
echo "<thead class='ui-widget-header'><tr>";

echo "<th><a style='color: #555;' href='javascript:admin_setorder(\"customername\");'>Name</a></th>";
echo "<th><a style='color: #555;' href='javascript:admin_setorder(\"url\");'>URL</a></th>";
echo "<th><a style='color: #555;' href='javascript:admin_setorder(\"license_used desc\");'>Used</a></th>";
echo "<th><a style='color: #555;' href='javascript:admin_setorder(\"version\");'>Version</a></th>";
echo "<th><a style='color: #555;' href='javascript:admin_setorder(\"lastaccess desc\");'>Last Ping</a></th>";

echo "<th>Details</th>";
echo "<th></th>";

echo "</tr></thead><tbody>";

$totalusers1 = 0;
$totalusers4 = 0;
$totalusers24 = 0;
$totalusers7 = 0;

foreach($sansspacehosts as $host)
{
	echo "<tr class='ssrow'>";
	$name = $host->customername;

	if(!empty($host->sitename) && $host->sitename != 'default')
		$name .= " ($host->sitename)";

	echo "<td><b>".l($name, array('update', 'id'=>$host->id))."</b></td>";

	$urlname = substr($host->url, 0, 24);
	if($urlname != $host->url) $urlname .= '...';

	echo "<td><a href=$host->url target='$name'>$urlname</a></td>";
	echo "<td>$host->license_used</td>";
	echo "<td>$host->version</td>";

	echo "<td>".datetoa($host->lastaccess)."</td>";
	echo "<td>$host->message</td>";

	echo "<td>";
	if(controller()->rbac->globalNetwork())
		echo "<a href='javascript:admin_delete($host->id)'>".mainimg('16x16_delete.png')."</a>";
	
// 		echo CHtml::linkButton(mainimg('16x16_delete.png'), array('title'=>"Delete",
// 			'submit'=>'',
// 			'params'=>array('command'=>'delete', 'id'=>$host->id),
// 			'confirm'=>"Are you sure to delete this host $host->name?"));
	
	echo "</td>";
	echo "</tr>";

	$t = explode('/', $host->message);
	$totalusers1 += intval($t[0]);
	$totalusers4 += intval($t[1]);
	$totalusers24 += intval($t[2]);
	$totalusers7 += intval($t[3]);
}

echo "<td><b>Total ".count($sansspacehosts)." hosts</b></td>";
echo "<td colspan=2></td>";
echo "<td colspan=2>(now / 4 hours / 24 hours / 7 days)</td>";
echo "<td><b>$totalusers1 / $totalusers4 / $totalusers24 / $totalusers7 users</b></td>";
echo "<td></td>";

echo "</tr>";

echo "</tbody></table>";



