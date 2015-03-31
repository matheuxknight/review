<?php

$parent = getdbo('Object', $_GET['id']);
showNavigationBar($parent->parent);
showObjectHeader($parent);
showObjectMenu($parent);

echo "<h2>New Quiz</h2>";
$this->widget('UniForm');

echo CUFHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data'));
echo CUFHtml::errorSummary($course);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');

echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#properties-activity'>Quiz</a></li>";
//echo "<li><a href='#properties-html'>Description</a></li>";
//echo "<li><a href='#properties-categories'>Categories</a></li>";
//echo "<li><a href='#properties-icon'>Icon</a></li>";
//echo "<li><a href='#properties-date'>Date</a></li>";
//echo "<li><a href='#properties-advanced'>Advanced</a></li>";
echo "</ul><br>";

objectShowProperties($course, false);
//objectShowPropertiesHtml($course, false);
//objectShowPropertiesCategories($course, false);
//objectShowPropertiesIcon($course, false);
//objectShowPropertiesDate($course, false);
//courseShowPropertiesAdvanced($course, true);

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();

	