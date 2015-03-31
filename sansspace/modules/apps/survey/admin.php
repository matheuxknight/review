<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

$list = getdbolist('Survey', "objectid=$object->id order by displayorder");

showTableSorter('maintable', '{headers: {4: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";

echo "<th>ID</th>";
echo "<th>Question</th>";
echo "<th>Type</th>";
echo "<th>Options</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($list as $n=>$model)
{
	$url = array('update', 'id'=>$model->id);
	$name = getTextTeaser($model->question, 60);
	$options = $model->answertype == CMDB_SURVEYTYPE_SELECT || $model->answertype == CMDB_SURVEYTYPE_RANK? 
		getdbocount('SurveyOption', "surveyid=$model->id"): '';

	echo "<tr id='survey_$model->id' class='ssrow'>";
	echo "<td><b>".l($model->id, $url)."</b></td>";
	echo "<td><b>".l($name, $url)."</b></td>";
	echo "<td>$model->answerTypeText</td>";
	echo "<td>$options</td>";
	
	echo "<td><a href='javascript:delete_survey($model->id)' title='Delete this survey'>".
		mainimg('16x16_delete.png')."</a></td>";
	
	echo "</tr>";
}

echo "</tbody></table>";
echo "<br/>";

echo <<<end
<script>

$(function()
{
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
				{
				//	$.ajax("/quiz/setorder&id="+id+"&order="+i);
					window.location = "/survey/setorder?id=" + id + "&order=" + i;
				}
			});
		}
	}).disableSelection();
});
		
function delete_survey(id)
{
	if(confirm('Are you sure you want to delete this survey?'))
		window.location.href='/survey/delete?id='+id;
}

</script>
end;






