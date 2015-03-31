<?php

$parent = getdbo('Object', getparam('id'));

showNavigationBar($parent->parent);
showObjectHeader($parent);
showObjectMenu($parent);

echo "<h2>New Internet Link</h2>";
$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($object);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($object, 'temp_url');
echo CUFHtml::activeLabelEx($object, 'URL');
echo CUFHtml::textField('temp_url', '', array('maxlength'=>200, 'class'=>'textInput'));
echo CUFHtml::checkBox('download', false, array('class'=>'miscInput', 'title'=>'Download File'));
echo "<p class='formHint2'>Enter an internet URL to link to. 
		If the box is checked, sansspace will download the internet file 
		(html, image, media) to your sansspace server.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($object, 'name');
echo CUFHtml::activeLabelEx($object, 'name');
echo CUFHtml::activeTextField($object, 'name', array('maxlength'=>200));
echo "<p class='formHint2'>Optional. Leave empty to let sansspace fetch the title of the web page.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Create');
echo CUFHtml::endForm();


