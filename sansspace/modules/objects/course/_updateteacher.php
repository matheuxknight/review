<?php

$this->widget('UniForm');

echo CUFHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data'));
echo CUFHtml::errorSummary($course);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($course, 'name');
echo CUFHtml::activeLabelEx($course, 'name');
echo CUFHtml::activeTextField($course, 'name', array('maxlength'=>55));
echo "<p class='formHint2'>Create a unique name for your course.<br>Consider your naming convention if you plan to create more than one course. </p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($course, 'startdate');
echo CUFHtml::activeLabelEx($course, 'startdate');

if(!$update || time() < strtotime($course->startdate))
	showDatetimePicker($course, 'startdate');
else
	echo CUFHtml::activeTextField($course, 'startdate', array('readonly'=>true));

echo "<p class='formHint2'>Your students will not be able to enroll in your course until this start date. Courses will be active for one year from this date.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($course, 'enddate');
echo CUFHtml::activeLabelEx($course, 'enddate');
echo CUFHtml::activeTextField($course, 'enddate', array('readonly'=>true));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

echo <<<end
<script>

$(function()
{
	$('#VCourse_startdate').change(function()
	{
		var d1 = this.value.match(/^(\d{4})\-/);
		var d2 = parseInt(d1[1]);
		
		var s = this.value.replace(/^(\d{4})\-/, d2+1+'-');
		$('#VCourse_enddate').val(s);
	});
});

</script>
end;








