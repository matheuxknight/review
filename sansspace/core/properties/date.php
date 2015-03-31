<?php

function objectShowPropertiesDate($object, $update)
{
	echo "<div id='properties-date'>";

	echo CUFHtml::openActiveCtrlHolder($object, 'usedate');
	echo CUFHtml::activeLabelEx($object, 'usedate');
	echo CUFHtml::activeCheckBox($object, 'usedate', array('class'=>'miscInput'));
	echo "<p class='formHint2'>If checked, the course is only valid in
		the date range selected in the calendar below.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($object, 'startdate');
	echo CUFHtml::activeLabelEx($object, 'startdate');
	showDatetimePicker($object, 'startdate');
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($object, 'enddate');
	echo CUFHtml::activeLabelEx($object, 'enddate');
	showDatetimePicker($object, 'enddate');
	echo CUFHtml::closeCtrlHolder();
	
	echo "</div>";	
}
	
