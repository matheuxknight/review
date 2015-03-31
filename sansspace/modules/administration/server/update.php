<?php

echo "<h2>Edit Server</h2><br>";

showButtonHeader();
showButton('All Servers', array('admin'));
echo "</div>";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($server);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($server, 'title');
echo CUFHtml::activeLabelEx($server, 'title');
echo CUFHtml::activeTextField($server, 'title');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'version');
echo CUFHtml::activeLabelEx($server, 'version');
echo CUFHtml::activeTextField($server, 'version');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'lastaccess');
echo CUFHtml::activeLabelEx($server, 'lastaccess');
echo CUFHtml::activeTextField($server, 'lastaccess');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'signature');
echo CUFHtml::activeLabelEx($server, 'signature');
echo CUFHtml::activeTextField($server, 'signature');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'serialnumber');
echo CUFHtml::activeLabelEx($server, 'serialnumber');
echo CUFHtml::activeTextField($server, 'serialnumber');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'localname');
echo CUFHtml::activeLabelEx($server, 'localname');
echo CUFHtml::activeTextField($server, 'localname');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'porthttp');
echo CUFHtml::activeLabelEx($server, 'porthttp');
echo CUFHtml::activeTextField($server, 'porthttp');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'localip');
echo CUFHtml::activeLabelEx($server, 'localip');
echo CUFHtml::activeTextField($server, 'localip');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'remotename');
echo CUFHtml::activeLabelEx($server, 'remotename');
echo CUFHtml::activeTextField($server, 'remotename');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'remoteip');
echo CUFHtml::activeLabelEx($server, 'remoteip');
echo CUFHtml::activeTextField($server, 'remoteip');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();





