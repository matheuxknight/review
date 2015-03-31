<?php

showPmHeader('Inbox');

//////////////////////////////////////////////////////

echo "<table class='dataGrid'>";
echo "<tr>";
echo "<th>".$sort->link('from')."</th>";
//echo "<th>".$sort->link('to')."</th>";
echo "<th>".$sort->link('subject')."</th>";
echo "<th>".$sort->link('sent to')."</th>";
echo "<th></th>";
echo "</tr>";

foreach($pms as $n=>$pm)
{
	if(!$pm->recv) 
		echo "<tr class='bold'>";
	else
		echo "<tr>";
	
	echo "<td>{$pm->author->name}</td>";
//	echo "<td>{$pm->touser->name}</td>";
	
	echo "<td>".l($pm->name, array('show', 'id'=>$pm->id, 'page'=>'Inbox'))."</td>";
	echo "<td>".datetoa($pm->senttime)."</td>";
	
	if(!$pm->togroupid)
		echo "<td>".CHtml::linkButton("Delete", array('submit'=>array('delete','id'=>$pm->id),
			'confirm'=>'Are you sure?'))."</td>";	

	echo "</tr>";
}

echo"</table>";

//////////////////////////////////////////////////////

if(!count($pms))
	echo "<br>Your have no message in your Inbox.";

echo "<br><br><br><br><br><br><br><br><br><br>";
showPmFooter();


