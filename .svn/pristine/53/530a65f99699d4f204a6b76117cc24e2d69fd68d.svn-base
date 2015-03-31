<?php

showAdminHeader(4);
echo "<h2>Manage Cron Jobs</h2>";

showButtonHeader();
showButton('New Job', array('create'));
showButton('Deleted User List', array('../cronjobs/DeletedUsers/DeletedUsers.csv'));
showButton('Deleted Course List', array('../cronjobs/DeletedCourses/DeletedCourses.csv')); 
showButton('Full User Information', array('fulluserinfocsv'));
showButton('Full Course Information', array('fullcourseinfocsv'));
showButton('Teacher Email List', array('teacheremailcsv'));
echo "</div>";
echo "<br>";

showTableSorter('maintable', '{headers: {4: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Name</th>";
echo "<th>Time</th>";
echo "<th>Enabled</th>";
echo "<th>Last Run</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($cronjobList as $n=>$model)
{
	echo "<tr class='ssrow'>";
	echo "<td style='font-weight: bold;'>".
			l(h($model->name), array('update', 'id'=>$model->id))."</td>";
	echo "<td>$model->crontime</td>";
	echo "<td>".Booltoa($model->enable)."</td>";
	echo "<td>".datetoa($model->lastrun)."</td>";
	echo "<td>";

	echo CHtml::linkButton('Run',array(
			'submit'=>'',
			'params'=>array('command'=>'runnow', 'id'=>$model->id),
			'confirm'=>"Are you sure you want to run this job now?")).' ';

	echo CHtml::linkButton('Delete',array(
			'submit'=>'',
			'params'=>array('command'=>'delete','id'=>$model->id),
			'confirm'=>"Are you sure you want to delete item #{$model->id}?")).' ';

	echo "</td>";
	echo "</tr>";
}

echo "</tbody></table>";

Javascript("setTimeout('window.location=document.URL;', 120000);");


