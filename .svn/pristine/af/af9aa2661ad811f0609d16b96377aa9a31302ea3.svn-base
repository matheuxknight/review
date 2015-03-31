<?php

function courseShowPropertiesAdvanced($course, $update)
{
	echo "<div id='properties-advanced'>";
	
	echo CUFHtml::openActiveCtrlHolder($course, 'hidden');
	echo CUFHtml::activeLabelEx($course, 'hidden');
	echo CUFHtml::activeCheckBox($course, 'hidden', array('class'=>'miscInput'));
	$teacher = getdbosql('Role', "name='teacher'");
	echo "<p class='formHint2'>This item will be visible only to $teacher->description and admins.
	Users still have the permission to use the file according to their role.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($course, 'model');
	echo CUFHtml::activeLabelEx($course, 'model');
	echo CUFHtml::activeCheckBox($course, 'model', array('class'=>'miscInput'));
	echo "<p class='formHint2'>If checked, this course will inherit the links from its parent.</p>";
	echo CUFHtml::closeCtrlHolder();
	
// 	echo CUFHtml::openActiveCtrlHolder($course->ext, 'customcolor1');
// 	echo CUFHtml::activeLabelEx($course->ext, 'customcolor1');
// 	echo CUFHtml::activeTextField($course->ext, 'customcolor1', array('class'=>'miscInput'));
// 	echo "<p class='formHint2'>The custom color 1 of this object (lighter).</p>";
// 	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($course->ext, 'customcolor2');
	echo CUFHtml::activeLabelEx($course->ext, 'customcolor2');
	echo CUFHtml::activeTextField($course->ext, 'customcolor2', array('class'=>'miscInput'));
	echo "<p class='formHint2'>The custom color 2 of this object (darker).</p>";
	echo CUFHtml::closeCtrlHolder();
	
	$options = array('default'=>'default');
	$folders = glob(SANSSPACE_HTDOCS.'/images/iconset/*');
	foreach($folders as $f)
	{
		$name = strrchr($f, '/');
		$name = substr($name, 1);
	
		$options[$name] = $name;
	}
	
	echo CUFHtml::openCtrlHolder();
	echo CUFHtml::activeLabelEx($course->ext, 'customiconset');
	echo CUFHtml::activeDropDownList($course->ext, 'customiconset', $options, array('class'=>'miscInput'));
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($course->ext, 'customheader');
	echo CUFHtml::activeLabelEx($course->ext, 'customheader');
	echo CUFHtml::activeHiddenField($course->ext, 'customheader');
	
	if(!empty($course->ext->customheader))
		echo "<div class='textInput sans-text'>".getTextTeaser($course->ext->customheader)."</div>";
	showObjectEditorButton('ObjectExt_customheader');
	
	echo "<p class='formHint2'>The custom header of this object.</p>";
	echo CUFHtml::closeCtrlHolder();

	if(param('theme') == 'wayside')
	{
		echo CUFHtml::openActiveCtrlHolder($course->ext, 'custom');
		echo CUFHtml::activeLabelEx($course->ext, 'custom', array('label'=>'Exempt'));
		echo CUFHtml::activeCheckBox($course->ext, 'custom');
		echo "<p class='formHint2'>Checkbox to make course exempt from deletion during Single Enroll Course deletion script.</p>";
		echo CUFHtml::closeCtrlHolder();
	}
	
	else
	{
		echo CUFHtml::openActiveCtrlHolder($course->ext, 'custom');
		echo CUFHtml::activeLabelEx($course->ext, 'custom');
		echo CUFHtml::activeTextField($course->ext, 'custom', array('class'=>'miscInput'));
		echo "<p class='formHint2'>Site specific course custom field.</p>";
		echo CUFHtml::closeCtrlHolder();
	}
	
	$servername = getFullServerName();
	
	echo CUFHtml::openCtrlHolder();
	echo CUFHtml::label('Dropbox Shortcut', '');
	echo CUFHtml::textField('courselink', "$servername/recorder/record?courseid=$course->id",
		array('class'=>'textInput', 'readonly'=>true));
	echo "<p class='formHint2'>$course->nowint</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo "</div>";	
}



