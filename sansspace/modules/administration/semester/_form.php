<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($semester);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($semester, 'name');
echo CUFHtml::activeLabelEx($semester,'name');
echo CUFHtml::activeTextField($semester,'name',array('maxlength'=>200));
echo "<p class='formHint2'>The name of the semester</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($semester, 'starttime');
echo CUFHtml::activeLabelEx($semester, 'starttime');
showDatetimePicker($semester, 'starttime');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($semester, 'endtime');
echo CUFHtml::activeLabelEx($semester, 'endtime');
showDatetimePicker($semester, 'endtime');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

