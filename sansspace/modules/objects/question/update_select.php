<?php

echo CUFHtml::openActiveCtrlHolder($question, 'shuffleanswers');
echo CUFHtml::activeLabelEx($question, 'shuffleanswers');
echo CUFHtml::activeCheckBox($question, 'shuffleanswers');
echo "<p class='formHint2'>...</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($question, 'enumtype');
echo CUFHtml::activeLabelEx($question, 'enumtype');
echo CUFHtml::activeDropDownList($question, 'enumtype', QuizQuestion::model()->enumTypeOptions);
echo "<p class='formHint2'>...</p>";
echo CUFHtml::closeCtrlHolder();

$answers = getdbolist('QuizQuestionSelect', "questionid=$question->id order by id");

echo CUFHtml::openCtrlHolder();
echo "<table class='dataGrid' cellspacing=0 width='100%'><tr>";

echo "<th width=120>Valid (0-100)</th>";
echo "<th>Answer</th>";
//echo "<th>Start</th>";
//echo "<th>Duration</th>";
echo "<th></th>";

echo "</tr>";

if(!count($answers))
	echo "<tr><td colspan=6><i>-none-</i></td></tr>";

else foreach($answers as $answer)
{
	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_valid", $answer->valid);
	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_value", $answer->value);
	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_fileid", $answer->fileid);
	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_startpos", $answer->startpos);
	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_duration", $answer->duration);
	
	$startpos = sectoa($answer->startpos);
	$duration = sectoa($answer->duration);
	$img = $answer->fileid? objectImage($answer->file, 16): '';

	echo "<tr class='ssrow' onclick='load_select_item($answer->id)'>";
	
	echo "<td>$answer->valid</td>";
	echo "<td>$answer->value";
	
	if($answer->fileid && $answer->file->filetype == CMDB_FILETYPE_MEDIA)
		echo "<a href='javascript:multipleChoicesPlayerOrs($answer->id, $answer->fileid, $answer->startpos, $answer->duration)'>$img <b>{$answer->file->name}</b> (at $startpos for $duration)</a>";
	else if($answer->fileid)
		echo "$img <b>{$answer->file->name}</b>";

	echo '</td>';

	echo "<td>";
	echo l(mainimg('16x16_delete.png'), array('deleteselect', 'id'=>$answer->id), array('title'=>'Delete this answer'));
	echo "</td>";
	
	echo "</tr>";
}

$select = new QuizQuestionSelect;
$select->valid = 100;
$select->startpos = 0;
$select->duration = 0;

echo "<tr><td colspan=6><br><b><span id='add_new_message'>add new</span></b></td></tr>";
echo "<tr>";

echo "<td valign=top>".CUFHtml::activeTextField($select, 'valid', array('style'=>'width: 60px;'))."</td>";
echo "<td>".CUFHtml::activeTextField($select, 'value')."</td>";
echo showAttributeEditor($select, 'value', 80, 'custom4');

echo "<td valign=top>";
echo "<span id='mediafilename_select'></span> ";
showObjectBrowserButton($question->bank, 'false', 'true', 'QuizQuestionSelect_fileid', 'select', 'multipleChoiceFileSelectedNew');
echo "</td>";

echo "<td colspan=3></td>";

echo CUFHtml::activeHiddenField($select, 'id');
echo CUFHtml::activeHiddenField($select, 'fileid');
echo CUFHtml::activeHiddenField($select, 'startpos');
echo CUFHtml::activeHiddenField($select, 'duration');
echo CUFHtml::activeHiddenField($question, 'id');

echo "</tr>";
echo "</table>";

echo CUFHtml::closeCtrlHolder();

echo <<<END
<script>

$(function()
{
	$('#QuizQuestionSelect_id').val(0);
	$('#QuizQuestionSelect_value').focus().val('');
});

function load_select_item(id)
{
	$('#QuizQuestionSelect_id').val(id);
	$('#QuizQuestionSelect_valid').val($('#QuizAnswer_'+id+'_valid').val());
	$('#QuizQuestionSelect_fileid').val($('#QuizAnswer_'+id+'_fileid').val());
	$('#QuizQuestionSelect_startpos').val($('#QuizAnswer_'+id+'_startpos').val());
	$('#QuizQuestionSelect_duration').val($('#QuizAnswer_'+id+'_duration').val());
	
	var tmp = $('#QuizAnswer_'+id+'_value').val();
	if(tmp == '') tmp = ' ';
	$('#QuizQuestionSelect_value').elrte('val', tmp);
	
	$('#add_new_message').html('modify');
}

function multipleChoicesPlayerOrs(id, fileid, startpos, duration)
{
	$("#multipleChoice-dialog").dialog(
	{
    	autoOpen: true,
		width: 640, 
		height: 480, 
		modal: true,
		title: 'filename',

		buttons:
		{
			"Save": function()
			{
				startpos = $('#QuizQuestionSelect_startpos').val();
				duration = $('#QuizQuestionSelect_duration').val();
				
				window.location.href = '/question/saveselect?id='+id+'&startpos='+startpos+'&duration='+duration;
			},
			"Cancel": function(){ $(this).dialog("close");}
		}
	});

	$('#objectrangeselectortemplate_select').html("<div id='objectrangeselectorflash_select'></div>");

	var params = {};
	params.allowscriptaccess = "sameDomain";
	params.allowfullscreen = "false";
	params.wmode = "opaque";
	var attributes = {};
	attributes.id = "sansors";
	attributes.name = "sansors";
	attributes.align = "middle";

	var flashvars = "$flashvars"+fileid+
		"&savecallback=multipleChoiceSavePosition"+
		"&startpos="+startpos+"&duration="+duration;

	swfobject.embedSWF(
		"/extensions/players/sansors.swf", "objectrangeselectorflash_select",
		"100%", "360", "11.1.0", "playerProductInstall.swf",
		flashvars, params, attributes);
}

/////////////////////////////////////

function multipleChoiceFileSelectedNew(selectedid, selectedname)
{
	if(!selectedid) return;

	$('#mediafilename_select').html(selectedname);
	$('#QuizQuestionSelect_fileid').val(selectedid);

	document.forms[0].submit();
}

function multipleChoiceSavePosition(startpos, duration)
{
	$('#QuizQuestionSelect_startpos').val(startpos);
	$('#QuizQuestionSelect_duration').val(duration);
}
			
</script>

<div id="multipleChoice-dialog" style='display: none;'>
<div id='objectrangeselectortemplate_select'></div>
</div>


END;






