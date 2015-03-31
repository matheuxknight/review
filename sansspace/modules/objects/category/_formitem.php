<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($categoryitem);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($categoryitem, 'name');
echo CUFHtml::activeLabelEx($categoryitem, 'name');
echo CUFHtml::activeTextField($categoryitem, 'name', array('maxlength'=>200));
echo "<p class='formHint2'>Name of this category item.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();


