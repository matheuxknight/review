<?php

echo "<h2>Edit Host \"$host->customername\"</h2>";

showButtonHeader();
showButton('All Hosts', array('admin'));
echo "</div>";

$this->widget('UniForm');
echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($host);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');
echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Host Info</a></li>";
echo "<li><a href='#tabs-2'>License</a></li>";
echo "</ul><br>";

//////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-1'>";

echo CUFHtml::openActiveCtrlHolder($host, 'customername');
echo CUFHtml::activeLabelEx($host, 'customername');
echo CUFHtml::activeTextField($host, 'customername');
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'url');
echo CUFHtml::activeLabelEx($host, 'url');
echo CUFHtml::activeTextField($host, 'url');
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openActiveCtrlHolder($host, 'name');
// echo CUFHtml::activeLabelEx($host, 'name');
// echo CUFHtml::activeTextField($host, 'name', array('readonly'=>true));
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'version');
echo CUFHtml::activeLabelEx($host, 'version');
echo CUFHtml::activeTextField($host, 'version', array('readonly'=>true));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

if($host->sitename != 'default')
{
	echo CUFHtml::openActiveCtrlHolder($host, 'sitename');
	echo CUFHtml::activeLabelEx($host, 'sitename');
	echo CUFHtml::activeTextField($host, 'sitename', array('readonly'=>true));
	echo "<p class='formHint2'>.</p>";
	echo CUFHtml::closeCtrlHolder();
}

echo CUFHtml::openActiveCtrlHolder($host, 'title');
echo CUFHtml::activeLabelEx($host, 'title');
echo CUFHtml::activeTextField($host, 'title', array('readonly'=>true));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'localname');
echo CUFHtml::activeLabelEx($host, 'localname');
echo CUFHtml::textField('', "$host->localip - $host->localname", array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'remotename');
echo CUFHtml::activeLabelEx($host, 'remotename');
echo CUFHtml::textField('', "$host->remoteip - $host->remotename", array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'signature');
echo CUFHtml::activeLabelEx($host, 'signature');
echo CUFHtml::activeTextField($host, 'signature', array('readonly'=>true));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openActiveCtrlHolder($host, 'serialnumber');
// echo CUFHtml::activeLabelEx($host, 'serialnumber');
// echo CUFHtml::activeTextField($host, 'serialnumber', array('readonly'=>true));
// echo "<p class='formHint2'>old stuff.</p>";
// echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openActiveCtrlHolder($host, 'licenses');
// echo CUFHtml::activeLabelEx($host, 'licenses');
// echo CUFHtml::activeTextField($host, 'licenses', array('readonly'=>true));
// echo "<p class='formHint2'>old stuff.</p>";
// echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openActiveCtrlHolder($host, 'message');
// echo CUFHtml::activeLabelEx($host, 'message');
// echo CUFHtml::activeTextField($host, 'message', array('readonly'=>true));
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

echo "</div>";

//////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";

// echo CUFHtml::openActiveCtrlHolder($host, 'customername');
// echo CUFHtml::activeLabelEx($host, 'customername');
// echo CUFHtml::activeTextField($host, 'customername');
// echo "<p class='formHint2'>.</p>";
// echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'license_active');
echo CUFHtml::activeLabelEx($host, 'license_active');
echo CUFHtml::activeCheckBox($host, 'license_active', array('class'=>'miscInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'license_concurrent');
echo CUFHtml::activeLabelEx($host, 'license_concurrent');
echo CUFHtml::activeTextField($host, 'license_concurrent');
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'license_total');
echo CUFHtml::activeLabelEx($host, 'license_total');
echo CUFHtml::activeTextField($host, 'license_total');
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'license_used');
echo CUFHtml::activeLabelEx($host, 'license_used');
echo CUFHtml::activeTextField($host, 'license_used', array('readonly'=>true));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'license_endtime');
echo CUFHtml::activeLabelEx($host, 'license_endtime');
showDatetimePicker($host, 'license_endtime');
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

// echo CUFHtml::openActiveCtrlHolder($host, 'allow_mobile');
// echo CUFHtml::activeLabelEx($host, 'allow_mobile');
// echo CUFHtml::activeCheckBox($host, 'allow_mobile', array('class'=>'miscInput'));
// echo "<p class='formHint2'>not implemented</p>";
// echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'allow_chat');
echo CUFHtml::activeLabelEx($host, 'allow_chat');
echo CUFHtml::activeCheckBox($host, 'allow_chat', array('class'=>'miscInput'));
echo "<p class='formHint2'>Enable the SANSSpace Synchronous module</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($host, 'description');
echo CUFHtml::activeLabelEx($host, 'description');
echo CHtml::textArea('Sansspacehost[description]', $host->description,
		array('style'=>'width: 45%;height: 5em;'));
echo CUFHtml::closeCtrlHolder();

echo "</div>";

echo CUFHtml::closeCtrlHolder();
echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();


