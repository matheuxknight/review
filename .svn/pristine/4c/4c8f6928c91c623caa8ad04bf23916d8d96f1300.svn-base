<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($enrollment);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openCtrlHolder();
echo CUFHtml::activeLabelEx($enrollment, 'userid');

if($update)
{
	echo CUFHtml::activeTextField($enrollment->user, 'name', array('readonly'=>true));
	echo "<p class='formHint2'>.</p>";
}
else
{
	showAutocompleteUserModel($enrollment, 'userid');
	echo CUFHtml::activeHiddenField($enrollment, 'userid');
	echo "<p class='formHint2'>Type the name of the user you want to enroll to this object. Leave empty to enroll everyone with that role.</p>";
}
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($enrollment, 'roleid');
echo CUFHtml::activeLabelEx($enrollment, 'roleid');
echo CUFHtml::activeDropDownList($enrollment, 'roleid', Role::model()->userData);
echo "<p class='formHint2'>Choose the role for this enrollment.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();





