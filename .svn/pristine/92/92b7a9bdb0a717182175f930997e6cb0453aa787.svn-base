<?php

// echo CUFHtml::openActiveCtrlHolder($survey, 'allowupdate');
// echo CUFHtml::activeLabelEx($survey, 'allowupdate');
// echo CUFHtml::activeCheckBox($survey, 'allowupdate', array('class'=>'miscInput'));
// echo "<p class='formHint2'>...</p>";
// echo CUFHtml::closeCtrlHolder();

if($survey->answertype == CMDB_SURVEYTYPE_SELECT)
{
	echo CUFHtml::openActiveCtrlHolder($survey, 'allowmultiple');
	echo CUFHtml::activeLabelEx($survey, 'allowmultiple');
	echo CUFHtml::activeCheckBox($survey, 'allowmultiple', array('class'=>'miscInput'));
	echo "<p class='formHint2'>...</p>";
	echo CUFHtml::closeCtrlHolder();
}

echo CUFHtml::openActiveCtrlHolder($survey, 'enumtype');
echo CUFHtml::activeLabelEx($survey, 'enumtype');
echo CUFHtml::activeDropDownList($survey, 'enumtype', QuizQuestion::model()->enumTypeOptions);
echo "<p class='formHint2'>...</p>";
echo CUFHtml::closeCtrlHolder();

$options = getdbolist('SurveyOption', "surveyid=$survey->id order by id");

echo CUFHtml::openCtrlHolder();
echo "<table class='dataGrid' cellspacing=0 width='100%'><tr>";

echo "<th>Options</th>";
// echo "<th>File</th>";
// echo "<th>Start</th>";
// echo "<th>End</th>";
echo "<th></th>";

echo "</tr>";

if(!count($options))
	echo "<tr><td colspan=2><i>-none-</i></td></tr>";

else foreach($options as $option)
{
	echo CUFHtml::hiddenField("SurveyOption_{$option->id}_value", $option->value);
	echo CUFHtml::hiddenField("SurveyOption_{$option->id}_fileid", $option->fileid);
	echo CUFHtml::hiddenField("SurveyOption_{$option->id}_startpos", $option->startpos);
	echo CUFHtml::hiddenField("SurveyOption_{$option->id}_duration", $option->duration);
	
	$startpos = sectoa($option->startpos);
	$duration = sectoa($option->duration);
	$img = $option->fileid? objectImage($option->file, 16): '';

	echo "<tr class='ssrow' onclick='load_option_item($option->id)'>";
	echo "<td>$option->value";
	
	if($option->fileid && $option->file->filetype == CMDB_FILETYPE_MEDIA)
		echo "<a href='javascript:surveyPlayerOrs($option->id, $option->fileid, $option->startpos, $option->duration)'>$img <b>{$option->file->name}</b> (at $startpos for $duration)</a>";
	else if($option->fileid)
		echo "$img {$option->file->name}";

	echo '</td>';

	echo "<td>";
	echo l(mainimg('16x16_delete.png'), array('deleteoption', 'id'=>$option->id), array('title'=>'Delete this option'));
	echo "</td>";

	echo "</tr>";
}

$option = new SurveyOption;
$option->startpos = 0;
$option->duration = 0;

echo "<tr><td colspan=6><br><b><span id='add_new_message'>add new</span></b></td></tr>";
echo "<tr>";

echo "<td>".CUFHtml::activeTextField($option, 'value')."</td>";
echo showAttributeEditor($option, 'value', 80, 'custom4');

echo "<td valign=top>";
echo "<span id='mediafilename_option'></span> ";
showObjectBrowserButton($object, 'false', 'true', 'SurveyOption_fileid', 'select', 'surveyFileSelectedNew');
echo "</td>";

echo "<td colspan=3></td>";

echo CUFHtml::activeHiddenField($option, 'id');
echo CUFHtml::activeHiddenField($option, 'fileid');
echo CUFHtml::activeHiddenField($option, 'startpos');
echo CUFHtml::activeHiddenField($option, 'duration');
echo CUFHtml::activeHiddenField($survey, 'id');

echo "</tr>";
echo "</table>";

echo CUFHtml::closeCtrlHolder();

echo <<<END
<script>

$(function()
{
	$('#SurveyOption_id').val(0);
	$('#SurveyOption_value').focus().val('');
});

function load_option_item(id)
{
	$('#SurveyOption_id').val(id);
	$('#SurveyOption_fileid').val($('#SurveyOption_'+id+'_fileid').val());
	$('#SurveyOption_startpos').val($('#SurveyOption_'+id+'_startpos').val());
	$('#SurveyOption_duration').val($('#SurveyOption_'+id+'_duration').val());
	
	var tmp = $('#SurveyOption_'+id+'_value').val();
	if(tmp == '') tmp = ' ';
	$('#SurveyOption_value').elrte('val', tmp);
	
	$('#add_new_message').html('modify');
}

function surveyPlayerOrs(id, fileid, startpos, duration)
{
	$("#survey-dialog").dialog(
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
				startpos = $('#SurveyOption_startpos').val();
				duration = $('#SurveyOption_duration').val();
				
				window.location.href = '/survey/saveoption?id='+id+'&startpos='+startpos+'&duration='+duration;
			},
			"Cancel": function(){ $(this).dialog("close");}
		}
	});

	$('#objectrangeselectortemplate_option').html("<div id='objectrangeselectorflash_option'></div>");

	var params = {};
	params.allowscriptaccess = "sameDomain";
	params.allowfullscreen = "false";
	params.wmode = "opaque";
	var attributes = {};
	attributes.id = "sansors";
	attributes.name = "sansors";
	attributes.align = "middle";

	var flashvars = "$flashvars"+fileid+
		"&savecallback=surveySavePosition"+
		"&startpos="+startpos+"&duration="+duration;

	swfobject.embedSWF(
		"/extensions/players/sansors.swf", "objectrangeselectorflash_option",
		"100%", "360", "11.1.0", "playerProductInstall.swf",
		flashvars, params, attributes);
}

/////////////////////////////////////

function surveyFileSelectedNew(selectedid, selectedname)
{
	if(!selectedid) return;

	$('#mediafilename_option').html(selectedname);
	$('#SurveyOption_fileid').val(selectedid);

	document.forms[0].submit();
}

function surveySavePosition(startpos, duration)
{
	$('#SurveyOption_startpos').val(startpos);
	$('#SurveyOption_duration').val(duration);
}

</script>

<div id="survey-dialog" style='display: none;'>
<div id='objectrangeselectortemplate_option'></div>
</div>

END;




