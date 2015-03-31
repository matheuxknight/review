<?php

$connect = getPlayerConnect();
$flashvars =
	"&headercolor=".preg_replace('/#/', '0x', param('appheadercolor')).
	"&headerback=".preg_replace('/#/', '0x', param('appheaderback')).
	"&maincolor=".preg_replace('/#/', '0x', param('appmaincolor')).
	"&mainback=".preg_replace('/#/', '0x', param('appmainback')).
	"&mainalpha=".preg_replace('/#/', '0x', param('appmainalpha')).
	"&slidercolor=".preg_replace('/#/', '0x', param('appslidercolor')).
	"&phpsessid=".session_id().
	"&autosave=".param('appautosave').
	"&servername=".$_SERVER['HTTP_HOST'].
	"&connect=".getPlayerConnect().
	"&connectrtmpt=".getPlayerConnectRtmpt().
	"&connecthttp=".getFullServerName()."&id=";

echo CUFHtml::openActiveCtrlHolder($question, 'fileid');
echo CUFHtml::activeLabelEx($question, 'fileid');
echo CUFHtml::activeHiddenField($question, 'fileid');

$filename = $question->file? $question->file->name: '&nbsp;';
echo "<div id='mediafilename' class='textInput sans-input'>$filename</div>";

showObjectBrowserButton($question->bank, 'false', 'true', 'QuizQuestion_fileid', 'media', 'quizFileSelected');
echo "<p class='formHint2'>Optionally, select a media or an image file to show with this question.</p>";

if($question->fileid)
	echo '<br>'.CHtml::linkButton('[Reset]',
		array('submit'=>array('question/resetfile', 'id'=>$question->id),
			'confirm'=>'Are you sure you want to reset the file for this question?'));

echo CUFHtml::closeCtrlHolder();

////////////////////////////////////////////////////////////

echo CUFHtml::activeHiddenField($question, 'startpos');
echo CUFHtml::activeHiddenField($question, 'duration');

echo "<div id='objectrangeselectortemplate'></div>";
echo "<script>";

if($question->file)
{
	echo "$(function() {";
	switch($question->file->filetype)
	{
		case CMDB_FILETYPE_MEDIA:
	 		echo "showOsrPlayer();";
			break;
			
		case CMDB_FILETYPE_IMAGE:
		 	$imagename = fileUrl($question->file);
			echo "$('#objectrangeselectortemplate').html('<img src=\"$imagename\" />');";
			break;
	}

	echo "});";
}

echo <<<END

function quizFileSelected(selectedid, selectedname)
{
	if(!selectedid) return;
	$('#mediafilename').html(selectedname);

	$('#QuizQuestion_startpos').val(0);
	$('#QuizQuestion_duration').val(0);

	document.forms[0].submit();
};

function showOsrPlayer()
{
	$('#objectrangeselectortemplate').html("<div id='objectrangeselectorflash'></div>");
	var id = $('#QuizQuestion_fileid').val();

	var params = {};
	params.allowscriptaccess = "sameDomain";
	params.allowfullscreen = "false";
	params.wmode = "opaque";
	var attributes = {};
	attributes.id = "sansors";
	attributes.name = "sansors";
	attributes.align = "middle";

	var flashvars = "$flashvars"+id+
		"&savecallback=saveRangePosition"+
		"&startpos="+$('#QuizQuestion_startpos').val()+
		"&duration="+$('#QuizQuestion_duration').val();

	swfobject.embedSWF(
		"/extensions/players/sansors.swf", "objectrangeselectorflash",
		"480", "200", "11.1.0", "playerProductInstall.swf",
		flashvars, params, attributes);
}

function saveRangePosition(startpos, duration)
{
	$('#QuizQuestion_startpos').val(startpos);
	$('#QuizQuestion_duration').val(duration);
}

function setFlashMovieHeight(height)
{
	$('#sansors').height(height);
}

</script>
END;



