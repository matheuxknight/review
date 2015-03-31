<?php
echo "<h2>Edit Contact Page</h2>";

showButtonHeader();
showButton('All Contacts', array('admin'));
echo "</div>";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($server);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($server, 'contactus');
echo CUFHtml::activeTextArea($server, 'contactus');
showAttributeEditor($server, 'contactus');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();


