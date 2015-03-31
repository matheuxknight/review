<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

showButtonHeader();
showButton('Preview Question', array('preview', 'id'=>$question->id));
showButtonPost('Delete Question', 
	array('submit'=>array('delete', 'id'=>$question->id), 'confirm'=>'Are you sure you want to delete this question?'));
echo "</div>";

$teaser = getTextTeaser($question->question, 80);
echo "<p><b>#$question->id</b> - $teaser</p>";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($question);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');
echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Question</a></li>";
echo "<li><a href='#tabs-2'>Media</a></li>";
echo "<li><a href='#tabs-3'>Options</a></li>";

if($question->answertype == CMDB_QUIZQUESTION_SHORTTEXT)
	echo "<li><a href='#tabs-4'>Short Text</a></li>";
	
if($question->answertype == CMDB_QUIZQUESTION_SELECT)
	echo "<li><a href='#tabs-5'>Choices</a></li>";

if($question->answertype == CMDB_QUIZQUESTION_MATCHING)
	echo "<li><a href='#tabs-6'>Matching</a></li>";

if($question->answertype == CMDB_QUIZQUESTION_CLOZE)
	echo "<li><a href='#tabs-7'>Cloze</a></li>";

echo "</ul><br>";

echo "<div id='tabs-1'>";
echo CUFHtml::activeTextArea($question, 'question');
showAttributeEditor($question, 'question', 320, 'custom2');
echo "</div>";

////////////////////////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";
include "update_media.php";
echo "</div>";

////////////////////////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-3'>";

echo CUFHtml::openActiveCtrlHolder($question, 'name');
echo CUFHtml::activeLabelEx($question, 'name');
echo CUFHtml::activeTextField($question, 'name', array('maxlength'=>200));
echo "<p class='formHint2'>Optional.</p>";
echo CUFHtml::closeCtrlHolder();

if($question->answertype != CMDB_QUIZQUESTION_NONE)
{
	echo CUFHtml::openActiveCtrlHolder($question, 'grade');
	echo CUFHtml::activeLabelEx($question, 'grade');
	echo CUFHtml::activeTextField($question, 'grade', array('maxlength'=>200));
	echo "<p class='formHint2'>The maximum points for that question.</p>";
	echo CUFHtml::closeCtrlHolder();

	echo CUFHtml::openActiveCtrlHolder($question, 'penalty');
	echo CUFHtml::activeLabelEx($question, 'penalty');
	echo CUFHtml::activeTextField($question, 'penalty', array('maxlength'=>200));
	echo "<p class='formHint2'>The penalty if the answer is wrong.</p>";
	echo CUFHtml::closeCtrlHolder();
}

// echo CUFHtml::openActiveCtrlHolder($question, 'timelimit');
// echo CUFHtml::activeLabelEx($question, 'timelimit');
// echo CUFHtml::activeTextField($question, 'timelimit', array('maxlength'=>200));
// echo "<p class='formHint2'>Not implemented</p>";
// echo CUFHtml::closeCtrlHolder();

echo "</div>";

if($question->answertype == CMDB_QUIZQUESTION_SHORTTEXT)
{
	echo "<div id='tabs-4'>";
	include "update_shorttext.php";
	echo "</div>";
}

if($question->answertype == CMDB_QUIZQUESTION_SELECT)
{
	echo "<div id='tabs-5'>";
	include "update_select.php";
	echo "</div>";
}

if($question->answertype == CMDB_QUIZQUESTION_MATCHING)
{
	echo "<div id='tabs-6'>";
	include "update_matching.php";
	echo "</div>";
}

if($question->answertype == CMDB_QUIZQUESTION_CLOZE)
{
	echo "<div id='tabs-7'>";
	include "update_cloze.php";
	echo "</div>";
}

echo "</div>";

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();






