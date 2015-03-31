<?php

echo '<h2>SANSSpace Admin Panel</h2>';

$adminoptions = getAdminOptions();

$mid1 = 2;
$mid2 = 4;

$i = 0;
echo "<table cellspacing=0 cellpadding=0><tr valign=top><td>";

foreach($adminoptions as $admintitle)
{
	if(isset($admintitle['adminonly']) && !controller()->rbac->globalNetwork()) continue;
		
	echo "<div class='ui-widget-header' style='padding: 5px; margin-bottom: 10px;'>{$admintitle['title']}</div>";
	
	foreach($admintitle['options'] as $option)
	{
		if(isset($option['adminonly']) && !controller()->rbac->globalNetwork()) continue;
		
		echo "<b style='padding-left:5px'>".l($option['name'], $option['url'])."</b><br>";
		echo "<div style='padding:10px'>{$option['description']}</div>";
	}

	$i++;
	if($i == $mid1 || $i == $mid2)
		echo "</td><td width='20px'></td><td valign=top>";
}

echo '</tr></table>';
echo '<br><br><br><br><br>';




