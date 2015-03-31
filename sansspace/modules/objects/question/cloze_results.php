<?php

$search = isset($_GET['search'])? $_GET['search']: '';
$typestring = CMDB_QUIZQUESTION_SELECT.','.CMDB_QUIZQUESTION_RECORD.','.CMDB_QUIZQUESTION_SHORTTEXT;

$list = getdbolist('QuizQuestion', "answertype in ($typestring) and bankid=$object->id and (name like '%$search%' or question like '%$search%') order by id");

showTableSorter('maintable', '{headers: {6: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";

echo "<th>ID</th>";
echo "<th>Question</th>";
echo "<th>Type</th>";
echo "</tr></thead><tbody>";

foreach($list as $n=>$model)
{
//	$url = "javascript:InsertQuestion($model->id)";
	$name = empty($model->name)? getTextTeaser($model->question, 60): $model->name;

	echo "<tr id='question_$model->id' class='ssrow'>";
//	echo "<td><b><a href='$url' title='Click to insert at cursor position'>$model->id</a></b></td>";
//	echo "<td><b><a href='$url' title='Click to insert at cursor position'>$name</a></b></td>";
	echo "<td><b>$model->id</b></td>";
	echo "<td><b>$name</b></td>";
	echo "<td nowrap>$model->answerTypeText</td>";
	echo "</tr>";
}

echo "</tbody></table>";
echo "<br/>";










