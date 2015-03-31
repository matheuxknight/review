<?php

showAdminHeader(2);
echo "<h2>Manage Domains</h2>";

showButtonHeader();
showButton('New Domain',array('create'));
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
			var id = ui.item.attr('id').substr(7);
			$(this).children().each(function(i)
			{
				var id2 = $(this).attr('id').substr(7);
				if(id == id2)
					$.get("/domain/setorder&id="+id+"&order="+i);
			});
		}
	}).disableSelection();});
</script>
END;

showTableSorter('maintable', '{headers: {4: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Name</th>";
echo "<th>Enable</th>";
echo "<th>LDAP</th>";
echo "<th>CAS</th>";
//echo "<th>Roster Folder</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($domainList as $model)
{
	echo "<tr id='domain_$model->id'>";
	echo "<td style='font-weight: bold;'>".
		l(h($model->name), array('update', 'id'=>$model->id))."</td>";

	echo "<td>".Booltoa($model->enable)."</td>";
	
	if($model->ldapenable)
		echo "<td>$model->ldapserver</td>";
	else
		echo "<td></td>";

	if($model->casenable)
		echo "<td>$model->casserver</td>";
	else
		echo "<td></td>";

//	echo "<td>$model->extractfolder</td>";
	echo "<td>";
	
	if($model->id != 1)
		echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
			'submit'=>'',
			'params'=>array('command'=>'delete','id'=>$model->id),
			'confirm'=>"Are you sure to delete #{$model->id}?"));
		
	echo "</td>";
	echo "</tr>";
}

echo "</tbody></table>";


// 	else if($model->winenable)
	// 	{
	// 		echo "<td>Windows</td>";
	// 		echo "<td>$model->windomain</td>";
	// 	}

