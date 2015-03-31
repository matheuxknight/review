<?php

showRoleBar($object);
showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

ShowUploadHeader();

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($object);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Upload File', '');
echo '<div class="miscInput"><span id="spanButtonPlaceholder"></span></div>';
echo "<p class='formHint2'>Select an access code list file to upload.</p>";
echo CUFHtml::closeCtrlHolder();
echo '<div class="flash" id="fsUploadProgress"></div>';

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();





