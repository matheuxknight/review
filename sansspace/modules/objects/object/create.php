<?php

$parent = getdbo('Object', getparam('id'));

showNavigationBar($parent->parent);
showObjectHeader($parent);
showObjectMenu($parent);

echo "<h2>New Folder</h2>";
$this->widget('UniForm');

echo CUFHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data'));
echo CUFHtml::errorSummary($object);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');

echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#properties-object'>Object</a></li>";
//echo "<li><a href='#properties-html'>Html</a></li>";
//echo "<li><a href='#properties-categories'>Categories</a></li>";
//echo "<li><a href='#properties-icon'>Icon</a></li>";
//echo "<li><a href='#properties-advanced'>Advanced</a></li>";
echo "</ul><br>";

objectShowProperties($object, false);
//objectShowPropertiesHtml($object, false);

//objectShowPropertiesCategories($object, false);
//objectShowPropertiesIcon($object, false);
//objectShowPropertiesAdvanced($object, false);

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Create');
echo CUFHtml::endForm();




