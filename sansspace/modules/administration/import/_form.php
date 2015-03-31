<?php
$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($folderImport);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($folderImport, 'name');
echo CUFHtml::activeLabelEx($folderImport, 'name');
echo CUFHtml::activeTextField($folderImport, 'name', array('maxlength'=>200));
echo "<p class='formHint2'>The name of this folder import.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($folderImport, 'pathname');
echo CUFHtml::activeLabelEx($folderImport, 'pathname');
echo CUFHtml::activeTextField($folderImport, 'pathname', array('maxlength'=>200));
echo "<p class='formHint2'>This folder must be accessible by the server. Or you can enter the url to another sansspace site folder.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($folderImport, 'username');
echo CUFHtml::activeLabelEx($folderImport, 'username');
echo CUFHtml::activeTextField($folderImport, 'username', array('maxlength'=>200));
echo "<p class='formHint2'>Enter a valid username/password to login to the remote site if applicable.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($folderImport, 'password');
echo CUFHtml::activeLabelEx($folderImport, 'password');
echo CUFHtml::activePasswordField($folderImport, 'password', array('maxlength'=>200));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($folderImport, '');
echo CUFHtml::activeLabelEx($folderImport, 'Parent Folder');
echo CUFHtml::textField('database', $parent->name, array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>Attach to this folder.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($folderImport, 'autoscan');
echo CUFHtml::activeLabelEx($folderImport, 'autoscan');
echo CUFHtml::activeCheckBox($folderImport, 'autoscan', array('class'=>'miscInput'));
echo "<p class='formHint2'>In the case of a file system import, sansspace will monitor it for change.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($folderImport, 'autotranscode');
echo CUFHtml::activeLabelEx($folderImport, 'autotranscode');
echo CUFHtml::activeCheckBox($folderImport, 'autotranscode', array('class'=>'miscInput'));
echo "<p class='formHint2'>Media files will scheduled for transcoding automatically.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

