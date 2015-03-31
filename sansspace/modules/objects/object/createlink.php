<?php

$parent = getdbo('Object', getparam('id'));
showNavigationBar($parent->parent);
showObjectHeader($parent);
showObjectMenu($parent);

echo "<h2>Add Link</h2>";
$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($object);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($object, 'linkid');
echo CUFHtml::activeLabelEx($object, 'Object');
echo CUFHtml::activeHiddenField($object, 'linkid');

echo CUFHtml::textField('linkid_xx', '', array('class'=>'textInput', 'readonly'=>true));
showObjectBrowserButton($parent, 'true', 'true', 'Object_linkid', 'linkid_xx', 'objectSelected');
JavascriptReady("onShowObjectBrowser(0, true, true, 
		'Object_linkid', 'linkid_xx', 'mylocations', 'Other Resources', objectSelected);");

echo "<p class='formHint2'>Click to select an object to link to.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($object, 'name');
echo CUFHtml::activeLabelEx($object, 'name');
echo CUFHtml::activeTextField($object, 'name', array('maxlength'=>200));
echo "<p class='formHint2'>Optional. Leave empty to use the name of the file.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Create');
echo CUFHtml::endForm();

echo <<<end
<script>

function objectSelected(selectedid, selectedname)
{
	if(!selectedid) return;
	$('#Object_name').val(selectedname);
}

</script>
end;


