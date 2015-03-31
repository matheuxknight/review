<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

echo "<h3>Edit Quiz</h3>";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($quiz);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#properties-tabs');

echo "<div id='properties-tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Questions</a></li>";
echo "<li><a href='#tabs-2'>Options</a></li>";
echo "<li><a href='#tabs-3'>Attempts</a></li>";
echo "<li><a href='#tabs-4'>Time Limit</a></li>";
echo "<li><a href='#tabs-5'>Feedback</a></li>";
echo "</ul><br>";

echo "<div id='tabs-1'>";

$list = getdbolist('QuizQuestionEnrollment', "quizid=$quiz->quizid and clozeid=0 order by displayorder");

echo "<table id='maintable' class='dataGrid2'>";
echo "<thead class='ui-widget-header'><tr>";

echo "<th>ID</th>";
echo "<th>Question</th>";
echo "<th>Bank</th>";
echo "<th>Type</th>";
echo "<th>Grade</th>";
//echo "<th>TimeLimit</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($list as $qqe)
{
	$model = $qqe->question;
	$bank = $model->bank;
	
	$name = empty($model->name)? getTextTeaser($model->question, 60): $model->name;
	echo "<tr id='qqe_$qqe->id' class='ssrow'>";

	echo "<td><b><a href='/question/update?id=$model->id' target=_blank>$model->id</a></b></td>";
	echo "<td><b><a href='/question/update?id=$model->id' target=_blank>$name</a></b></td>";
	echo "<td><a href='/question/admin?id=$bank->id' target=_blank>$bank->name</a></td>";
	
	echo "<td nowrap>$model->answerTypeText</td>";

	echo $model->answertype != CMDB_QUIZQUESTION_NONE && $model->answertype != CMDB_QUIZQUESTION_CLOZE? 
		"<td>$model->grade</td>": '<td></td>';

//	echo "<td>$model->timelimit</td>";

	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
			'submit'=>'',
			'params'=>array('command'=>'removeqqe','id'=>$qqe->id),
			'confirm'=>"Are you sure to remove this question?"));
	
	echo "</td>";

	if($model->answertype == CMDB_QUIZQUESTION_CLOZE)
	{
		$list2 = getdbolist('QuizQuestionEnrollment', "quizid=$quiz->quizid and clozeid=$model->id order by displayorder");
		foreach($list2 as $qqe)
		{
			$model = $qqe->question;
			$bank = $model->bank;
			
			$name = empty($model->name)? getTextTeaser($model->question, 60): $model->name;
			echo "<tr style='background-color:#eeeeee' id='qqe_$qqe->id' class='ssrow'>";
		
			echo "<td><b><a href='/question/update?id=$model->id' target=_blank>$model->id</a></b></td>";
			echo "<td><b><a href='/question/update?id=$model->id' target=_blank>$name</a></b></td>";
			echo "<td><a href='/question/admin?id=$bank->id' target=_blank>$bank->name</a></td>";
			
			echo "<td nowrap>$model->answerTypeText</td>";
		
			echo $model->answertype != CMDB_QUIZQUESTION_NONE? "<td>$model->grade</td>": '<td></td>';
		//	echo "<td>$model->timelimit</td>";
		
			echo "<td></td>";
			echo "</tr>";
		}
	}
		
	echo "</tr>";
}

echo "</tbody></table>";
echo "</div>";

echo "<div id='tabs-2'>";

echo CUFHtml::openActiveCtrlHolder($quiz, 'passthreshold');
echo CUFHtml::activeLabelEx($quiz, 'passthreshold');
echo CUFHtml::activeTextField($quiz, 'passthreshold', array('maxlength'=>200));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($quiz, 'applypenalties');
echo CUFHtml::activeLabelEx($quiz, 'applypenalties');
echo CUFHtml::activeCheckBox($quiz, 'applypenalties', array('class'=>'miscInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($quiz, 'shufflequestion');
echo CUFHtml::activeLabelEx($quiz, 'shufflequestion');
echo CUFHtml::activeCheckBox($quiz, 'shufflequestion', array('class'=>'miscInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($quiz, 'allowback');
echo CUFHtml::activeLabelEx($quiz, 'allowback');
echo CUFHtml::activeCheckBox($quiz, 'allowback', array('class'=>'miscInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($quiz, 'allowvideo');
echo CUFHtml::activeLabelEx($quiz, 'allowvideo');
echo CUFHtml::activeCheckBox($quiz, 'allowvideo', array('class'=>'miscInput'));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

echo "<div id='tabs-3'>";

echo CUFHtml::openActiveCtrlHolder($quiz, 'allowedattempt');
echo CUFHtml::activeLabelEx($quiz, 'allowedattempt');
echo CUFHtml::activeTextField($quiz, 'allowedattempt', array('maxlength'=>200));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($quiz, 'gradingmethod');
echo CUFHtml::activeLabelEx($quiz, 'gradingmethod');
echo CUFHtml::activeDropDownList($quiz, 'gradingmethod', Quiz::model()->gradingMethodOptions);
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

echo "<div id='tabs-4'>";

echo CUFHtml::openActiveCtrlHolder($quiz, 'timelimit');
echo CUFHtml::label('Time Limit', 'quiz_timelimit');

$timelimit = sectoa($quiz->timelimit);
echo CUFHtml::textField('quiz_timelimit', $timelimit, array('maxlength'=>200));

echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($quiz, 'expiredaction');
echo CUFHtml::activeLabelEx($quiz, 'expiredaction');
echo CUFHtml::activeDropDownList($quiz, 'expiredaction', Quiz::model()->expiredActionOptions);
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

echo "<div id='tabs-5'>";

echo CUFHtml::openActiveCtrlHolder($quiz, 'introfeedback');
echo CUFHtml::activeLabelEx($quiz, 'introfeedback');
echo CUFHtml::activeTextArea($quiz, 'introfeedback');
showAttributeEditor($quiz, 'introfeedback', 100, 'custom1');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($quiz, 'completefeedback');
echo CUFHtml::activeLabelEx($quiz, 'completefeedback');
echo CUFHtml::activeTextArea($quiz, 'completefeedback');
showAttributeEditor($quiz, 'completefeedback', 100, 'custom1');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($quiz, 'passfeedback');
echo CUFHtml::activeLabelEx($quiz, 'passfeedback');
echo CUFHtml::activeTextArea($quiz, 'passfeedback');
showAttributeEditor($quiz, 'passfeedback', 100, 'custom1');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($quiz, 'failfeedback');
echo CUFHtml::activeLabelEx($quiz, 'failfeedback');
echo CUFHtml::activeTextArea($quiz, 'failfeedback');
showAttributeEditor($quiz, 'failfeedback', 100, 'custom1');
echo CUFHtml::closeCtrlHolder();

echo "</div>";

//

echo "</div>";

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();

echo <<<END
<script>
		
$(function()
{
	$('#maintable tbody').sortable(
	{
		delay: 300,
		update: function(event, ui)
		{
			var id = ui.item.attr('id').substr(4);
			$(this).children().each(function(i)
			{
				var id2 = $(this).attr('id').substr(4);
				if(id == id2)
					$.get("/quiz/setorder&id="+id+"&order="+i);
			});
		}
	}).disableSelection();
});

</script>

END;






