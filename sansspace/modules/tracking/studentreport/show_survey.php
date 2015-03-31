<?php

$object = getdbo('Object', getparam('id'));
$this->pageTitle = app()->name ." - ". $object->name;

$surveyid = getparam('surveyid');

$userid = getparam('userid');
if(!$userid) $userid = userid();

$user = getdbo('User', $userid);
$course = getContextCourse();

if(!$course)
{
	debuglog("no related course");
	return;
}

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

if(controller()->rbac->objectUrl($object, 'teacherreport'))
	showUserHeader($user, $user->name, "/studentreport?id=$object->id&userid=$user->id");

//////////////////////////////////////////////////

function showFile($file)
{
	switch($file->filetype)
	{
		case CMDB_FILETYPE_IMAGE:
			echo img(fileUrl($file));
			break;
	
		case CMDB_FILETYPE_MEDIA:
			echo getMiniPlayer($file);
			break;
	}
}

echo "<br><table class='dataGrid'>";
echo "<thead><tr>";
echo "<th>Question</th>";
echo "<th>Type</th>";
echo "</tr></thead><tbody>";

$list = getdbolist('Survey', "objectid=$object->id order by displayorder");
foreach($list as $survey)
{
	$name = getTextTeaser($survey->question, 80);

	echo "<tr class='ssrow'>";
	echo "<td><b>$name</b></td>";
		
	switch($survey->answertype)
	{
		case CMDB_SURVEYTYPE_TEXT:
			$answer = getdbosql('SurveyAnswer', "surveyid=$survey->id and userid=$user->id and courseid=$course->id");

			echo "<td nowrap>$survey->answerTypeText</td>";
			echo "</tr>";
				
			echo "<tr><td colspan=2 style='padding-left: 20px;'>$answer->answertext</td></tr>";
			break;
				
		case CMDB_SURVEYTYPE_SELECT:
		case CMDB_SURVEYTYPE_RANK:
			
			if($survey->answertype == CMDB_SURVEYTYPE_RANK)
				echo "<td nowrap>$survey->answerTypeText</td>";
			else if($survey->allowmultiple)
				echo "<td>Multiple Choices</td>";
			else
				echo "<td>One Choice</td>";
				
			echo "</tr>";

			$answers = getdbolist('SurveyAnswer', "surveyid=$survey->id and userid=$user->id and courseid=$course->id order by answerrank");
			foreach($answers as $answer)
			{
				$option = $answer->option;
				if($option->fileid)
				{
					$_GET['startpos'] = $option->startpos;
					echo "<tr><td colspan=3 style='padding-left: 20px;'>";
					showFile($option->file);
					echo "</td></tr>";
				}
				else
	 				echo "<tr><td colspan=3 style='padding-left: 20px;'>$option->value</td></tr>";
			}
 				
			break;
				
		default:
			echo "<td nowrap>$survey->answerTypeText</td>";
			echo "</tr>";
				
			break;
	}
}
	
echo "</tbody></table>";

echo '<br><br>';







