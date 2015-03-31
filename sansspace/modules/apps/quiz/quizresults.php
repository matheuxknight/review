<?php

function showQuizResults($user, $object)
{
	$quizstatuses = getdbolist('QuizUserStatus', "quizid=$object->id and userid=$user->id");
	$quiz = getdbosql('Quiz', "quizid=$object->id");

	echo "<h3>Quiz Report for $object->name</h3>";
	echo "<table class='dataGrid'>";
	echo "<tr>";
	echo "<th>".l('Name', array('teacherreport/', 'id'=>$object->id, 'sort'=>'name'))."</th>";
	echo "<th>".l('Date', array('teacherreport/', 'id'=>$object->id, 'sort'=>'date'))."</th>";
	echo "<th>".l('Duration', array('teacherreport/', 'id'=>$object->id, 'sort'=>'duration'))."</th>";
	echo "<th>".l('Status', array('teacherreport/', 'id'=>$object->id, 'sort'=>'status'))."</th>";
	echo "<th>".l('Progress', array('teacherreport/', 'id'=>$object->id, 'sort'=>'progress'))."</th>";
	echo "<th></th>";
	echo "</tr>";
	
	$questioncount = getdbocount('QuizQuestion',"quizid={$quiz->quizid}");
	//QuizQuestion::model()->count("quizid={$quiz->quizid}");
	
	foreach($quizstatuses as $status)
	{
		echo "<tr class='ssrow'>";
		echo "<td>".l($status->user->name, array('quiz/report', 'id'=>$status->id))."</td>";
		echo "<td nowrap>".datetoa($status->started)."</td>";
		echo "<td nowrap>".sectoa($status->duration)."</td>";
		echo "<td>{$status->statusText}</td>";

		echo "<td>";
		if($status->status == CMDB_QUIZSTATUS_STARTED)
			echo "{$status->currentquestion}/{$questioncount}";
		echo "</td>";
		
		echo "<td>";

		echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
			'submit'=>array('quiz/deletestatus'),
			'params'=>array('command'=>'delete', 'id'=>$status->id),
			'confirm'=>"Are you sure you want to delete this quiz status?",
			'title'=>'Delete this Status'));
		
		echo "</td>";
		echo "</tr>";
	}
	
	echo "<tr>";
	echo "<th>Total:</th>";
	echo "<th></th>";
	echo "<th></th>";
	echo "<th></th>";
	echo "<th></th>";
	echo "<th></th>";
	echo "</tr>";
	
	echo "</table>";
	echo "<br/>";

	
}




