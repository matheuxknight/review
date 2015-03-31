<?php

echo "<h2>Upload .pfx file for $certificate->commonname</h2>";

showButtonHeader();

showButton('All Certificates', array('admin'));
showButton($certificate->commonname, array('update', 'id'=>$certificate->id));

echo "</div>";

ShowUploadHeader();

$this->widget('UniForm');
echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($certificate);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('File', '');

echo '<div class="miscInput">';
echo '<span id="spanButtonPlaceholder" style="float: left;"></span>';
echo '</div>';

echo "<p class='formHint2'>Select your .pfx file.</p>";
echo CUFHtml::closeCtrlHolder();

echo '<div class="flash" id="fsUploadProgress"></div>';

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Password', 'cert_password');
echo CUFHtml::textField('cert_password', '', array('class'=>'textInput'));
echo "<p class='formHint2'>Type the password or the passphrase for that .pfx file.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();

