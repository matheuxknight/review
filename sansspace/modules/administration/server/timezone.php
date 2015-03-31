<?php

showAdminHeader(5);
echo "<h2>Server Time Zone</h2>";

$data = getSansspaceIdentification();

$timezone_table = array();
$timezones = DateTimeZone::listAbbreviations();

foreach($timezones as $tz) foreach($tz as $entry)
{
	$s = $entry['timezone_id'];
	if(!empty($s)) $timezone_table[$s] = $s;
}

ksort($timezone_table);
$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Time Zone', 'data[timezone]');
echo CHtml::dropDownList('data[timezone]', $data['TimeZone'], $timezone_table);
echo "<p class='formHint2'>Select the time zone of your server.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();



