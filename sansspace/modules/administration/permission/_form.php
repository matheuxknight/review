<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($permission);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($permission, 'name');
echo CUFHtml::activeLabelEx($permission, 'name');
echo CUFHtml::activeTextField($permission, 'name', array('maxlength'=>200));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($permission, 'title');
echo CUFHtml::activeLabelEx($permission, 'title');
echo CUFHtml::activeTextField($permission, 'title', array('maxlength'=>200));
echo "<p class='formHint2'>Help tool tip.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($permission, 'url');
echo CUFHtml::activeLabelEx($permission, 'url');
echo CUFHtml::activeTextField($permission, 'url', array('maxlength'=>200));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

