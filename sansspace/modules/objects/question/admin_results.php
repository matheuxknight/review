<?php

$search = isset($_GET['search'])? $_GET['search']: '';
$list = getdbolist('QuizQuestion', "bankid=$object->id and (name like '%$search%' or question like '%$search%') order by id");

showTableSorter('maintable', '{headers: {6: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";

echo "<th>ID</th>";
echo "<th>Question</th>";
echo "<th>Type</th>";
echo "<th>Grade</th>";
//echo "<th>TimeLimit</th>";
echo "<th>Choices</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($list as $n=>$model)
{
	$url = array('update', 'id'=>$model->id);
	$name = empty($model->name)? getTextTeaser($model->question, 60): $model->name;

	echo "<tr id='question_$model->id' class='ssrow'>";

	echo "<td><b><a href='/question/update?id=$model->id'>$model->id</a></b></td>";
	echo "<td><b>".l($name, $url)."</b></td>";
	echo "<td nowrap>$model->answerTypeText</td>";

	echo $model->answertype != CMDB_QUIZQUESTION_NONE && $model->answertype != CMDB_QUIZQUESTION_CLOZE? "<td>$model->grade</td>": '<td></td>';
//	echo "<td>$model->timelimit</td>";

	switch($model->answertype)
	{
		case CMDB_QUIZQUESTION_SELECT:
			$count = getdbocount('QuizQuestionSelect', "questionid=$model->id");
			echo "<td>$count</td>";
			break;
				
		case CMDB_QUIZQUESTION_SHORTTEXT:
			$count = getdbocount('QuizQuestionShortText', "questionid=$model->id");
			echo "<td>$count</td>";
			break;
				
		case CMDB_QUIZQUESTION_MATCHING:
			$count = getdbocount('QuizQuestionMatching', "questionid=$model->id");
			echo "<td>$count</td>";
			break;
				
	//	case CMDB_QUIZQUESTION_CLOZE:
	//		echo "<td></td>";
	//		break;
				
		default:
			echo "<td></td>";
	}

	echo "<td><a href='javascript:delete_question($model->id)' title='Delete this question'>".
		mainimg('16x16_delete.png')."</a></td>";
	
	echo "</tr>";
}

echo "</tbody></table>";
echo "<br/>";










