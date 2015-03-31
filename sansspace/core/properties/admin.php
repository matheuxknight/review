<?php

function objectShowPropertiesAdmin($object, $update)
{
	echo "<div id='properties-admin'>";
	
	showButtonHeader();
	if($object->scanstatus == CMDB_OBJECTSCAN_BUSY)
		echo "<blink>Scanning</blink>";
	else
	{
		if($object->type == CMDB_OBJECTTYPE_FILE)
		{
			showButtonPost('Rescan File', array(
				'submit'=>array('object/rescanfile', 'id'=>$object->id),
				'confirm'=>'Are you sure?'));
			
// 			showButtonPost('Generate Thumbnails', array(
// 				'submit'=>array('object/generatethumbnails', 'id'=>$object->id),
// 				'confirm'=>'Are you sure?'));
			
			showButtonPost('Clean', array(
				'submit'=>array('object/cleandeleted', 'id'=>$object->id),
				'confirm'=>'Are you sure?'));
		}
		
		else
		{
			showButtonPost('Rescan For New Files', array(
				'submit'=>array('object/rescan', 'id'=>$object->id),
				'confirm'=>'Are you sure?'));
			
			showButtonPost('Rescan All Files', array(
				'submit'=>array('object/rescanall', 'id'=>$object->id),
				'confirm'=>'Are you sure?'));
			
// 			showButtonPost('Generate Thumbnails', array(
// 				'submit'=>array('object/generatethumbnails', 'id'=>$object->id),
// 				'confirm'=>'Are you sure?'));
			
			showButtonPost('Clean Deleted Objects', array(
				'submit'=>array('object/cleandeleted', 'id'=>$object->id),
				'confirm'=>'Are you sure?'));
		}
	}

	echo "</div><br>";
	
	echo CUFHtml::openActiveCtrlHolder($object, 'authorid');
	echo CUFHtml::activeLabelEx($object, 'authorid');
	showAutocompleteUserModel($object, 'authorid', $object->author? $object->author->name: '<SYSTEM>');
	echo CHtml::activeHiddenField($object, 'authorid');
	echo "<p class='formHint2'>The owner of the object.</p>";
	echo CUFHtml::closeCtrlHolder();
	
// 	if($object->type == CMDB_OBJECTTYPE_OBJECT)
// 	{
// 		echo CUFHtml::openActiveCtrlHolder($object, 'model');
// 		echo CUFHtml::activeLabelEx($object, 'model');
// 		echo CUFHtml::activeCheckBox($object, 'model', array('class'=>'miscInput'));
// 		echo "<p class='formHint2'>
// 		This object and those below will inherit the contents and the related contents 
// 		of its parent if the parent also has this value checked. Inheritance can go up 
// 		many levels. As long as this flag is checked.</p>";
// 		echo CUFHtml::closeCtrlHolder();
// 	}
	
	echo CUFHtml::openActiveCtrlHolder($object, 'courseid');
	echo CUFHtml::activeLabelEx($object, 'courseid');
	echo CUFHtml::activeHiddenField($object, 'courseid');
	echo CUFHtml::textField('courseid_xx', $object->contextcourse? $object->contextcourse->name: '', 
		array('class'=>'textInput', 'readonly'=>true));
	
	showObjectBrowserButton($object->contextcourse, 'false', 'true', 'Object_courseid', 'courseid_xx');
	echo "<p class='formHint2'>The course context this object is attached to. Leave empty to apply to all courses.</p>";
	echo '<br><br>'.CHtml::linkButton('[Reset]',
		array('submit'=>array('object/resetcontextcourse', 'id'=>$object->id), 'confirm'=>'Are you sure?'));
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($object, 'frontpage');
	echo CUFHtml::activeLabelEx($object, 'frontpage');
	echo CUFHtml::activeCheckBox($object, 'frontpage', array('class'=>'miscInput'));
	echo "<p class='formHint2'>An overview of this page will show on the home page.</p>";
	echo CUFHtml::closeCtrlHolder();

	//echo CUFHtml::openActiveCtrlHolder($object, 'exempt');
	//echo CUFHtml::activeLabelEx($object, 'exempt');
	//echo CUFHtml::activeTextField($object, 'exempt');
	//echo "<p class='formHint2'>An overview of this page will show on the home page.</p>";
	//echo CUFHtml::closeCtrlHolder();
	
	if($object->folderimport)
	{
		echo CUFHtml::openActiveCtrlHolder($object, 'folderimportid');
		echo CUFHtml::activeLabelEx($object, 'folderimportid');
		echo l($object->folderimport->name, array('import/update', 'id'=>$object->folderimport->id));
	
		if(strncmp($object->folderimport->pathname, 'http://', 7) == 0)
			echo ' '.CHtml::linkButton('[Detach]',
				array('submit'=>array('detach', 'id'=>$object->id), 'confirm'=>'Are you sure?'));
		
		echo "<p class='formHint2'>This object is attached to this folder import.</p>";
		echo CUFHtml::closeCtrlHolder();
	}
	
	if($object->file || $object->folderimport)
	{
		if($object->file->filetype != CMDB_FILETYPE_URL)
		{
			echo CUFHtml::openActiveCtrlHolder($object, 'pathname');
			echo CUFHtml::activeLabelEx($object, 'pathname');
			echo CUFHtml::activeTextField($object, 'pathname', array('maxlength'=>200));
			echo "<p class='formHint2'>Internal filename on disk relative to folder import if any.</p>";
			echo CUFHtml::closeCtrlHolder();
		}
		
		if(	$object->folderimport || ($object->file &&
			$object->file->filetype != CMDB_FILETYPE_URL && 
			$object->file->filetype != CMDB_FILETYPE_UNKNOWN &&
			$object->file->filetype != CMDB_FILETYPE_DVD &&
			$object->file->filetype != CMDB_FILETYPE_LINK))
		{
			echo CUFHtml::openCtrlHolder();
			echo CUFHtml::label('Fullname', '', array('class'=>'miscInput'));
			echo CUFHtml::textField('', objectPathname($object), array('readonly'=>true, 'class'=>'textInput'));
			echo "<p class='formHint2'>Complete path name.</p>";
			echo CUFHtml::closeCtrlHolder();
	
			$filename = objectPathname($object);
			if(!file_exists($filename))
				echo "<blink>File not found</blink>";
		}
	}

	echo "</div>";	
}

	

