<?php

$search = isset($_GET['search'])? $_GET['search']: '';
$list = getdbolist('QuizQuestion', "bankid=$object->id and (name like '%$search%' or question like '%$search%') order by id");

$quiz = getdbo('Quiz', getparam('quizid'));

showTableSorter('maintable', '{headers: {6: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";

echo "<th width=20></th>";
echo "<th>ID</th>";
echo "<th>Question</th>";
echo "<th>Type</th>";
echo "<th>Grade</th>";
echo "<th>TimeLimit</th>";
echo "</tr></thead><tbody>";

foreach($list as $n=>$model)
{
	if($quiz)
	{
		$enrollment = getdbosql('QuizQuestionEnrollment', "quizid=$quiz->quizid and questionid=$model->id");
		if($enrollment) continue;
	}
	
	$name = empty($model->name)? getTextTeaser($model->question, 60): $model->name;
	echo "<tr id='question_$model->id' class='ssrow'>";
	
	echo "<td>";
	echo CHtml::checkBox("all_questions[$model->id]", false, array('class'=>'all_objects_select'));
	echo "</td>";
	
	echo "<td><b><a href='/question/update?id=$model->id' target=_blank>$model->id</a></b></td>";
	echo "<td><b><a href='/question/update?id=$model->id' target=_blank>$name</a></b></td>";
	echo "<td nowrap>$model->answerTypeText</td>";
	
	echo $model->answertype != CMDB_QUIZQUESTION_NONE? "<td>$model->grade</td>": '<td></td>';
	echo "<td>$model->timelimit</td>";
	
	echo "</tr>";
}

echo "</tbody></table>";








