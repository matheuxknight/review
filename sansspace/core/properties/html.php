<?php

function objectShowPropertiesHtml($object, $update, $type='Object')
{
	echo "<div id='properties-html'>";

	echo CUFHtml::activeTextArea($object->ext, 'doctext');
	showAttributeEditor($object->ext, 'doctext', 200, 'custom2');
	
	echo "</div>";
}


