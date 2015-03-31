<?php

echo "<p>Use the following syntax to embed questions in the text with the question id.</p>";
echo "<code>The capital of Spain is {377} and the capital of Japan is {378}.</code><br>";
echo "<p>You can use short text, multiple choice and recording types of question.</p>";

echo "<table cellspacing=10 width='100%'><tr><td valign=top width='50%'>";

echo CUFHtml::openActiveCtrlHolder($question, 'cloze');
echo CUFHtml::activeTextArea($question, 'cloze');
showAttributeEditor($question, 'cloze', 180, 'custom4');
echo CUFHtml::closeCtrlHolder();

$b = preg_match_all('/{(\d+)}/', $question->cloze, $matches);
if($b)
{
	echo "<p>Embedded questions:</p>";

	echo "<table id='maintable' style='width:640px;' class='dataGrid2'>";
	echo "<thead class='ui-widget-header'><tr>";

	echo "<th>ID</th>";
	echo "<th>Question</th>";
	echo "<th>Type</th>";
	echo "</tr></thead><tbody>";

	foreach($matches[1] as $qid)
	{
		$model = getdbo('QuizQuestion', $qid);
			
		$url = array('update', 'id'=>$model->id);
		$name = empty($model->name)? getTextTeaser($model->question, 60): $model->name;
			
		echo "<tr id='question_$model->id' class='ssrow'>";
			
		echo "<td><b><a href='/question/update?id=$model->id' target=_blank>$model->id</a></b></td>";
		echo "<td><b>".l($name, $url, array('target'=>'_blank'))."</b></td>";
		echo "<td nowrap>$model->answerTypeText</td>";

		echo "</tr>";
	}

	echo "</tbody></table>";
	echo "<br/>";
}

echo "</td><td valign=top width='50%'>";

echo "Search: <input id='bank_search_input' class='' ></input>";

echo "<div id='admin_results' style='width:100%;height:600px;overflow-y:auto;overflow-x:hidden;'></div>";
echo "</td></tr></table>";

echo <<<end
<script>

$(function()
{
	$.get('/question/cloze_results?id=$object->id', '', function(data)
	{
		$('#admin_results').html(data);
	});

	$('#bank_search_input').bind('keyup', function(event)
	{
		var searchstring = $('#bank_search_input').val();
		$.get('/question/cloze_results?id=$object->id&search='+searchstring, '', function(data)
		{
			$('#admin_results').html(data);
		});
	})
})

// function InsertQuestion(id)
// {
// 	insertTextInTextarea('QuizQuestion_cloze', '{'+id+'}');
// }

</script>
end;



