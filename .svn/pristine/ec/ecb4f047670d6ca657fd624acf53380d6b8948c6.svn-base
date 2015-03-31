<?php

showAdminHeader(0);
echo"<h2>Manage Semesters</h2>";

showButtonHeader();
showButton('Templates',array('semestertemplate/'));
showButton('New Semester',array('create'));
echo "</div>";
echo "<br>";

showTableSorter('maintable', '{headers: {3: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Name</th>";
echo "<th>Start Time</th>";
echo "<th>End Time</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

$semester = getCurrentSemester();

foreach($semesterList as $n=>$model)
{
	echo "<tr class='ssrow'>";
	echo "<td style='font-weight: bold;'>".
		l($model->name, array('update','id'=>$model->id));
	
	if($semester->id == $model->id)
		echo " (CURRENT)";
		
	echo "</td>";
	echo "<td>{$model->starttime}</td>";
	echo "<td>{$model->endtime}</td>";
	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
		'submit'=>'',
		'params'=>array('command'=>'delete', 'id'=>$model->id),
		'confirm'=>"Are you sure to delete {$model->name}?"));
	echo "</td>";
	echo "</tr>";
}

echo "</tbody></table>";



