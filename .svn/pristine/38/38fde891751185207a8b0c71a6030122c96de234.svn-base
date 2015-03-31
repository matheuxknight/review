<?php

showNavigationBar($course->parent);
showObjectHeader($course);
showObjectMenu($course->object);

echo "<h3>Edit Activity</h3>";
$this->widget('UniForm');

echo CUFHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data'));
echo CUFHtml::errorSummary($course);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');

echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#properties-activity'>Name</a></li>";
//echo "<li><a href='#properties-html'>Description</a></li>";
//echo "<li><a href='#properties-categories'>Categories</a></li>";
echo "<li><a href='#properties-icon'>Icon</a></li>";
echo "<li><a href='#properties-date'>Date</a></li>";
echo "<li><a href='#properties-advanced'>Advanced</a></li>";

//if(controller()->rbac->objectAction($course, 'addusers'))
//	echo "<li><a href='#properties-permission'>Permissions</a></li>";

if(controller()->rbac->globalAdmin())
	echo "<li><a href='#properties-admin'>Admin</a></li>";
	
if(controller()->rbac->globalNetwork())
	echo "<li><a href='#properties-debug'>Debug</a></li>";

echo "</ul><br>";
objectShowProperties($course, true);
//objectShowPropertiesHtml($course, true);
//objectShowPropertiesCategories($course, true);
objectShowPropertiesIcon($course, true);
objectShowPropertiesDate($course, true);
courseShowPropertiesAdvanced($course, true);

//if(controller()->rbac->objectAction($course, 'addusers'))
//	objectShowPropertiesPermission($course, true);

if(controller()->rbac->globalAdmin())
	objectShowPropertiesAdmin($course, true);

if(controller()->rbac->globalNetwork())
	objectShowPropertiesDebug($course, true);

echo "</div>";

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();



