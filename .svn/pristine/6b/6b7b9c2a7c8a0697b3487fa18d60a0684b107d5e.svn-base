<?php

echo "<h2>WEBDAV Configuration</h2><br>";

echo 'Changing these parameters requires to '.
l('restart', array('admin/restart')).
' the SANSSpace service to take effect.';

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Enabled', 'webdav[enable]');
echo CUFHtml::checkBox('webdav[enable]', $data['WebdavEnable'], array('class'=>'miscInput'));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Name', 'webdav[name]');
echo CUFHtml::textField('webdav[name]', $data['WebdavName'], array('class'=>'textInput'));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();




