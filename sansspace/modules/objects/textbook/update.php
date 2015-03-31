<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

echo button('Delete', "javascript:delete_code();").' ';

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($code);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($code, 'code');
echo CUFHtml::activeLabelEx($code, 'code');
echo CUFHtml::activeTextField($code, 'code', array('maxlength'=>200));
echo "<p class='formHint2'>...</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($code, 'status');
echo CUFHtml::activeLabelEx($code, 'status');
echo CUFHtml::activeDropDownList($code, 'status', UserCode::model()->statusOptions);
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Activated', 'activated');
echo CUFHtml::textField('activated', $code->started, array('readonly'=>true));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('User', 'user');
echo CUFHtml::textField('user', $code->user? $code->user->name: '', array('readonly'=>true));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Course', 'course');
echo CUFHtml::textField('course', $code->course? $code->course->name: '', array('readonly'=>true));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();


echo <<<end
<script>

function delete_code()
{
	if(confirm('Are you sure you want to delete this code?'))
		window.location.href='/textbook/deletecode?id=$code->id';
}
		
</script>
end;





