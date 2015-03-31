<?php

showAdminHeader(6);
echo "<h2>Socket Bindings</h2>";

echo 'Changing these parameters requires to '.
l('restart', array('admin/restart')).
' the SANSSpace service to take effect.';

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');
echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>HTTP</a></li>";
echo "<li><a href='#tabs-2'>HTTPS</a></li>";
echo "<li><a href='#tabs-3'>RTMP</a></li>";
echo "</ul><br>";

echo "<div id='tabs-1'>";

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Enabled', 'bindings[httpenabled]');
echo CUFHtml::checkBox('bindings[httpenabled]', $data['HttpEnable'], array('class'=>'miscInput'));
echo "<p class='formHint2'>Enable the HTTP protocol.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Port', 'bindings[httpport]');
echo CUFHtml::textField('bindings[httpport]', $data['HttpPort'], array('class'=>'textInput'));
echo "<p class='formHint2'>The port number for the HTTP protocol. Usually 80.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Forward', 'bindings[httpforward]');
echo CUFHtml::textField('bindings[httpforward]', $data['HttpForward'], array('class'=>'textInput'));
echo "<p class='formHint2'>Complete URL to forward this traffic to (https://www.example.com).</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

echo "<div id='tabs-2'>";

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Enabled', 'bindings[httpsenabled]');
echo CUFHtml::checkBox('bindings[httpsenabled]', $data['HttpsEnable'], array('class'=>'miscInput'));
echo "<p class='formHint2'>Enable the HTTPS protocol.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Port', 'bindings[httpsport]');
echo CUFHtml::textField('bindings[httpsport]', $data['HttpsPort'], array('class'=>'textInput'));
echo "<p class='formHint2'>The port number for the HTTPS protocol. Usually 443.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Forward', 'bindings[httpsforward]');
echo CUFHtml::textField('bindings[httpsforward]', $data['HttpsForward'], array('class'=>'textInput'));
echo "<p class='formHint2'>Complete URL to forward this traffic to (http://www.example.com).</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Certificate', 'bindings[certificateid]');
echo CUFHtml::dropDownList('bindings[certificateid]', $data['HttpsCertificateId'], 
	Certificate::model()->options, array('class'=>'miscInput'));
echo "<p class='formHint2'>Choose a certificate that you have created on the Certificate page for the HTTPS protocol.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

echo "<div id='tabs-3'>";

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Enabled', 'bindings[rtmpenabled]');
echo CUFHtml::checkBox('bindings[rtmpenabled]', $data['RtmpEnable'], array('class'=>'miscInput'));
echo "<p class='formHint2'>Enable the RTMP protocol. This protocol is used to stream audio and video.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Port', 'bindings[rtmpport]');
echo CUFHtml::textField('bindings[rtmpport]', $data['RtmpPort'], array('class'=>'textInput'));
echo "<p class='formHint2'>The port number for the RTMP protocol. Usually 1935.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";
echo "</div>";

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();




