<?php

showPmHeader('Draft');

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
	echo "<tr>";	
	echo "<td>{$pm->touser->name}</td>";	
	
	echo "<td>".l($pm->name, array('update', 'id'=>$pm->id))."</td>";
	echo "<td>".datetoa($pm->senttime)."</td>";
	
	echo "<td>".CHtml::linkButton("Delete", array('submit'=>array('delete','id'=>$pm->id),
		'confirm'=>'Are you sure?'))."</td>";	

	echo "</tr>";
}

echo"</table>";

//////////////////////////////////////////////////////

if(!count($pms))
	echo "<br>Your have no message in your Draft section.";

echo "<br><br><br><br><br><br><br><br><br><br>";
showPmFooter();


