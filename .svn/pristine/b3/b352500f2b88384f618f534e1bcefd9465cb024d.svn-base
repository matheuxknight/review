<?php

showAdminHeader(3);
echo "<h2>Manage Categories</h2>";

showButtonHeader();
showButton('New Category', array('create'));
echo "</div>";
echo "<br>";

showTableSorter('maintable', '{headers: {1: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Name</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($categoryList as $n=>$model)
{
	echo "<tr class='ssrow'>";
	echo "<td style='font-weight: bold;'>".
		l($model->name, array('update', 'id'=>$model->id))."</td>";

	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
		'submit'=>'',
		'params'=>array('command'=>'delete','id'=>$model->id),
		'confirm'=>"Are you sure you want to delete {$model->name}?"));
	echo "</td>";
	echo "</tr>";
}

echo "</tbody></table>";


