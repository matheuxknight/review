<?php

function objectShowProperties($object, $update, $type='Object')
{
	echo "<div id='properties-object'>";
	
	echo CUFHtml::openActiveCtrlHolder($object, 'name');
	echo CUFHtml::activeLabelEx($object, 'name');
	echo CUFHtml::activeTextField($object, 'name', array('maxlength'=>200));
	echo "<p class='formHint2'>.</p>";
	echo CUFHtml::closeCtrlHolder();
	
// 	echo CUFHtml::openActiveCtrlHolder($object, 'tags');
// 	echo CUFHtml::activeLabelEx($object, 'tags');
// 	echo CUFHtml::activeTextField($object, 'tags', array('maxlength'=>1024));
// 	echo "<p class='formHint2'>Enter tags that relate to this object.</p>";
// 	echo CUFHtml::closeCtrlHolder();
	
	if($object->type == CMDB_OBJECTTYPE_LINK)
	{
		echo CUFHtml::openActiveCtrlHolder($object, 'linkid');
		echo CUFHtml::activeLabelEx($object, 'linkid');
		echo CUFHtml::activeHiddenField($object, 'linkid');
		
		echo CUFHtml::textField('linkid_xx', $object->link? $object->link->name: '', 
			array('class'=>'textInput', 'readonly'=>true));
			
		showObjectBrowserButton($object->link, 'true', 'true', 'Object_linkid', 'linkid_xx');
			
		echo "<p class='formHint2'>.</p>";
		echo CUFHtml::closeCtrlHolder();
	}
	
	if($object->type == CMDB_OBJECTTYPE_QUESTIONBANK)
	{
		ShowUploadHeader();
		
		echo CUFHtml::openActiveCtrlHolder($object, 'Import Moodle');
		echo CUFHtml::activeLabelEx($object, 'Import Moodle');
		echo '<div class="miscInput"><span id="spanButtonPlaceholder"></span></div>';
		echo "<p class='formHint2'>Click Upload to select the Moodle Quiz XML file you want to import and click the Create button.</p>";
		echo CUFHtml::closeCtrlHolder();
		
		echo '<div class="flash" id="fsUploadProgress"></div>';
	}
	
	echo CUFHtml::openActiveCtrlHolder($object->ext, 'doctext');
//	echo CUFHtml::activeLabelEx($object->ext, 'doctext');
	echo CUFHtml::activeTextArea($object->ext, 'doctext');
	showAttributeEditor($object->ext, 'doctext', 160, 'custom2');
	echo CUFHtml::closeCtrlHolder();
	
	echo "</div>";	
}




