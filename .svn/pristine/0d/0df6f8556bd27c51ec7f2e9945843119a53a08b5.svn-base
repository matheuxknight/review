<?php

$parent = getdbo('Object', getparam('id'));
showNavigationBar($parent);

echo "<h2>New File</h2>";
$this->widget('UniForm');

echo CUFHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data'));
echo CUFHtml::errorSummary($file);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');

echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#properties-file'>File</a></li>";
//echo "<li><a href='#properties-categories'>Categories</a></li>";
echo "</ul><br>";

fileShowCreateProperties($file);
//objectShowPropertiesCategories($file, false);

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Create');
echo CUFHtml::endForm();
