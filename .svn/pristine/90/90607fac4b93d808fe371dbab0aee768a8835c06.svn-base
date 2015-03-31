<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($semestertemplate);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($semestertemplate, 'name');
echo CUFHtml::activeLabelEx($semestertemplate,'name');
echo CUFHtml::activeTextField($semestertemplate,'name',array('maxlength'=>200));
echo "<p class='formHint2'>The name of the template</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($semestertemplate, 'starttime');
echo CUFHtml::activeLabelEx($semestertemplate, 'starttime');
showDatetimePicker($semestertemplate, 'starttime');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($semestertemplate, 'endtime');
echo CUFHtml::activeLabelEx($semestertemplate, 'endtime');
showDatetimePicker($semestertemplate, 'endtime');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

