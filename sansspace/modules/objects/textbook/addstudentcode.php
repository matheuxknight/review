<?php

echo "<h2>Enroll in my course</h2>";
echo "<p style='color:#555555'>Enter your student access code and click Continue.<br>
You will find your student access code in an insert or on the inside front cover of your textbook.";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($code);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

if($code->id)
{
	echo l('Enter Another Code', array('addstudentcode')).'<br><br>';
	echo CUFHtml::activeHiddenField($code, 'id');
	
	echo CUFHtml::openActiveCtrlHolder($code, 'code');
	echo CUFHtml::activeLabelEx($code, 'code');
	echo CUFHtml::activeTextField($code, 'code', array('readonly'=>true));
	echo "<p class='formHint2'></p>";
	echo CUFHtml::closeCtrlHolder();

	echo CUFHtml::openActiveCtrlHolder($code, 'status');
	echo CUFHtml::label('Status', 'status');
	echo CUFHtml::textField('status', $code->statusText, array('readonly'=>true));
	echo "<p class='formHint2'></p>";
	echo CUFHtml::closeCtrlHolder();

	if(controller()->rbac->globalAdmin() || $code->user->id == userid())
	{
		if(!empty($code->started))
		{
			echo CUFHtml::openCtrlHolder();
			echo CUFHtml::label('Activated', 'activated');
			echo CUFHtml::textField('activated', $code->started, array('readonly'=>true));
			echo "<p class='formHint2'></p>";
			echo CUFHtml::closeCtrlHolder();
		}
		
		if($code->user)
		{
			echo CUFHtml::openCtrlHolder();
			echo CUFHtml::label('User', 'user');
			echo CUFHtml::textField('user', $code->user->name, array('readonly'=>true));
			echo "<p class='formHint2'></p>";
			echo CUFHtml::closeCtrlHolder();
		}
		
		if($code->course)
		{
			echo CUFHtml::openCtrlHolder();
			echo CUFHtml::label('Course', 'course');
			echo CUFHtml::textField('course', $code->course->name, array('readonly'=>true));
			echo "<p class='formHint2'></p>";
			echo CUFHtml::closeCtrlHolder();
		}
	}
}
else
{
	echo CUFHtml::openActiveCtrlHolder($code, 'code');
	echo CUFHtml::activeLabelEx($code, 'code');
	echo CUFHtml::activeTextField($code, 'code', array('maxlength'=>19, 'placeholder'=>'XXXX-XXXX-XXXX-XXXX'));
//	echo "<p class='formHint2'>Type your student code using the following form XXXX-XXXX-XXXX-XXXX.</p>";
	echo "<p class='formHint2'></p>";
	echo CUFHtml::closeCtrlHolder();
}

echo CUFHtml::closeTag('fieldset');

//if($code->id && $code->status == CMDB_USERCODE_UNUSED)
if(controller()->rbac->globalAdmin())
	showSubmitButton('Continue');
else if(!$code->id)
	showSubmitButton('Continue');

echo CUFHtml::endForm();





