<?php

showPmHeader('Sent');

//////////////////////////////////////////////////////

echo "<table class='dataGrid'>";
echo "<tr>";
echo "<th>".$sort->link('to')."</th>";
echo "<th>".$sort->link('subject')."</th>";
echo "<th>".$sort->link('sent to')."</th>";
echo "<th></th>";
echo "</tr>";

foreach($pms as $n=>$pm)
{
	if($pm->togroupid)
		$toname = $pm->togroup->name;
		
	else
		$toname = $pm->touser->name;
		
	echo "<tr>";
	echo "<td>$toname</td>";	
	
	echo "<td>".l($pm->name, array('show','id'=>$pm->id, 'page'=>'Sent'))."</td>";
	echo "<td>".datetoa($pm->senttime)."</td>";
	
	echo "<td>".CHtml::linkButton("Delete", array('submit'=>array('delete','id'=>$pm->id),
		'confirm'=>'Are you sure?'))."</td>";	

	echo "</tr>";
}

echo"</table>";

//////////////////////////////////////////////////////

if(!count($pms))
	echo "<br>Your have no message in your Sent section.";

echo "<br><br><br><br><br><br><br><br><br><br>";
showPmFooter();


