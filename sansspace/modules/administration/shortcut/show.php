<?php

showAdminHeader(2);

echo "<h2>Shortcut Management</h2>";
$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Object</a></li>";
echo "<li><a href='#tabs-2'>File</a></li>";
echo "<li><a href='#tabs-3'>Course</a></li>";
echo "<li><a href='#tabs-4'>Lesson</a></li>";
echo "<li><a href='#tabs-5'>Quiz</a></li>";
echo "</ul><br>";

//////////////////////////////////////////////////////

echo "<div id='tabs-1'>";
echo "</div>";

//////////////////////////////////////////////////////

echo "<div id='tabs-2'>";
echo "</div>";

//////////////////////////////////////////////////////

echo "<div id='tabs-3'>";
echo "</div>";

//////////////////////////////////////////////////////

echo "<div id='tabs-4'>";
echo "</div>";


