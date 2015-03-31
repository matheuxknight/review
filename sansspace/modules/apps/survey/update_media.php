<?php

echo CUFHtml::openActiveCtrlHolder($survey, 'fileid');
echo CUFHtml::activeLabelEx($survey, 'fileid');
echo CUFHtml::activeHiddenField($survey, 'fileid');

$filename = $survey->file? $survey->file->name: '&nbsp;';
echo "<div id='mediafilename' class='textInput sans-input'>$filename</div>";

showObjectBrowserButton($object, 'false', 'true', 'Survey_fileid', 'media', 'surveyFileSelected');
echo "<p class='formHint2'>Optionally, select a media or an image file to show with this survey.</p>";

if($survey->fileid)
	echo '<br>'.CHtml::linkButton('[Reset]',
		array('submit'=>array('survey/resetfile', 'id'=>$survey->id),
			'confirm'=>'Are you sure you want to reset the file for this survey?'));

echo CUFHtml::closeCtrlHolder();

echo CUFHtml::activeHiddenField($survey, 'startpos');
echo CUFHtml::activeHiddenField($survey, 'duration');

echo "<div id='objectrangeselectortemplate'></div>";

echo "<script>";

if($survey->file)
{
	echo "$(function() {";
	switch($survey->file->filetype)
	{
		case CMDB_FILETYPE_MEDIA:
			echo "showOsrPlayer();";
			break;

		case CMDB_FILETYPE_IMAGE:
			$imagename = fileUrl($survey->file);
			echo "$('#objectrangeselectortemplate').html('<img src=\"$imagename\" />');";
			break;
	}

	echo "});";
}

///////////////////////////////////////////////////////////////////////////////

echo <<<END

function surveyFileSelected(selectedid, selectedname)
{
	if(!selectedid) return;
	$('#mediafilename').html(selectedname);

	$('#Survey_startpos').val(0);
	$('#Survey_duration').val(0);

	document.forms[0].submit();
};

function showOsrPlayer()
{
	$('#objectrangeselectortemplate').html("<div id='objectrangeselectorflash'></div>");
	var id = $('#Survey_fileid').val();

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
		"&startpos="+$('#Survey_startpos').val()+
		"&duration="+$('#Survey_duration').val();

	swfobject.embedSWF(
		"/extensions/players/sansors.swf", "objectrangeselectorflash",
		"480", "200", "11.1.0", "playerProductInstall.swf",
		flashvars, params, attributes);
}

function saveRangePosition(startpos, duration)
{
	$('#Survey_startpos').val(startpos);
	$('#Survey_duration').val(duration);
}

function setFlashMovieHeight(height)
{
	$('#sansors').height(height);
}

</script>
END;






