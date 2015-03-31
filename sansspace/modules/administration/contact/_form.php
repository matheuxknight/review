<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($contact);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($contact, 'name');
echo CUFHtml::activeLabelEx($contact,'name');
echo CUFHtml::activeTextField($contact,'name',array('maxlength'=>200));
echo "<p class='formHint2'>Name of this contact.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($contact, 'email');
echo CUFHtml::activeLabelEx($contact,'email');
echo CUFHtml::activeTextField($contact,'email',array('maxlength'=>200));
echo "<p class='formHint2'>Email of this contact.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($contact, 'subject');
echo CUFHtml::activeLabelEx($contact,'subject');
echo CUFHtml::activeTextField($contact,'subject', array('maxlength'=>200));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($contact, 'doctext');
echo CUFHtml::activeTextArea($contact, 'doctext');
showAttributeEditor($contact, 'doctext');
echo CUFHtml::closeCtrlHolder();
	
echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();





