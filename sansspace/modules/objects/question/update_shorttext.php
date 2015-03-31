<?php

$answers = getdbolist('QuizQuestionShortText', "questionid=$question->id order by id");

echo CUFHtml::openCtrlHolder();
echo "<table class='dataGrid'><tr>";
echo "<th width=120>Valid (0-100)</th>";
echo "<th width=100>Answer</th>";
echo "<th></th>";
echo "</tr>";

if(!count($answers))
	echo "<tr><td colspan=3><i>-none-</i></td></tr>";

else foreach($answers as $answer)
{
	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_valid", $answer->valid);
	echo CUFHtml::hiddenField("QuizAnswer_{$answer->id}_value", $answer->value);
	
	echo "<tr class='ssrow' onclick='load_shorttext_item($answer->id)'>";

	echo "<td>$answer->valid</td>";
	echo "<td>$answer->value</td>";
	
	echo "<td>";
	echo l(mainimg('16x16_delete.png'), array('deleteshorttext', 'id'=>$answer->id), array('title'=>'Delete this answer'));
	echo "</td>";
	
	echo "</tr>";
}

$shorttext = new QuizQuestionShortText;
$shorttext->valid = 100;

echo "<tr><td colspan=6><br><b><span id='add_new_message'>add new</span></b></td></tr>";
echo "<tr>";

echo "<td valign=top>".CUFHtml::activeTextField($shorttext, 'valid', array('style'=>'width: 60px;'))."</td>";
echo "<td>".CUFHtml::activeTextField($shorttext, 'value', array('style'=>'width: 240px;'))."</td>";

echo CUFHtml::activeHiddenField($shorttext, 'id');
echo CUFHtml::activeHiddenField($question, 'id');

echo "<td></td>";
echo "</tr>";

echo "</table>";

echo CUFHtml::closeCtrlHolder();
echo <<<END
<script>

$(function()
{
	$('#QuizQuestionShortText_id').val(0);
	$('#QuizQuestionShortText_value').focus().val('');
});

function load_shorttext_item(id)
{
	$('#QuizQuestionShortText_id').val(id);
	$('#QuizQuestionShortText_valid').val($('#QuizAnswer_'+id+'_valid').val());
	$('#QuizQuestionShortText_value').val($('#QuizAnswer_'+id+'_value').val());
	
	$('#add_new_message').html('modify');
}

</script>
END;








