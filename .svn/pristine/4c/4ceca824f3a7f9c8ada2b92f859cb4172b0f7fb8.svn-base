<?php

function objectShowPropertiesDebug($object, $update)
{
	echo "<div id='properties-debug'>";

	showButtonHeader();
	showButtonPost('Compute Parentlist', array(
		'submit'=>array('object/computeparentlist', 'id'=>$object->id),
		'confirm'=>'Are you sure?'));

	echo "</div><br>";
	
	echo "<b><font color=red>DO NOT MODIFY THE INFORMATION IN THE FIELDS BELOW. THEY ARE FOR DEBUGGING AND TROUBLESHOTING PURPOSES.<br><br></font></b>";
	
	echo CUFHtml::openActiveCtrlHolder($object, 'type');
	echo CUFHtml::activeLabelEx($object, 'type');
	echo CUFHtml::activeDropDownList($object, 'type', Object::model()->typeOptions);
	echo "<p class='formHint2'>The type of that object.</p>";
	echo CUFHtml::closeCtrlHolder();
		
	echo CUFHtml::openActiveCtrlHolder($object, 'parentlist');
	echo CUFHtml::activeLabelEx($object, 'parentlist');
	echo CUFHtml::activeTextField($object, 'parentlist', array('maxlength'=>200));
	echo "<p class='formHint2'>Internal parentlist.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($object, 'version');
	echo CUFHtml::activeLabelEx($object, 'version');
	echo CUFHtml::activeTextField($object, 'version',array('maxlength'=>200));
	echo "<p class='formHint2'>Version number of the object. Incremented each time it (or a sub object below) is modified.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($object, 'deleted');
	echo CUFHtml::activeLabelEx($object, 'deleted');
	echo CUFHtml::activeCheckBox($object, 'deleted', array('class'=>'miscInput'));
	echo "<p class='formHint2'>The page is marked as deleted. This is mostly because the object has been deleted from the file system.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	if($object->type != CMDB_OBJECTTYPE_FILE)
	{
		echo CUFHtml::openActiveCtrlHolder($object, 'recordings');
		echo CUFHtml::activeLabelEx($object, 'recordings');
		echo CUFHtml::activeCheckBox($object, 'recordings', array('class'=>'miscInput'));
		echo "<p class='formHint2'>This folder stores recordings. </p>";
		echo CUFHtml::closeCtrlHolder();
	
		echo CUFHtml::openActiveCtrlHolder($object, 'post');
		echo CUFHtml::activeLabelEx($object, 'post');
		echo CUFHtml::activeCheckBox($object, 'post', array('class'=>'miscInput'));
		echo "<p class='formHint2'>This page is a forum post.</p>";
		echo CUFHtml::closeCtrlHolder();
	}
	
	echo "</div>";
}
	