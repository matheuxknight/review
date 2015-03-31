<?php

function fileShowCreateProperties($file)
{
	echo "<div id='properties-file'>";
	
	ShowUploadHeader(true);
	JavascriptReady("$('.ctrlHolder a').button();");
	
	echo CUFHtml::openActiveCtrlHolder($file, 'temp_pathname');
	echo CUFHtml::activeLabelEx($file, 'temp_pathname');
	echo '<div class="miscInput"><span id="spanButtonPlaceholder"></span></div>';
	echo "<p class='formHint2'>Click to select a file on your computer that you 
		want to upload to this folder.</p>";
	echo CUFHtml::closeCtrlHolder();

	echo '<div class="flash" id="fsUploadProgress"></div>';

	echo CUFHtml::openActiveCtrlHolder($file, 'record');
	echo CUFHtml::activeLabelEx($file, 'record');
	showButton('Record New', array('recorder/show', 'parentid'=>$file->parentid));
	echo "<p class='formHint2'><b>OR</b> click to start recording a new audio/video file in this folder.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($file, 'screencapture');
	echo CUFHtml::activeLabelEx($file, 'screencapture');
	showButton('Screen Capture', array('recorder/screencapture', 'parentid'=>$file->parentid));
	echo "<p class='formHint2'><b>OR</b> click to start capturing your screen to a video file.
			You need to have Java enabled to use this function.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($file, 'temp_url');
	echo CUFHtml::activeLabelEx($file, 'temp_url');
	echo CUFHtml::textField('temp_url', '', array('maxlength'=>200, 'class'=>'textInput'));
	echo "<p class='formHint2'><b>OR</b> enter a URL download a file directly from an internet link.</p>";
	echo CUFHtml::closeCtrlHolder();
	
//	if(param('allowyoutube') && rbacGetDefaultRole()->rank >= CMDB_RANK_TEACHER)
//	{
//		echo CUFHtml::openActiveCtrlHolder($file, 'youtube_url');
//		echo CUFHtml::activeLabelEx($file, 'youtube_url');
//		echo CUFHtml::textField('youtube_url', '', array('maxlength'=>200, 'class'=>'textInput'));
//		echo "<p class='formHint2'>
//			Alternatively, if your server supports it, you can import a video file directly 
//			from youtube. Enter the youtube URL in this field and click create. Note that this may take 
//			a few minutes depending on the length of the video you choose.</p>";
//		echo CUFHtml::closeCtrlHolder();
//	}

	echo CUFHtml::openActiveCtrlHolder($file, 'name');
	echo CUFHtml::activeLabelEx($file, 'name');
	echo CUFHtml::activeTextField($file, 'name', array('maxlength'=>200));
	echo "<p class='formHint2'><b>OR</b> enter a filename to create an empty file to edit later.</p>";
	echo CUFHtml::closeCtrlHolder();

	echo "</div>";	
}

function fileShowProperties($file)
{
	echo "<div id='properties-file'>";
	
	echo CUFHtml::openActiveCtrlHolder($file, 'filetype');
	echo CUFHtml::activeLabelEx($file, 'filetype');
	echo "<div id='mediafilename' class='miscInput'>$file->filetypeText</div>";
	echo CUFHtml::closeCtrlHolder();

	if(!empty($file->mimetype))
	{
		echo CUFHtml::openActiveCtrlHolder($file, 'mimetype');
		echo CUFHtml::activeLabelEx($file, 'mimetype');
		echo "<div class='miscInput'>$file->mimetype</div>";
		echo CUFHtml::closeCtrlHolder();
	}
	
	echo CUFHtml::openActiveCtrlHolder($file, 'size');
	echo CUFHtml::activeLabelEx($file, 'size');
	echo "<span class='miscInput'>" . Itoa($file->size) . " bytes</span>";
	echo CUFHtml::closeCtrlHolder();

	if($file->filetype == CMDB_FILETYPE_MEDIA)
	{
		echo CUFHtml::openActiveCtrlHolder($file, 'duration');
		echo CUFHtml::activeLabelEx($file, 'duration');
		echo "<span class='miscInput'>".objectDuration2a($file)."</span>";
		echo CUFHtml::closeCtrlHolder();

		echo CUFHtml::openActiveCtrlHolder($file, 'bitrate');
		echo CUFHtml::activeLabelEx($file, 'bitrate');
		echo "<span class='miscInput'>".Itoa2($file->bitrate)." bps</span>";
		echo CUFHtml::closeCtrlHolder();

		if($file->hasaudio)
		{
			echo CUFHtml::openActiveCtrlHolder($file, 'audiocodec');
			echo CUFHtml::activeLabelEx($file, 'audiocodec');
			echo "<span class='miscInput'>{$file->audiocodec}</span>";
			echo CUFHtml::closeCtrlHolder();
		}

		if($file->hasvideo)
		{
			echo CUFHtml::openActiveCtrlHolder($file, 'videocodec');
			echo CUFHtml::activeLabelEx($file, 'videocodec');
			echo "<span class='miscInput'>{$file->videocodec}</span>";
			echo CUFHtml::closeCtrlHolder();
			
			echo CUFHtml::openActiveCtrlHolder($file, 'width');
			echo CUFHtml::activeLabelEx($file, 'width');
			echo "<span class='miscInput'>{$file->width}x{$file->height}</span>";
			echo CUFHtml::closeCtrlHolder();
			
			echo CUFHtml::openActiveCtrlHolder($file, 'framerate');
			echo CUFHtml::activeLabelEx($file, 'framerate');
			echo "<span class='miscInput'>".$file->framerate."</span>";
			echo CUFHtml::closeCtrlHolder();
			
			echo CUFHtml::openActiveCtrlHolder($file, 'pixelratio');
			echo CUFHtml::activeLabelEx($file, 'pixelratio');
			echo "<span class='miscInput'>".$file->pixelratio."</span>";
			echo CUFHtml::closeCtrlHolder();
			
			echo CUFHtml::openActiveCtrlHolder($file, 'displayratio');
			echo CUFHtml::activeLabelEx($file, 'displayratio');
			echo "<span class='miscInput'>".$file->displayratio."</span>";
			echo CUFHtml::closeCtrlHolder();
		}
	}
	
	if($file->filetype == CMDB_FILETYPE_URL)
	{
		echo CUFHtml::openActiveCtrlHolder($file, 'pathname');
		echo CUFHtml::activeLabelEx($file, 'pathname');
		echo CUFHtml::activeTextField($file, 'pathname', array('maxlength'=>200));
		echo "<p class='formHint2'>Http url to an internet web page.</p>";
		echo CUFHtml::closeCtrlHolder();
		
		echo CUFHtml::openActiveCtrlHolder($file, 'http_proxy');
		echo CUFHtml::activeLabelEx($file, 'http_proxy');
		echo CUFHtml::activeCheckBox($file, 'http_proxy', array('class'=>'miscInput'));
		echo "<p class='formHint2'>Use the Sansspace http proxy to access the site.</p>";
		echo CUFHtml::closeCtrlHolder();
		
		echo CUFHtml::openActiveCtrlHolder($file->ext, 'custom');
		echo CUFHtml::activeLabelEx($file->ext, 'custom');
		echo CUFHtml::activeHiddenField($file->ext, 'custom');

		if(!empty($file->ext->custom))
			echo "<div class='textInput sans-text'>".getTextTeaser($file->ext->custom)."</div>";
		
		showTextEditorButton('ObjectExt_custom');
		echo "<p class='formHint2'>Click to edit the custom data for this site.</p>";
		echo CUFHtml::closeCtrlHolder();
	}

	echo CUFHtml::openActiveCtrlHolder($file, 'originalid');
	echo CUFHtml::activeLabelEx($file, 'originalid');
	echo CUFHtml::activeHiddenField($file, 'originalid');
	echo CUFHtml::textField('originalid_xx', $file->original? $file->original->name: '', 
		array('class'=>'textInput', 'readonly'=>true));
	
	showObjectBrowserButton($file->original, 'false', 'true', 'VFile_originalid', 'originalid_xx');
	echo "<p class='formHint2'>Master file this file is attached to. Click to select another one.</p>";
	echo '<br><br>'.CHtml::linkButton('[Reset]',
		array('submit'=>array('file/resetmaster', 'id'=>$file->id), 'confirm'=>'Are you sure?'));
	echo CUFHtml::closeCtrlHolder();
		
	echo "</div>";	
}



