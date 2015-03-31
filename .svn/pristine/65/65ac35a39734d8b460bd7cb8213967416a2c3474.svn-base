<?php

showAdminHeader(0);
echo "<h2>Custom Tabs</h2>";

showButtonHeader();
showButton('New Tab Menu', array('create'));
echo "</div>";
echo "<br>";

echo <<<END
<script>
$(function(){
	$('#maintable tbody').sortable(
	{
		delay: 300,
		update: function(event, ui)
		{
			var id = ui.item.attr('id').substr(8);
			$(this).children().each(function(i)
			{
				var id2 = $(this).attr('id').substr(8);
				if(id == id2)
					$.get("/tabmenu/setorder&id="+id+"&order="+i);
			});
		}
	}).disableSelection();});
</script>
END;

showTableSorter('maintable', '{headers: {2: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Menu Name</th>";
echo "<th>Object</th>";
echo "<th>Url</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($tabmenuList as $model)
{
	echo "<tr id='tabmenu_$model->id'>";
	echo "<td style='font-weight: bold;'>".
		l(h($model->name), array('update', 'id'=>$model->id))."</td>";

	echo "<td><b>";
	showObjectMenuContext($model->object);
	echo "</b></td>";

	echo "<td><a href='$model->url'>$model->url</a></td>";
	
	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
		'submit'=>'',
		'params'=>array('command'=>'delete','id'=>$model->id),
		'confirm'=>"Are you sure to delete #{$model->id}?"));
	echo "</td>";
	echo "</tr>";
}

echo "</tbody></table>";



