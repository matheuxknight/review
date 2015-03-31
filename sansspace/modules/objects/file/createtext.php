<?php

$parent = getdbo('Object', getparam('id'));

showNavigationBar($parent->parent);
showObjectHeader($parent);
showObjectMenu($parent);

echo "<h2>New Text File</h2>";
$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($file);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($file, 'name');
echo CUFHtml::activeLabelEx($file, 'name');
echo CUFHtml::activeTextField($file, 'name', array('maxlength'=>200));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Create');
echo CUFHtml::endForm();


