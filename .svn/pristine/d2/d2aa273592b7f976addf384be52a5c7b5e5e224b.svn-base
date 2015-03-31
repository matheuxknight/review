<?php

function showListDetails($id, $objects)
{
	$hasupdateaccess = controller()->rbac->globalAdmin();
	if(intval($id) && !(isset($_GET['recursive']) && $_GET['recursive'] == 'true'))
	{
		$object = getdbo('Object', $id);
		if(controller()->rbac->objectAction($object, 'update'))
		{
			$hasupdateaccess = true;
			echo <<<END
<script>
$(function(){
	$('#maintable tbody').sortable(
	{
		delay: 300,
		update: function(event, ui)
		{
			var id = ui.item.attr('id').substr(14);
			$(this).children().each(function(i)
			{
				var id2 = $(this).attr('id').substr(14);
				if(id == id2)
					$.get("/object/setorder&id="+id+"&order="+i);
			});
		}
	}).disableSelection();});
</script>
END;
		}
	}

	echo CUFHtml::beginForm($_SERVER['HTTP_REFERER']);
	showTableSorter('maintable', '{headers: {0: {sorter: false}, 1: {sorter: false}}}');

	echo "<thead class='ui-widget-header'><tr>";
	echo '<th></th>';
	echo '<th></th>';
	echo '<th width="40%">Name</th>';
	echo '<th>Type</th>';
	echo '<th>Author</th>';
	echo '<th>Updated</th>';
	echo '<th>Views</th>';
	echo '<th>Size</th>';
	echo '<th>Duration</th>';
	echo "</tr></thead><tbody>";

	foreach($objects as $n=>$object)
		showObjectItemDetails($object, $hasupdateaccess);

	echo "</tbody></table>";

	if($hasupdateaccess)
		showDropdownCommand();

	echo CUFHtml::endForm();
}

function showObjectItemDetails($object, $hasupdateaccess)
{
	echo "<tr id='object_parent_{$object->id}' class='ssrow'>";
	if($hasupdateaccess)
	{
		echo '<td> ';
		echo CHtml::checkBox("all_objects[{$object->id}]", false,
			array('class'=>'all_objects_select'));
		echo '</td>';
	}
	else
		echo '<td></td>';

	echo '<td width=24>'.l(objectImage($object, 22), objectUrl($object)).'</td>';

	echo "<td style='font-weight: bold;'>";
	showObjectMenuContext($object);
	echo '</td>';

	if($object->type == CMDB_OBJECTTYPE_FILE && $object->file)
	{
		if($object->file->filetype == CMDB_FILETYPE_MEDIA)
		{
			echo '<td>';
			if($object->file->hasaudio && $object->file->hasvideo) echo 'Audio/Video';
			else if($object->file->hasaudio) echo 'Audio';
			else if($object->file->hasvideo) echo 'Video';
			echo '</td>';
		}

		else if($object->file->filetype != CMDB_FILETYPE_UNKNOWN)
			echo '<td>'.$object->file->fileTypeText.'</td>';

		else echo '<td></td>';
	}
	
	else if($object->type == CMDB_OBJECTTYPE_COURSE) echo '<td>Course</td>';
	else if($object->type == CMDB_OBJECTTYPE_QUIZ) echo '<td>Quiz</td>';
	else if($object->type == CMDB_OBJECTTYPE_LESSON) echo '<td>Lesson</td>';
	else if($object->type == CMDB_OBJECTTYPE_SURVEY) echo '<td>Survey</td>';
	else if($object->type == CMDB_OBJECTTYPE_TEXTBOOK) echo '<td>Textbook</td>';
	else if($object->type == CMDB_OBJECTTYPE_FLASHCARD) echo '<td>Flashcards</td>';
	else if($object->type == CMDB_OBJECTTYPE_LINK) echo '<td>Link</td>';
	else if($object->post) echo '<td>Post</td>';
	else echo '<td>Folder</td>';

	echo "<td>{$object->author->name}</td>";
	echo "<td nowrap>".datetoa($object->updated)."</td>";
	echo "<td>{$object->ext->views}</td>";

	if($object->size)
		echo '<td>'.Itoa($object->size).'</td>';
	else
		echo '<td></td>';

	if($object->duration)
		echo '<td>'.objectDuration2a($object).'</td>';
	else
		echo '<td></td>';

	echo "</tr>";
}

