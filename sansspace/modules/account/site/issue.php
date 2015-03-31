<?php // NOT USED

$this->pageTitle=Yii::app()->name . ' Report an Issue';

echo "<h2>Report an Issue</h2>";

echo "Describe the issue you are having with this software. 
Please provide as much relevant details as you can in the 
text below and press the Submit button.";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($issue);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($issue, 'body');
echo CUFHtml::activeTextArea($issue,'body',array('maxlength'=>200));
$this->widget('application.extensions.editor.editor',
	array('name'=>'IssueForm[body]', 'type'=>'tinymce'));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Submit');
echo CUFHtml::endForm();

