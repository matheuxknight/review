<?php

$course = getContextCourse();

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

$list = getdbolist('Survey', "objectid=$object->id order by displayorder");
$count = count($list);

echo "<p>Survey Results - $count questions</p>";

foreach($list as $survey)
{
	echo "<div style='background-color: #fff; padding: 10px; border: 2px solid #d5d5d5; border-radius: 5px;'>";
	
	if($course)
		$totalcount = getdbocount('SurveyAnswer', "surveyid=$survey->id and courseid=$course->id");
	else
		$totalcount = getdbocount('SurveyAnswer', "surveyid=$survey->id");
	
	$essays = getdbolist('SurveyAnswer', "surveyid=$survey->id and courseid=$course->id");
	$options = getdbolist('SurveyOption', "surveyid=$survey->id order by id");
	$users = getdbolist('User');
	
	echo "<p>Question: $survey->question<br>";
	echo "Total Answers: $totalcount<br>";
	echo "Question Type: $survey->answertypeText</p><hr>";
	
	echo "<table cellspacing=0><tr>";
	
	if($survey->answertypeText === 'Text'){
		foreach($essays as $essay){	
			foreach($users as $user){
				if($essay->userid === $user->id){
					$name = $user->name;}
			}		
			echo "<tr'><th width=150>$name</th><td>- <i>\"$essay->answertext\"</i></td></tr>";
			}
	}
	else{
		echo "<th width=500>Choices</th>";
		echo "<th width=100>Answer(s)</th>";
		echo "<th></th>";
		echo "</tr>";
		
		foreach($options as $option)
		{
			if($survey->answertype == CMDB_SURVEYTYPE_RANK)
				$extratype = 'and answerrank=0';
			else
				$extratype = '';
				
			if($course)
				$extracourse = "and courseid=$course->id";
			else
				$extracourse = "";
				
			$count = getdbocount('SurveyAnswer', "surveyid=$survey->id and optionid=$option->id $extracourse $extratype");
			
			if($totalcount)
				$percent = round($count*100/$totalcount, 2);
			else
				$percent = '';
			
			echo "<tr class='ssrow'>";
			
			echo "<td>";
			echo "$option->value";
			
			if($option->fileid)
			{
				switch($option->file->filetype)
				{
					case CMDB_FILETYPE_IMAGE:
						echo img(fileUrl($option->file));
						break;
				
					case CMDB_FILETYPE_MEDIA:
						echo getMiniPlayer($option->file);
						break;
				}
			}
			
			echo "</td>";
			
			echo "<td>$count</td>";
			
			echo "<td align=right>{$percent}%</td>";
			echo "</tr>";
		}
	}
	echo "</table>";
	echo "</div><br>";
}





