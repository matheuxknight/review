<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($template);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>General</a></li>";
echo "<li><a href='#tabs-2'>Audio</a></li>";
echo "<li><a href='#tabs-3'>Video</a></li>";
echo "</ul><br>";

//////////////////////////////////////////////////////////////////////

echo "<div id='tabs-1'>";

echo CUFHtml::openActiveCtrlHolder($template, 'name');
echo CUFHtml::activeLabelEx($template, 'name');
echo CUFHtml::activeTextField($template, 'name', array('maxlength'=>200));
echo "<p class='formHint2'>The name of this transcode template.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($template, 'enable');
echo CUFHtml::activeLabelEx($template, 'enable');
echo CUFHtml::activeCheckBox($template, 'enable', array('class'=>'miscInput'));
echo "<p class='formHint2'>Check to enable this template.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($template, 'active');
echo CUFHtml::activeLabelEx($template, 'active');
echo CUFHtml::activeCheckBox($template, 'active', array('class'=>'miscInput'));
echo "<p class='formHint2'>Check to use this template by default.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

//////////////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";

$audiocodecs = array('none'=>'none', 'aac'=>'AAC', 'mp3'=>'MP3');	//, 'speex'=>'Speex');

echo CUFHtml::openActiveCtrlHolder($template, 'audiocodec');
echo CUFHtml::activeLabelEx($template, 'audiocodec');
echo CUFHtml::activeDropDownList($template, 'audiocodec', $audiocodecs);
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

//$audiochannels = array('1'=>'mono', '2'=>'stereo');
//
//echo CUFHtml::openActiveCtrlHolder($template, 'audiochannel');
//echo CUFHtml::activeLabelEx($template, 'audiochannel');
//echo CUFHtml::activeDropDownList($template, 'audiochannel', $audiochannels);
//echo "<p class='formHint2'>The number of audio channels.</p>";
//echo CUFHtml::closeCtrlHolder();

$audiofreqs = array(''=>'default', '11025'=>'11.025 kHz', '22050'=>'22.05 kHz', 
	'44100'=>'44.1 kHz', '48000'=>'48.0 kHz', '96000'=>'96.0 kHz');

echo CUFHtml::openActiveCtrlHolder($template, 'audiofreq');
echo CUFHtml::activeLabelEx($template, 'audiofreq');
echo CUFHtml::activeDropDownList($template, 'audiofreq', $audiofreqs);
echo "<p class='formHint2'>The audio sampling rate.</p>";
echo CUFHtml::closeCtrlHolder();

$audiobitrates = array(''=>'default', '32k'=>'32k', '48k'=>'48k', '64k'=>'64k', 
	'96k'=>'96k', '128k'=>'128k');

echo CUFHtml::openActiveCtrlHolder($template, 'audiobitrate');
echo CUFHtml::activeLabelEx($template, 'audiobitrate');
echo CUFHtml::activeDropDownList($template, 'audiobitrate', $audiobitrates);
echo "<p class='formHint2'>The audio bitrate in kbps.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

//////////////////////////////////////////////////////////////////////

echo "<div id='tabs-3'>";

$videocodecs = array('none'=>'none', 'h263'=>'H.263', 'h264'=>'H.264', 'flashsv'=>'Screen');

echo CUFHtml::openActiveCtrlHolder($template, 'videocodec');
echo CUFHtml::activeLabelEx($template, 'videocodec');
echo CUFHtml::activeDropDownList($template, 'videocodec', $videocodecs);
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

$videodimensions = array(''=>'default', '240'=>'240', '360'=>'360', '480'=>'480', '720'=>'720');

echo CUFHtml::openActiveCtrlHolder($template, 'videodimension');
echo CUFHtml::activeLabelEx($template, 'videodimension');
echo CUFHtml::activeDropDownList($template, 'videodimension', $videodimensions);
echo "<p class='formHint2'>The number of vertical lines for the video image.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($template, 'videobitrate');
echo CUFHtml::activeLabelEx($template, 'videobitrate');
echo CUFHtml::activeTextField($template, 'videobitrate', array('maxlength'=>200));
echo "<p class='formHint2'>The video bitrate (ex. 1500k or empty for default).</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($template, 'params');
echo CUFHtml::activeLabelEx($template, 'params');
echo CUFHtml::activeTextField($template, 'params', array('maxlength'=>200));
echo "<p class='formHint2'>Extra parameters for the transcoder.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

/////////////////////////////////////////////////////////////////////

echo "</div>";

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

