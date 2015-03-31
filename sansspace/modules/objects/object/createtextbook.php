<?php

$parent = getdbo('Object', $_GET['id']);
showNavigationBar($parent->parent);
showObjectHeader($parent);
showObjectMenu($parent);

echo "<h2>New Textbook</h2>";
$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($object);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');

echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#properties-object'>Textbook</a></li>";
echo "</ul><br>";

objectShowProperties($object, false);

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();

	