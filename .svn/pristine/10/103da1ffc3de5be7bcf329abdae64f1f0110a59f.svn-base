<?php

echo "<h2>Server Logs</h2>";
echo '<br>';

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Access</a></li>";
echo "<li><a href='#tabs-2'>Error</a></li>";
echo "<li><a href='#tabs-3'>Info</a></li>";
echo "<li><a href='#tabs-4'>PHP</a></li>";
echo "<li><a href='#tabs-5'>Logon</a></li>";
echo "<li><a href='#tabs-6'>Security</a></li>";
echo "</ul><br>";

ShowLogSection('tabs-1', 'access');
ShowLogSection('tabs-2', 'error');
ShowLogSection('tabs-3', 'info');
ShowLogSection('tabs-4', 'php');
ShowLogSection('tabs-5', 'logon');
ShowLogSection('tabs-6', 'security');

function ShowLogSection($tabname, $pattern)
{
	$img = '<img width=16  src="'.iconurl('text.png').'" >';

	echo "<div id='$tabname'>";
	showTableSorter("maintable-$tabname", 
		'{headers: {0: {sorter: false}, 4: {sorter: false}}}');
	
	echo "<thead class='ui-widget-header'><tr>";
	echo "<th></th>";
	echo "<th>Filename</th>";
	echo "<th>Size</th>";
	echo "<th>Date</th>";
	echo "<th></th>";
	echo "</tr></thead><tbody>";
	
	$folders = glob(SANSSPACE_LOGS."/$pattern*.log");
	foreach($folders as $f)
	{
		$pi = pathinfo($f);
		$size = Itoa(dos_filesize($f));
		$date = date("Y F d H:i:s", filemtime($f));	
		
		echo "<tr class='ssrow'>";
		echo "<td width=24>$img</td>";
		echo "<td><b>";
		echo l($pi['filename'], array('admin/showlog', 
			'filename'=>$pi['basename']), array('target'=>'_'));
		echo "</b></td>";
		echo "<td>$size</td>";
		echo "<td>$date</td>";

		echo "<td>";
		echo l(mainimg('16x16_delete.png'), 
			array('deletelog', 'deletename'=>$pi['basename']));
		
		echo "</td>";
	
		echo "</tr>";
	}
	
	echo "</tbody></table>";
	echo "</div>";
}



