<?php

echo "<h2>Available Recordings to Recover</h2>";

echo "<br>";
echo "<table class='dataGrid'>";

echo "<tr>";
echo "<th>Name</th>";
echo "<th>Date</th>";
echo "<th>Size</th>";
echo "<th>Computer</th>";
echo "<th></th>";
echo "</tr>";

foreach($data as $model)
{
	echo "<tr class='ssrow'>";
	
	if($model['user'])
		echo "<td>".CHtml::encode($model['user']->name)." (".CHtml::encode($model['user']->logon).")</td>";
	else
		echo "<td>Unknown User</td>";
		
	echo "<td>".date("F d Y H:i:s", $model['date'])."</td>";
	echo "<td>".CHtml::encode(itoa($model['size']))."</td>";
	echo "<td>".CHtml::encode($model['session']->client->remotename)."</td>";
	echo "<td>".l('Recover', array('', 'file'=>base64_encode($model['file'])))."</td>";
	echo "</tr>";
}

echo "</table>";
echo "<br/>";



