<?php

function courseShowProperties($course, $update)
{
	echo "<div id='properties-course'>";
	
	echo CUFHtml::openActiveCtrlHolder($course, 'name');
	echo CUFHtml::activeLabelEx($course, 'name');
	echo CUFHtml::activeTextField($course, 'name', array('maxlength'=>30));
	echo "<p class='formHint2'>.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($course, 'tags');
	echo CUFHtml::activeLabelEx($course, 'tags');
	echo CUFHtml::activeTextField($course, 'tags', array('maxlength'=>200));
	echo "<p class='formHint2'>.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($course, 'semesterid');
	echo CUFHtml::activeLabelEx($course, 'semesterid');
	echo CUFHtml::activeDropDownList($course, 'semesterid', Semester::model()->options);
	echo "<p class='formHint2'></p>";
	echo CUFHtml::closeCtrlHolder();
	
// 	echo CUFHtml::openActiveCtrlHolder($course, 'enrolltype');
// 	echo CUFHtml::activeLabelEx($course, 'enrolltype');
// 	echo CUFHtml::activeDropDownList($course, 'enrolltype', Object::model()->enrollTypeOptions);
// 	echo "<p class='formHint2'>.</p>";
// 	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($course->ext, 'doctext');
//	echo CUFHtml::activeLabelEx($course->ext, 'doctext');
	echo CUFHtml::activeTextArea($course->ext, 'doctext');
	showAttributeEditor($course->ext, 'doctext', 160, 'custom2');
	echo CUFHtml::closeCtrlHolder();
	
	echo "</div>";
}



