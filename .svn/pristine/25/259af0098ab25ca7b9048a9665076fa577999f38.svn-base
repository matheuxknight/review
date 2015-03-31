<?php

showAdminHeader(6);
echo "<h2>SMTP Configuration</h2><br>";

echo 'Changing these parameters requires to '.
l('restart', array('admin/restart')).
' the SANSSpace service to take effect.';

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Host', 'smtp[host]');
echo CUFHtml::textField('smtp[host]', $data['SmtpHost'], array('class'=>'textInput'));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Email', 'smtp[email]');
echo CUFHtml::textField('smtp[email]', $data['SmtpEmail'], array('class'=>'textInput'));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('User', 'smtp[user]');
echo CUFHtml::textField('smtp[user]', $data['SmtpUser'], array('class'=>'textInput'));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Password', 'smtp[password]');
echo CUFHtml::passwordField('smtp[password]', $data['SmtpPassword'], array('class'=>'textInput'));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();




