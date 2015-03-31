<?php

$data = getSansspaceIdentification();

showAdminHeader(5);
echo "<h2>Server License</h2>";

echo "<script> $(function() {\$('a', '.buttonHolder').button();	}); </script>";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Server Signature', 'data[signature]');
echo CUFHtml::textField('data[signature]', $data['Signature'], array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>Signature of this server.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('License Count', 'data[licensecount]');
echo CUFHtml::textField('data[licensecount]', $data['LicenseTotal'], array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>Number of concurrent licenses available on this server.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Serial Number', 'data[serialnumber]');
echo CUFHtml::textField('data[serialnumber]', $data['SerialNumber'], array('class'=>'textInput'));
echo "<p class='formHint2'>Enter your Serial Number here.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();



