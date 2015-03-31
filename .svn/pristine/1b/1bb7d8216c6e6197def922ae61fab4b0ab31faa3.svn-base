<?php

$this->widget('UniForm');
echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($certificate);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');
echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Certificate Info</a></li>";

if($update)
{
	echo "<li><a href='#tabs-2'>Certificate Request</a></li>";
	echo "<li><a href='#tabs-3'>Private Key</a></li>";
	echo "<li><a href='#tabs-4'>Signed Certificate</a></li>";
}

echo "</ul><br>";

echo "<div id='tabs-1'>";

echo CUFHtml::openActiveCtrlHolder($certificate, 'commonname');
echo CUFHtml::activeLabelEx($certificate, 'commonname');
echo CUFHtml::activeTextField($certificate, 'commonname', array('maxlength'=>200));
echo "<p class='formHint2'>www.example.com</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($certificate, 'organisation');
echo CUFHtml::activeLabelEx($certificate, 'organisation');
echo CUFHtml::activeTextField($certificate, 'organisation', array('maxlength'=>200));
echo "<p class='formHint2'>Organisation name.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($certificate, 'organisationunit');
echo CUFHtml::activeLabelEx($certificate, 'organisationunit');
echo CUFHtml::activeTextField($certificate, 'organisationunit', array('maxlength'=>200));
echo "<p class='formHint2'>Department name.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($certificate, 'city');
echo CUFHtml::activeLabelEx($certificate, 'city');
echo CUFHtml::activeTextField($certificate, 'city', array('maxlength'=>200));
echo "<p class='formHint2'>City name.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($certificate, 'state');
echo CUFHtml::activeLabelEx($certificate, 'state');
echo CUFHtml::activeTextField($certificate, 'state', array('maxlength'=>200));
echo "<p class='formHint2'>State name.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($certificate, 'country');
echo CUFHtml::activeLabelEx($certificate, 'country');
echo CUFHtml::activeTextField($certificate, 'country', array('maxlength'=>200));
echo "<p class='formHint2'>Two letters country region code. Example: US</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

if($update)
{
	echo "<div id='tabs-2'>";
	
	echo CUFHtml::openActiveCtrlHolder($certificate, 'certrequest');
	echo CUFHtml::activeLabelEx($certificate, 'certrequest');
	echo CUFHtml::activeTextArea($certificate, 'certrequest', 
		array('style'=>'width: 100%;height: 24em;'));
	echo CUFHtml::closeCtrlHolder();
	
	echo "</div>";
	
	echo "<div id='tabs-3'>";
	
	echo CUFHtml::openActiveCtrlHolder($certificate, 'privatekey');
	echo CUFHtml::activeLabelEx($certificate, 'privatekey');
	echo CUFHtml::activeTextArea($certificate, 'privatekey', 
		array('style'=>'width: 100%;height: 24em;'));
	echo CUFHtml::closeCtrlHolder();
	
	echo "</div>";
	
	echo "<div id='tabs-4'>";
	
	echo CUFHtml::openActiveCtrlHolder($certificate, 'certificate');
	echo CUFHtml::activeLabelEx($certificate, 'certificate');
	echo CUFHtml::activeTextArea($certificate, 'certificate', 
		array('style'=>'width: 100%;height: 24em;'));
	echo CUFHtml::closeCtrlHolder();
	
	echo "</div>";
}

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

echo "</div>";


