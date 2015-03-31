<?php

$course = $status->course;

showNavigationBar($course->parent);
showHeaderReport($status->user, 'Courses');
showObjectHeader($course);
showObjectMenu($course->object);

echo "Started: ".datetoa($status->started)."<br>";
echo "Duration: ".sectoa($status->duration)."<br>";
echo "Status: {$status->statusText}<br><br>";

$questions = getdbolist('QuizQuestion', array('condition'=>"quizid=$course->id", 'order'=>'number'));
//QuizQuestion::model()->findAll(array(
//	'condition'=>"quizid=$course->id", 'order'=>'number'));

echo "<table class='dataGrid'>";
echo "<tr>";
echo "<th>Question</th>";
echo "<th>Answered</th>";
echo "<th>Correction</th>";
echo "</tr>";

foreach($questions as $q)
{
	$a = getdbosql('QuizUserAnswer', "questionid={$q->id} and quizstatusid={$status->id}");
	//QuizUserAnswer::model()->find("questionid={$q->id} and quizstatusid={$status->id}");
	
	echo "<tr class='ssrow'>";
	echo "<td>Question #{$q->number}</td>";
	
	if($a)
		echo "<td>".mainimg('green-check.png')."</td>";
	else
		echo "<td></td>";
		
	echo "<td></td>";
	echo "</tr>";
}

echo "<tr>";
echo "<th></th>";
echo "<th></th>";
echo "<th></th>";
echo "</tr>";

echo "</table>";
echo "<br/>";



