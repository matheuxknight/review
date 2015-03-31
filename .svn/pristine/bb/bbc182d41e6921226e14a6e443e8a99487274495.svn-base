<?php

showAdminHeader(6);
echo "<h2>Manage Certificates</h2>";

echo 'Changing these parameters requires to '.
l('restart', array('admin/restart')).
' the SANSSpace service to take effect.';

showButtonHeader();
showButton('New Certificate', array('create'));
echo "</div>";
echo "<br>";

showTableSorter('maintable', '{headers: {4: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Common Name</th>";
echo "<th>Organisation</th>";
echo "<th>Created</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($certificateList as $model)
{
	echo "<tr class='ssrow'>";
	
	echo "<td style='font-weight: bold;'>".l($model->commonname, array('update', 'id'=>$model->id))."</td>";
	echo "<td>{$model->organisation}</td>";
	echo "<td>".datetoa($model->created)."</td>";
		
	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
		'submit'=>'',
		'params'=>array('command'=>'delete','id'=>$model->id),
		'confirm'=>"Are you sure to delete #{$model->id}?"));
	echo "</td>";
	echo "</tr>";
}

echo "</tbody></table>";


