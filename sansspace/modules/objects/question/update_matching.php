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

echo CUFHtml::openActiveCtrlHolder($question, 'enumtype2');
echo CUFHtml::activeLabelEx($question, 'enumtype2');
echo CUFHtml::activeDropDownList($question, 'enumtype2', QuizQuestion::model()->enumTypeOptions);
echo "<p class='formHint2'>...</p>";
echo CUFHtml::closeCtrlHolder();

$answers = getdbolist('QuizQuestionMatching', "questionid=$question->id");

echo CUFHtml::openCtrlHolder();
echo "<table class='dataGrid' cellspacing=0 width='100%'><tr>";

echo "<th width=120>Valid (0-100)</th>";
echo "<th>Answer1</th>";
echo "<th>Answer2</th>";
// echo "<th>File</th>";
// echo "<th width=50>Start</th>";
// echo "<th width=50>End</th>";

echo "<th></th>";
echo "</tr>";

if(!count($answers))
	echo "<tr><td colspan=6><i>-none-</i></td></tr>";

else foreach($answers as $answer)
{
 	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_valid", $answer->valid);
 	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_value1", $answer->value1);
 	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_fileid1", $answer->fileid1);
 	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_startpos1", $answer->startpos1);
 	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_duration1", $answer->duration1);
 	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_value2", $answer->value2);
 	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_fileid2", $answer->fileid2);
 	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_startpos2", $answer->startpos2);
 	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_duration2", $answer->duration2);
 	
	$startpos1 = sectoa($answer->startpos1);
	$duration1 = sectoa($answer->duration1);
	
	$startpos2 = sectoa($answer->startpos2);
	$duration2 = sectoa($answer->duration2);
	
	$img1 = $answer->fileid1? objectImage($answer->file1, 16): '';
	$img2 = $answer->fileid2? objectImage($answer->file2, 16): '';
	
	echo "<tr class='ssrow' onclick='load_matching_item($answer->id)'>";
		
 	echo "<td>$answer->valid</td>";

 	/////////////////////////////////////////////////////
 	
	echo "<td>$answer->value1";
	
	if($answer->file1 && $answer->file1->filetype == CMDB_FILETYPE_MEDIA)
		echo "<a href='javascript:matchingOsrPlayer(1, $answer->id, $answer->fileid1, $answer->startpos1, $answer->duration1)'>
			<b>$img1 {$answer->file1->name}<b> (at $startpos1 for $duration1)</a>";
	
	else if($answer->file1)
		echo "$img1 <b>{$answer->file1->name}</b>";
	
	echo "</td>";
	
 	/////////////////////////////////////////////////////
 	
	echo "<td>$answer->value2";
	
	if($answer->file2 && $answer->file2->filetype == CMDB_FILETYPE_MEDIA)
		echo "<a href='javascript:matchingOsrPlayer(2, $answer->id, $answer->fileid2, $answer->startpos2, $answer->duration2)'>
			<b>$img2 {$answer->file2->name}<b> (at $startpos2 for $duration2)</a>";
	
	else if($answer->file2)
		echo "$img2 <b>{$answer->file2->name}</b>";
	
	echo "</td>";
	
 	/////////////////////////////////////////////////////
 	
	echo "<td>";
	echo l(mainimg('16x16_delete.png'), array('deletematching', 'id'=>$answer->id), array('title'=>'Delete this answer'));
	echo "</td>";
	
	echo "</tr>";
}

$matching = new QuizQuestionMatching;
$matching->valid = 100;
$matching->startpos1 = 0;
$matching->duration1 = 0;
$matching->startpos2 = 0;
$matching->duration2 = 0;

echo "<tr><td colspan=6><br><b><span id='add_new_message'>add new</span></b></td></tr>";
echo "<tr>";

echo "<td valign=top>".CUFHtml::activeTextField($matching, 'valid', array('style'=>'width: 100px;'))."</td>";

echo "<td>".CUFHtml::activeTextField($matching, 'value1')."</td>";
echo showAttributeEditor($matching, 'value1', 80, 'custom4');

echo "<td>".CUFHtml::activeTextField($matching, 'value2')."</td>";
echo showAttributeEditor($matching, 'value2', 80, 'custom4');

echo "<td valign=top>";

showObjectBrowserButton($question->bank, 'false', 'true', 'QuizQuestionMatching_fileid1', 'matching1', 'matchingFileSelectedNew1');
echo " <span id='mediafilename_matching1'></span><br>";

showObjectBrowserButton($question->bank, 'false', 'true', 'QuizQuestionMatching_fileid2', 'matching2', 'matchingFileSelectedNew2');
echo " <span id='mediafilename_matching2'></span>";

echo "</td>";

echo "<td colspan=3></td>";

echo CUFHtml::activeHiddenField($matching, 'id');

echo CUFHtml::activeHiddenField($matching, 'startpos1');
echo CUFHtml::activeHiddenField($matching, 'duration1');
echo CUFHtml::activeHiddenField($matching, 'fileid1');

echo CUFHtml::activeHiddenField($matching, 'startpos2');
echo CUFHtml::activeHiddenField($matching, 'duration2');
echo CUFHtml::activeHiddenField($matching, 'fileid2');

echo CUFHtml::activeHiddenField($question, 'id');

echo "</tr>";
echo "</table>";

echo CUFHtml::closeCtrlHolder();

echo <<<END
<script>

$(function()
{
	$('#QuizQuestionMatching_id').val(0);

	$('#QuizQuestionMatching_value1').focus().val('');
	$('#QuizQuestionMatching_value2').val('');
	
	$('#QuizQuestionMatching_startpos1').val('');
	$('#QuizQuestionMatching_startpos1').val('');
	
	$('#QuizQuestionMatching_duration1').val('');
	$('#QuizQuestionMatching_duration2').val('');
});

function load_matching_item(id)
{
	$('#QuizQuestionMatching_id').val(id);
	
	$('#QuizQuestionMatching_valid').val($('#QuizAnswer_'+id+'_valid').val());
	$('#QuizQuestionMatching_fileid1').val($('#QuizAnswer_'+id+'_fileid1').val());
	$('#QuizQuestionMatching_startpos1').val($('#QuizAnswer_'+id+'_startpos1').val());
	$('#QuizQuestionMatching_duration1').val($('#QuizAnswer_'+id+'_duration1').val());
	$('#QuizQuestionMatching_fileid2').val($('#QuizAnswer_'+id+'_fileid2').val());
	$('#QuizQuestionMatching_startpos2').val($('#QuizAnswer_'+id+'_startpos2').val());
	$('#QuizQuestionMatching_duration2').val($('#QuizAnswer_'+id+'_duration2').val());
	
	var tmp = $('#QuizAnswer_'+id+'_value1').val();
	if(tmp == '') tmp = ' ';
	$('#QuizQuestionMatching_value1').elrte('val', tmp);
	
	var tmp = $('#QuizAnswer_'+id+'_value2').val();
	if(tmp == '') tmp = ' ';
	$('#QuizQuestionMatching_value2').elrte('val', tmp);
	
	$('#add_new_message').html('modify');
}

function matchingOsrPlayer(index, id, fileid, startpos, duration)
{
	$('#QuizQuestionMatching_startpos'+index).val(startpos);
	$('#QuizQuestionMatching_duration'+index).val(duration);

	$("#matching-dialog").dialog(
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
				startpos = $('#QuizQuestionMatching_startpos'+index).val();
				duration = $('#QuizQuestionMatching_duration'+index).val();
				
				window.location.href = '/question/savematching?id='+id+'&index='+index+'&startpos='+startpos+'&duration='+duration;
			},

			"Cancel": function(){ $(this).dialog("close");}
		}
	});

	$('#objectrangeselectortemplate_matching').html("<div id='objectrangeselectorflash_matching"+index+"'></div>");

	var params = {};
	params.allowscriptaccess = "sameDomain";
	params.allowfullscreen = "false";
	params.wmode = "opaque";
	var attributes = {};
	attributes.id = "sansors";
	attributes.name = "sansors";
	attributes.align = "middle";

	var flashvars = "$flashvars"+fileid+
		"&savecallback=matchingSavePosition"+index+
		"&startpos="+startpos+"&duration="+duration;

	swfobject.embedSWF(
		"/extensions/players/sansors.swf", "objectrangeselectorflash_matching"+index,
		"100%", "380", "11.1.0", "playerProductInstall.swf",
		flashvars, params, attributes);
}

////////////////////////////////////////////////////////////////////////

function matchingFileSelectedNew1(selectedid, selectedname)
{
	if(!selectedid) return;

	$('#mediafilename_matching1').html(selectedname);
	$('#QuizQuestionMatching_fileid1').val(selectedid);
		
	matchingOsrPlayerNew(1);
}

function matchingFileSelectedNew2(selectedid, selectedname)
{
	if(!selectedid) return;

	$('#mediafilename_matching2').html(selectedname);
	$('#QuizQuestionMatching_fileid2').val(selectedid);
		
	matchingOsrPlayerNew(2);
}

function matchingOsrPlayerNew(index)
{
	var filename = $('#mediafilename_matching'+index).html();
	$("#matching-dialog").dialog(
	{
    	autoOpen: true,
		width: 640, 
		height: 480, 
		modal: true,
		title: filename,

		buttons:
		{
			"Ok": function() { $(this).dialog("close");},
		}
	});
		
	$('#objectrangeselectortemplate_matching').html("<div id='objectrangeselectorflash_matching"+index+"'></div>");
	var fileid = $('#QuizQuestionMatching_fileid'+index).val();

	var params = {};
	params.allowscriptaccess = "sameDomain";
	params.allowfullscreen = "false";
	params.wmode = "opaque";
	var attributes = {};
	attributes.id = "sansors";
	attributes.name = "sansors";
	attributes.align = "middle";

	var flashvars = "$flashvars"+fileid+
		"&savecallback=matchingSavePosition"+index+
		"&startpos="+$('#QuizQuestionMatching_startpos'+index).val()+
		"&duration="+$('#QuizQuestionMatching_duration'+index).val();

	swfobject.embedSWF(
		"/extensions/players/sansors.swf", "objectrangeselectorflash_matching"+index,
		"100%", "380", "11.1.0", "playerProductInstall.swf",
		flashvars, params, attributes);
}

function matchingSavePosition1(startpos, duration)
{
	$('#QuizQuestionMatching_startpos1').val(startpos);
	$('#QuizQuestionMatching_duration1').val(duration);
}

function matchingSavePosition2(startpos, duration)
{
	$('#QuizQuestionMatching_startpos2').val(startpos);
	$('#QuizQuestionMatching_duration2').val(duration);
}

</script>

<div id="matching-dialog" style='display: none;'>
<div id='objectrangeselectortemplate_matching'></div>
</div>

END;




