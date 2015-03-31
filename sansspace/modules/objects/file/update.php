<?php

echo "<table width='100%'><tr><td valign='top'>";

showRoleBar($file);
showNavigationBar($file->parent);
showObjectHeader($file);
showObjectMenu($file->object);

//echo "<h2>File Properties</h2>";
$this->widget('UniForm');

echo CUFHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data'));
echo CUFHtml::errorSummary($file);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');

echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#properties-object'>Object</a></li>";
//echo "<li><a href='#properties-html'>Description</a></li>";
echo "<li><a href='#properties-file'>File</a></li>";

if($file->filetype == CMDB_FILETYPE_MEDIA)
//if(controller()->rbac->globalAdmin() && $file->filetype == CMDB_FILETYPE_MEDIA)
	echo "<li><a href='#properties-transcode'>Transcode</a></li>";
	
if($file->filetype == CMDB_FILETYPE_MEDIA && !empty($file->ext->mp3tags))
	echo "<li><a href='#properties-filetags'>File Tags</a></li>";

//echo "<li><a href='#properties-categories'>Categories</a></li>";
echo "<li><a href='#properties-advanced'>Advanced</a></li>";

if(controller()->rbac->globalAdmin())
{
	echo "<li><a href='#properties-enrollment'>Enrollments</a></li>";
//	echo "<li><a href='#properties-permission'>Permissions</a></li>";
	echo "<li><a href='#properties-admin'>Admin</a></li>";
}

if(controller()->rbac->globalNetwork())
	echo "<li><a href='#properties-debug'>Debug</a></li>";

echo "</ul><br>";

objectShowProperties($file, true, 'VFile');
//objectShowPropertiesHtml($file, true, 'VFile');
fileShowProperties($file, true);

//if(controller()->rbac->globalAdmin() && $file->filetype == CMDB_FILETYPE_MEDIA)
if($file->filetype == CMDB_FILETYPE_MEDIA)
	fileShowPropertiesTranscode($file);

if($file->filetype == CMDB_FILETYPE_MEDIA && !empty($file->ext->mp3tags))
	fileShowPropertiesTags($file);

//objectShowPropertiesCategories($file, true);
objectShowPropertiesAdvanced($file, true);

if(controller()->rbac->globalAdmin())
{
	objectShowPropertiesEnrollment($file, true);
//	objectShowPropertiesPermission($file, true);
	objectShowPropertiesAdmin($file, true);
}

if(controller()->rbac->globalNetwork())
	objectShowPropertiesDebug($file, true);
	
echo "</div>";
echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();

showPreviousNext($file, 'update');

echo "</td><td width='10px'></td><td valign='top' width='240px'><br>";
showFileInfoSameFolder($file, 'update');
echo "</td></tr></table>";



