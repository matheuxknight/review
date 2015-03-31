<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

showButtonHeader();
showButton('New Question', array('create', 'id'=>$object->id));
showButton('Quiz Parameters', array('parameters', 'id'=>$object->id));
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
			var id = ui.item.attr('id').substr(9);
			$(this).children().each(function(i)
			{
				var id2 = $(this).attr('id').substr(9);
				if(id == id2)
				{
					$.ajax("/quiz/setorder&id="+id+"&order="+i);
					window.location = "/quiz/editor?id=$object->id";
				}
			});
		}
	}).disableSelection();});
</script>
END;

showTableSorter('maintable', '{headers: {4: {sorter: false}}}');

echo "<thead class='ui-widget-header'><tr>";
echo "<th width=60>Number</th>";
echo "<th>Question</th>";
echo "<th>Media</th>";
echo "<th>Type</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($questionList as $n=>$model)
{
	echo "<tr id='question_$model->id'>";
	$url = array('update', 'id'=>$model->id);

	echo "<td>".l($model->number, $url)."</td>";	
	echo "<td>".l(getTextTeaser($model->question), $url)."</td>";
	
	if($model->file)
		echo "<td>".l($model->file->name, array('file/show', 'id'=>$model->file->id))."</td>";
	
	else
		echo "<td></td>";
	
	echo "<td>$model->answerTypeText</td>";

	echo "<td>";
	echo CHtml::linkButton('Delete',array(
		'submit'=>'',
		'params'=>array('command'=>'delete','id'=>$model->id),
		'confirm'=>"Are you sure to delete #{$model->id}?"));
	echo "</td>";
	
	echo "</tr>";
}

echo "</tbody></table>";
echo "<br/>";






