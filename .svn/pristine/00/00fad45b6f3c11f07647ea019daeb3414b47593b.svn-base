<?php

function objectShowPropertiesIcon($object, $update)
{
	ShowUploadHeader();
	echo "<div id='properties-icon'>";
	
	echo CUFHtml::openActiveCtrlHolder($object, 'upload_icon');
	echo CUFHtml::activeLabelEx($object, 'upload_icon');
	
	echo '<div class="miscInput">';
	echo '<span id="spanButtonPlaceholder" style="float: left;"></span>';
	echo '</div>';
	
	echo "<p class='formHint2'>Upload a small icon image to represent this page.</p>";
	echo CUFHtml::closeCtrlHolder();
	echo '<div class="flash" id="fsUploadProgress"></div>';
	
	echo CUFHtml::openActiveCtrlHolder($object, 'icon_url');
	echo CUFHtml::activeLabelEx($object,'icon_url');
	echo CUFHtml::textField('icon_url', '', array('maxlength'=>200, 'class'=>'textInput'));

	echo "<p class='formHint2'>Or enter a url to an icon image.</p>";
// 	echo "<p class='formHint2'>Or enter a url to an icon image. See this ".
// 		l('online icon bank', 'http://www.openwebgraphics.com/icons/pack/10', 
// 			array('target'=>'_blank')).".</p>";
	
	echo '<br><br>'.CHtml::linkButton('[Reset Icon]',
		array('submit'=>array('object/reseticon', 'id'=>$object->id), 'confirm'=>'Are you sure?'));
			
	echo CUFHtml::closeCtrlHolder();
	
	echo "</div>";	
}

