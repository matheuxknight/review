<?php
$this->pageTitle = app()->name .' - '. $file->name;

showRoleBar($file);
showNavigationBar($file->parent);
showObjectHeader($file);
showObjectMenu($file->object);

// show html editor and save button

$filename = objectPathname($file);
$htmlcontents = file_get_contents($filename);

echo CUFHtml::beginForm();

echo CUFHtml::textArea('htmlcontents', $htmlcontents);
showHtmlEditor('htmlcontents', 300, 'custom2');

showSubmitButton('Save');
echo CUFHtml::endForm();

showObjectFooter($file);
showObjectComments($file);

