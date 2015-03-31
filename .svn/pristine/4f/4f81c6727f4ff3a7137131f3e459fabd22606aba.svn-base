<?php

showAdminHeader(3);
echo "<h2>Manage Folder Imports</h2>";

showButtonHeader();
showButton('New Import Folder', array('create'));
echo "</div>";
echo "<br>";

showTableSorter('maintable', '{headers: {4: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Name</th>";
echo "<th>Pathname</th>";
echo "<th>Auto Scan</th>";
echo "<th>Auto Transcode</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($folderImportList as $model)
{
	echo "<tr class='ssrow'>";
	echo "<td style='font-weight: bold;'>".
		l(h($model->name), array('update', 'id'=>$model->id))."</td>";
	echo "<td>$model->pathname</td>";
	echo "<td>".Booltoa($model->autoscan)."</td>";
	echo "<td>".Booltoa($model->autotranscode)."</td>";
	
	echo "<td>";
	echo CHtml::linkButton('[Delete]',array(
		'submit'=>'',
		'params'=>array('command'=>'delete','id'=>$model->id),
		'confirm'=>"Are you sure to delete #{$model->id}?"));
	
	echo ' '.l('[Edit Object]', 
		array('object/update', 'id'=>$model->objectid));

	echo ' '.l('[Rescan Now]', 
		array('object/rescan', 'id'=>$model->objectid));
		
	echo "</td>";
	echo "</tr>";
}

echo "</tbody></table>";


