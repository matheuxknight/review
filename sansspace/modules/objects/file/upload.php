<?php

$sessionid = session_id();
$parent = getdbo('Object', $parentid);

Javascript("var upload_url='/upload.php?phpsessid=$sessionid'");
Javascript("var parent_url='/object?id=$parent->id'");

echo CHtml::scriptFile('/sansspace/ui/js/jquery.html5_upload.js');
echo CHtml::scriptFile('/sansspace/ui/js/upload.js');

showNavigationBar($parent->parent);
showObjectHeader($parent);
showObjectMenu($parent);

// if(preg_match('/ie/i', $_SERVER['HTTP_USER_AGENT']))
// {
// 	ShowUploadHeader();
	
// 	echo "<p>Click to select a file on your computer that you want to upload to 
// 			this folder. Then click the Upload button to start uploading.</p>";
	
// 	echo '<div class="miscInput"><span id="spanButtonPlaceholder"></span></div>';
// 	echo '<div class="flash" id="fsUploadProgress"></div><br>';
	
// 	echo CUFHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data'));
// 	showSubmitButton('Upload');
// 	echo CUFHtml::endForm();
// }

// else
{
	echo <<<END

<h2>Upload Files</h2>

<p>Click the button below to select files you want to upload from your computer to this server.</p>

<div style="display: block; width: 160px; height: 40px; overflow: hidden;">
	<button id='button_upload' style="position: relative;">
		<a href="#">Select Files</a></button>

	<input multiple="multiple" type="file" id="upload_field" 
		style="font-size: 40px; width: 120px; opacity: 0; 
		filter:alpha(opacity: 0);  position: relative; top: -40px; left: -20px" />
</div>

<div id="progress_report" style="border: solid 1px #DDF0DD;
		background-color: #EBFFEB; padding: 10px;">
		
	<div id="progress_report_name"></div><br>
			
	<div id="progress_report_bar_container" style="width: 100%; height: 3px;">
		<div id="progress_report_bar" style="background-color: blue; width: 0; height: 100%;"></div>
	</div>
</div>

END;
	
	JavascriptReady("$('#button_upload').button();");
	JavascriptReady("$('#progress_report').hide();");
}


