<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

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

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($survey);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');
echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Question</a></li>";
echo "<li><a href='#tabs-2'>Media</a></li>";

if($survey->answertype != CMDB_SURVEYTYPE_TEXT && $survey->answertype != CMDB_SURVEYTYPE_NONE)
	echo "<li><a href='#tabs-3'>Options</a></li>";

echo "</ul><br>";

echo "<div id='tabs-1'>";
echo CUFHtml::activeTextArea($survey, 'question');
showAttributeEditor($survey, 'question', 200, 'custom2');
echo "</div>";

/////////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";
include "update_media.php";
echo "</div>";

if($survey->answertype == CMDB_SURVEYTYPE_SELECT || $survey->answertype == CMDB_SURVEYTYPE_RANK)
{
	echo "<div id='tabs-3'>";
	include "update_options.php";
	echo "</div>";
}

echo "</div>";

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();




