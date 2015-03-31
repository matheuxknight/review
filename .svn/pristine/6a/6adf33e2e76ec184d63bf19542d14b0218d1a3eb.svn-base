<?php
echo "<h2>Manage Servers</h2>";

showTableSorter('maintable');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Title</th>";
echo "<th>Version</th>";
echo "<th>Last Access</th>";
echo "<th>Relayed</th>";
echo "<th>Server DNS</th>";
echo "<th>Server IP</th>";
echo "</tr></thead><tbody>";

foreach($serverList as $model)
{
	echo "<tr class='ssrow'>";
	
	if(empty($model->title))
		$model->title = '(none)';
		
	echo "<td style='font-weight: bold;'>".
		l($model->title, array('update', 'id'=>$model->id))."</td>";
	echo "<td>$model->version</td>";
	echo "<td nowrap>".datetoa($model->lastaccess)."</td>";
	
	if($model->relayed)
	{
		$linkname = "http://{$model->title}.relay.sansspace.com";
		echo "<td>".l($linkname, $linkname, array('target'=>'_blank'))."</td>";
	}
	else echo "<td></td>";

	if(!empty($model->remotename))
	{
		if($model->porthttp == 80)
			$linkname = "http://$model->remotename";
		else
			$linkname = "http://$model->remotename:$model->porthttp";
		
		echo "<td>".l($linkname, $linkname, array('target'=>'_blank'))."</td>";
	}
	else echo "<td></td>";
			
	if(!empty($model->remoteip))
	{
		if($model->porthttp == 80)
			$linkname = "http://$model->remoteip";
		else
			$linkname = "http://$model->remoteip:$model->porthttp";
		
		echo "<td>".l($linkname, $linkname, array('target'=>'_blank'))."</td>";
	}
	else echo "<td></td>";
			
	echo "</tr>";
}

echo "</tbody></table>";





