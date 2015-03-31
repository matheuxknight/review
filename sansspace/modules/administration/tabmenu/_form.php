<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($tabmenu);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($tabmenu, 'name');
echo CUFHtml::activeLabelEx($tabmenu,'name');
echo CUFHtml::activeTextField($tabmenu,'name',array('maxlength'=>200));
echo "<p class='formHint2'>Name of this tab menu.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($tabmenu, 'objectid');
echo CUFHtml::activeLabelEx($tabmenu, 'objectid');
echo CUFHtml::activeHiddenField($tabmenu, 'objectid');
echo CUFHtml::textField('objectid_xx', $tabmenu->object? $tabmenu->object->name: '',
	array('class'=>'textInput', 'readonly'=>true));
showObjectBrowserButton($tabmenu->object, 'true', 'true', 'Tabmenu_objectid', 'objectid_xx');
echo "<p class='formHint2'>The target object can be a folder, a course or a file.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($tabmenu, 'url');
echo CUFHtml::activeLabelEx($tabmenu,'url');
echo CUFHtml::activeTextField($tabmenu,'url',array('maxlength'=>1000));
echo "<p class='formHint2'>URL to an internet location. This value is only used when the above object is NOT selected.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();



