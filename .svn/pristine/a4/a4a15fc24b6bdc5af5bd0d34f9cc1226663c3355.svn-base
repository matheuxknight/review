<?php
$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($comment);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

// echo CUFHtml::openActiveCtrlHolder($comment, 'name');
// echo CUFHtml::activeLabelEx($comment, 'name');
// echo CUFHtml::activeTextField($comment, 'name', array('maxlength'=>200));
// echo "<p class='formHint2'>Your comment title.</p>";
// echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($comment, 'doctext');
echo CUFHtml::activeTextArea($comment, 'doctext');
showAttributeEditor($comment, 'doctext', 240, 'custom2');
echo CUFHtml::closeCtrlHolder();

if(controller()->rbac->globalAdmin())
{
	echo CUFHtml::openActiveCtrlHolder($comment, 'courseid');
	echo CUFHtml::activeLabelEx($comment, 'courseid');
	echo CUFHtml::activeHiddenField($comment, 'courseid');
	echo CUFHtml::textField('courseid_xx', $comment->course? $comment->course->name: '', 
		array('class'=>'textInput', 'readonly'=>true));
	
	showObjectBrowserButton($comment->course, 'false', 'true', 'Comment_courseid', 'courseid_xx');
	echo "<p class='formHint2'>The course context this comment is attached to.</p>";
	echo '<br><br>'.CHtml::linkButton('[Reset]',
		array('submit'=>array('comment/resetcontextcourse', 'id'=>$comment->id), 'confirm'=>'Are you sure?'));
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($comment, 'pinned');
	echo CUFHtml::activeLabelEx($comment, 'pinned');
	echo CUFHtml::activeCheckBox($comment, 'pinned', array('class'=>'miscInput'));
	echo "<p class='formHint2'>If checked, the comment will show at the top of the comment list.</p>";
	echo CUFHtml::closeCtrlHolder();
}

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();
