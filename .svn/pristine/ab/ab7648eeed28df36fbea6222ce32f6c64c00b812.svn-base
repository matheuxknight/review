<?php

$user = getUser();

showRoleBar($object);
showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

//echo "<h2>Folder Properties</h2>";
$this->widget('UniForm');

echo CUFHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data'));
echo CUFHtml::errorSummary($object);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');

$totalmediafiles = dboscalar("select count(*) from VFile where filetype=".
	CMDB_FILETYPE_MEDIA." and parentlist like '%, {$object->id}, %'");

echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#properties-object'>Object</a></li>";

//if(!$object->post)
//	echo "<li><a href='#properties-html'>Description</a></li>";

//echo "<li><a href='#properties-categories'>Categories</a></li>";
echo "<li><a href='#properties-icon'>Icon</a></li>";
echo "<li><a href='#properties-advanced'>Advanced</a></li>";
if(controller()->rbac->globalAdmin() && $totalmediafiles)
	echo "<li><a href='#properties-transcode'>Transcode</a></li>";

$roles = controller()->rbac->objectRoles($object);

if(controller()->rbac->globalAdmin() || isset($roles[SSPACE_ROLE_TEACHER]))
	echo "<li><a href='#properties-permission'>Permissions</a></li>";

if(controller()->rbac->globalAdmin())
{
	echo "<li><a href='#properties-enrollment'>Enrollments</a></li>";
	echo "<li><a href='#properties-admin'>Admin</a></li>";
}

if(controller()->rbac->globalNetwork())
	echo "<li><a href='#properties-debug'>Debug</a></li>";
	
echo "</ul><br>";

objectShowProperties($object, true);

//if(!$object->post)
//	objectShowPropertiesHtml($object, true);

if(controller()->rbac->globalAdmin() && $totalmediafiles)
	objectShowPropertiesTranscode($object);

//objectShowPropertiesCategories($object, true);
objectShowPropertiesIcon($object, true);
objectShowPropertiesAdvanced($object, true);

if(controller()->rbac->globalAdmin() || isset($roles[SSPACE_ROLE_TEACHER]))
	objectShowPropertiesPermission($object, true);

if(controller()->rbac->globalAdmin())
{
	objectShowPropertiesEnrollment($object, true);
	objectShowPropertiesAdmin($object, true);
}

if(controller()->rbac->globalNetwork())
	objectShowPropertiesDebug($object, true);

echo "</div>";
echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();

showPreviousNext($object, 'update');

