<?php

echo "<h2>Network Relay</h2><br>";

echo 'Changing these parameters requires to '.
l('restart', array('admin/restart')).
' the SANSSpace service to take effect.';

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Relay Name', 'relay[title]');
echo CUFHtml::textField('relay[title]', $data['RelayName'], array('class'=>'textInput'));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Relay Server', 'relay[server]');
echo CUFHtml::textField('relay[server]', $data['RelayServer'], array('class'=>'textInput'));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Enable Relay', 'relay[enable]');
echo CUFHtml::hiddenField('relay[enable]', '0');
echo CUFHtml::checkBox('relay[enable]', $data['RelayEnable']);
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();




