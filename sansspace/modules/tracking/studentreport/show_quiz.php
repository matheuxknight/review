<?php

$object = getdbo('Object', getparam('id'));
$quiz = getdbosql('Quiz', "quizid=".getparam('id'));

$this->pageTitle = app()->name ." - ". $object->name;

$attemptid = getparam('attemptid');
$questionid = getparam('questionid');
$number = getparam('number');

if($attemptid)
{
	$attempt = getdbo('QuizAttempt', $attemptid);
	$user = $attempt->user;
}
else
{
	$userid = getparam('userid');
	if(!$userid) $userid = userid();
	
	$user = getdbo('User', $userid);
}

$isteacher = false;
if(controller()->rbac->objectUrl($object, 'teacherreport'))
	$isteacher = true;

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

if($isteacher)
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
		//	$_GET['startpos'] = $select->startpos;
			echo getMiniPlayer($file);
			break;
			
		default:
			echo l($file->name, array('file/', 'id'=>$file->id));
	}
}

function saveAnswerFeedback($quiz, $question, $attempt, $answer, $number)
{
//	debuglog($_POST);
	if(isset($_POST['QuizAttemptAnswer']))
	{
		$answer->result = $_POST['QuizAttemptAnswer']['result'] * $question->grade / 100;
		$answer->comment = $_POST['QuizAttemptAnswer']['comment'];
	//	debuglog("save $answer->id $answer->result $answer->comment");
		$answer->save();
			
		QuizAutoCorrection($quiz, $attempt);
		controller()->redirect(array('studentreport/', 'id'=>$quiz->quizid, 'attemptid'=>$attempt->id, 'number'=>$number));
	}
}

if($attemptid && $questionid)
{
	$question = getdbo('QuizQuestion', $questionid);
//	$attempt = getdbo('QuizAttempt', $attemptid);
//	$duration = sectoa($attempt->duration);

	$name = empty($question->name)? getTextTeaser($question->question, 512): $question->name;
	$url = "/studentreport?id=$object->id&attemptid=$attempt->id&number=$number";

	echo "<a href='$url'><b>Back to attempt</b></a>";
	echo CUFHtml::beginForm();
	
	echo "<br><table class='dataGrid'>";
	echo "<thead><tr>";
	echo "<th width=160></th>";
	echo "<th></th>";

	if($question->answertype == CMDB_QUIZQUESTION_MATCHING)
	{
		echo "<th></th>";
		echo "<th></th>";
	}
	
	echo "</tr></thead><tbody>";
	$file = null;
	
	switch($question->answertype)
	{
		case CMDB_QUIZQUESTION_SHORTTEXT:
			$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attemptid and questionid=$question->id");
			if(!$answer)
			{
				$answer = new QuizAttemptAnswer;
				$answer->attemptid = $attempt->id;
				$answer->questionid = $question->id;
			}
						
			saveAnswerFeedback($quiz, $question, $attempt, $answer, $number);
			$shorttexts = getdbolist('QuizQuestionShortText', "questionid=$question->id");
			if($name == null)
				echo "<tr><td>Question:</td><td>#$question->id</td></tr>";
			else
				echo "<tr><td>Question:</td><td>$name</td></tr>";
			echo "<tr><td>Question Type:</td><td>$question->answerTypeText</td></tr>";
			
			echo "<tr><td>Answer:</td><td><b>$answer->answershort</b></td></tr>";
			
			if($isteacher)
				foreach($shorttexts as $n=>$st)
				{
					$i = $n+1;
					echo "<tr><td>Possible Answer $i:</td><td>$st->value ($st->valid)</td></tr>";
				}
			
			 
			echo "<tr><td>Result:</td><td>";
			
			if(controller()->rbac->objectUrl($object, 'teacherreport'))
			{
				$answer->result /= $question->grade/100;
				echo CUFHtml::activeTextField($answer, 'result');
				echo " (0-100) ";
			}
			else
				echo "$answer->result";
				
			echo "</td></tr>";
			break;
	
		case CMDB_QUIZQUESTION_SELECT:
			$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attemptid and questionid=$question->id");
			if(!$answer)
			{
				$answer = new QuizAttemptAnswer;
				$answer->attemptid = $attempt->id;
				$answer->questionid = $question->id;
			}
						
			saveAnswerFeedback($quiz, $question, $attempt, $answer, $number);
			$selects = getdbolist('QuizQuestionSelect', "questionid=$question->id");
			
			$answerresult = $answer->result;
			$select = $answer->answerselect;
			
			echo "<tr><td>Question:</td><td>$name</td></tr>";
			echo "<tr><td>Question Type:</td><td>$question->answerTypeText</td></tr>";

			if($isteacher)
				foreach($selects as $n=>$s)
				{
					$i = $n+1;
					echo "<tr><td>Option $i:</td><td>";
					
					if($s->file) showFile($s->file);
						if($s->valid > 0)
							echo " $s->value (Correct - $s->valid points) ";	
						else
							echo " $s->value (Incorrect)";
					
					echo "</td></tr>";
				}
				
			echo "<tr><td><b>Selected Answer:</b></td><td><b>";
			
			echo $select->value;
			if($select->file) showFile($select->file);
	
			echo "</b></td></tr>";	
				
			echo "<tr><td>Result:</td><td>";
			
			if(controller()->rbac->objectUrl($object, 'teacherreport'))
			{
				$answer->result /= $question->grade/100;
				echo CUFHtml::activeTextField($answer, 'result');
				echo " (0-100) ";
			}
			else
				echo "$answer->result / $question->grade";
				
			echo "</td></tr>";
			break;
	
		case CMDB_QUIZQUESTION_MATCHING:
			echo "<tr><td>Question:</td><td colspan=3>$name</td></tr>";
			echo "<tr><td>Question Type:</td><td colspan=3>$question->answerTypeText</td></tr><tr style='height:25px'></tr>";
	
			$count = getdbocount('QuizQuestionMatching', "questionid=$question->id");
			$answers = getdbolist('QuizAttemptAnswer', "attemptid=$attemptid and questionid=$question->id");
			
			$result = 0;
			foreach($answers as $answer)
			{
				$result += $answer->result;
				
				$matching1 = getdbo('QuizQuestionMatching', $answer->answermatchingid1);
				$matching2 = getdbo('QuizQuestionMatching', $answer->answermatchingid2);
				
				echo "<tr><td>Matched:</td>";
				
				echo "<td>";
				echo "$matching1->value1 - $matching2->value2";
				if($matching1->file1) showFile($matching1->file1);
				echo "</td>";
				
				//if($isteacher)
				//{
				//	echo "<td>";
				//	echo $matching2->value2;
				//	if($matching2->file2) showFile($matching2->file2);
				//	echo "</td>";
				//}
				//else
				//	echo "<td></td>";
				
				echo "<tr><td>Result:</td><td>";
			
			if($answer->result > 0)
				$answer->result = 'Correct';
			else
				$answer->result = 'Incorrect';
		
			echo "<b>$answer->result</b>";
				
			echo "</td></tr><tr style='height:25px'></tr>";
			
			}
			
			$answerresult = round($result / $count);
			echo "<hr><tr><td><b>Final Result:</b></td><td><b>$answerresult %</b></td></tr>";
			saveAnswerFeedback($quiz, $question, $attempt, $answer, $number);
			break;

		case CMDB_QUIZQUESTION_LONGTEXT:
			$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attemptid and questionid=$question->id");
			if(!$answer)
			{
				$answer = new QuizAttemptAnswer;
				$answer->attemptid = $attempt->id;
				$answer->questionid = $question->id;
			}
						
			saveAnswerFeedback($quiz, $question, $attempt, $answer, $number);
			
			echo "<tr><td>Question:</td><td>$name</td></tr>";
			echo "<tr><td>Question Type:</td><td>$question->answerTypeText</td></tr>";
	
			echo "<tr><td>Result:</td><td>";
				
			if(controller()->rbac->objectUrl($object, 'teacherreport'))
			{
				$answer->result /= $question->grade/100;
				echo CUFHtml::activeTextField($answer, 'result');
				echo " (0-100) ";
			}
			else
				echo "$answer->result / $question->grade";
					
			echo "</td></tr>";
			echo "<tr><td valign=top>Answer:</td><td>$answer->answerlong</td></tr>";
			
			if($answer && $answer->answerfile)
				$file = $answer->answerfile;
			
			break;
			
		case CMDB_QUIZQUESTION_COMPARATIVE:
		case CMDB_QUIZQUESTION_RECORD:
		//	debuglog("attemptid=$attempt->id and questionid=$question->id");
			$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attemptid and questionid=$question->id");
			if(!$answer)
			{
				$answer = new QuizAttemptAnswer;
				$answer->attemptid = $attempt->id;
				$answer->questionid = $question->id;
			}
			
			saveAnswerFeedback($quiz, $question, $attempt, $answer, $number);
			
			echo "<tr><td>Question:</td><td>$name</td></tr>";
			echo "<tr><td>Question Type:</td><td>$question->answerTypeText</td></tr>";
		
			echo "<tr><td>Result:</td><td>";
			
			if(controller()->rbac->objectUrl($object, 'teacherreport'))
			{
				$answer->result /= $question->grade/100;
				echo CUFHtml::activeTextField($answer, 'result');
				echo " (0-100) ";
			}
			else
				echo "$answer->result / $question->grade";
			
			echo "</td></tr>";
				
			if($answer && $answer->answerfile)
				$file = $answer->answerfile;
			
			break;
	}

	if($answer)
	{
		echo "<tr><td>Comment:</td><td>";
		
		if(controller()->rbac->objectUrl($object, 'teacherreport'))
		{
			echo CUFHtml::activeTextArea($answer, 'comment');
			showAttributeEditor($answer, 'comment', 160, 'custom1');
		}
		else
			echo "$answer->comment";
		
		echo "</td></tr>";
	}
	
	echo "</table>";
		
	if(controller()->rbac->objectUrl($object, 'teacherreport'))
		showSubmitButton('Save');
	
	echo CUFHtml::endForm();
	
	if($file)
	{
		//echo "<br>Attached File: ";
		
		//echo objectImage($file, 22) . ' ' . l($file->name, array('file/', 'id'=>$file->id));
		$duration = sectoa($file->duration/1000);
		//if($file->duration) echo " ($duration)";

		switch($file->filetype)
		{
			case CMDB_FILETYPE_IMAGE:
				echo '<br><br>'.img(fileUrl($file));
				break;
		
			case CMDB_FILETYPE_MEDIA:
				echo "<br><br><div style='width:66%'>";
//				showMediaContent($file);
                ?>
                <div id="AudioReview"></div>
                <link href="/sansspace/ui/css/audio-review.css" type="text/css" rel="stylesheet" />
                <script src="/bower_components/underscore/underscore-min.js"></script>
                <script src="/sansspace/ui/js/audio-review.js"></script>
                <script>
                    $(document).ready(function(){
                        AudioReview.init('#AudioReview', <?= $file->id ?>, 'teacher');
                    });
                </script>
                <?php
				echo "</div>";
				break;
					
			default:
		}
	}
}

else if($attemptid)
{
	$duration = sectoa($attempt->duration);
	$result = $attempt->status==CMDB_QUIZATTEMPT_PASSED||$attempt->status==CMDB_QUIZATTEMPT_FAILED?
		round($attempt->result, 2).' %': '';
	
	echo "<br><table class='dataGrid'>";
	echo "<thead><tr>";
	echo "<th width=200>Quiz Results</th>";
	echo "<th></th>";
	echo "</tr></thead><tbody>";
	
	echo "<tr><td>Started:</td><td><b>$attempt->started</b></td></tr>";
	echo "<tr><td>Duration:</td><td><b>$duration</b></td></tr>";
	echo "<tr><td>Quiz Status:</td><td><b>$attempt->statusText</b></td></tr>";
	echo "<tr><td>Result:</td><td><b>$result</b></td></tr>";
	echo "</table>";
	
	echo "<br><table class='dataGrid'>";
	echo "<thead><tr>";
	echo "<th>Question #</th>";
	echo "<th>Question Type</th>";
	echo "<th>Evaluation</th>";
	echo "<th>Answer</th>";
	echo "<th>Comment</th>";
	echo "<th align=left>Grade</th>";
	echo "<th align=left>Total Possible Points</th>";
	echo "</tr></thead><tbody>";
	
	$total_result = 0;
	$total_grade = 0;
	
	$list = getdbolist('QuizQuestionEnrollment', "quizid=$object->id order by displayorder");
	foreach($list as $e)
	{
		$question = $e->question;
		if($question->answertype == CMDB_QUIZQUESTION_CLOZE) continue;
		
		$name = empty($question->name)? getTextTeaser($question->question, 60): $question->name;
		$url = "/studentreport?id=$object->id&attemptid=$attemptid&questionid=$question->id&number=$number";
		
		$hasanswer = false;
		$answerresult = '';
		$correction = 'Manual';
		
		switch($question->answertype)
		{
			case CMDB_QUIZQUESTION_SHORTTEXT:
				$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attemptid and questionid=$question->id");
				$hasanswer = $answer? !empty($answer->answershort): false;
				$answerresult = $answer->result;
				//if($answerresult == null){$answerresult = 0;}
				$correction = 'Auto';
				break;
				
			case CMDB_QUIZQUESTION_SELECT:
				$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attemptid and questionid=$question->id");
				$hasanswer = $answer? !empty($answer->answerselectid): false;
				$answerresult = $answer->result;
				$correction = 'Auto';
				break;
				
			case CMDB_QUIZQUESTION_MATCHING:
				$result = 0;

				$count = getdbocount('QuizQuestionMatching', "questionid=$question->id");
				$answers = getdbolist('QuizAttemptAnswer', "attemptid=$attemptid and questionid=$question->id");
				$hasanswer = count($answers)!=0;
				
				foreach($answers as $answer)
					$result += $answer->result;
				
				$answerresult = round($result / $count);
				$correction = 'Auto';
				break;
				
			case CMDB_QUIZQUESTION_COMPARATIVE:
			case CMDB_QUIZQUESTION_RECORD:
			case CMDB_QUIZQUESTION_LONGTEXT:
				$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attemptid and questionid=$question->id");
				$hasanswer = $answer? !empty($answer->answerlong) || $answer->answerfileid: false;
				$answerresult = $answer->result!=null? $answer->result: 'pending';
				break;
				
			case CMDB_QUIZQUESTION_NONE:
			case CMDB_QUIZQUESTION_CLOZE:
				$correction = '';
				break;
		}
		
		$hascomment = $answer? !empty($answer->comment): false;
		
		echo "<tr class='ssrow'>";
		echo "<td><a href='$url'><b>#$question->id $name</b></a></td>";
		echo "<td nowrap>$question->answerTypeText</td>";
		echo "<td>$correction</td>";
		echo "<td>".Booltoa($hasanswer)."</td>";
		echo "<td>".Booltoa($hascomment)."</td>";
		echo "<td align=left>$answerresult</td>";
		echo "<td align=left>$question->grade</td>";
		echo "</tr>";
		
		if(isset($answer) && $answer->answerfileid)
		{
			$file = $answer->answerfile;
			$duration = sectoa($file->duration/1000);
			echo "<tr class='ssrow'>";
			echo "<td colspan=7>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo objectImage($file, 22) . ' ' .$file->name;
			if($file->duration) echo " ($duration)</td>";
			echo "</tr>";
		}
		
		$total_result += $answerresult;
		$total_grade += $question->grade;
	}

	$total_question = count($list);
	
	echo "<tr>";
	echo "<td><b>Total for $total_question questions:</b></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td align=left><b>$total_result</b></td>";
	echo "<td align=left><b>$total_grade</b></td>";
	echo "</tr>";
	
	echo "</tbody></table>";
}

else
{
	echo "<br><table class='dataGrid'>";
	echo "<thead class=''>";
	
	echo "<tr>";
	echo "<th>Attempt</th>";
	echo "<th>Duration</th>";
	echo "<th>Status</th>";
	echo "<th>Result</th>";
	echo "<th>Files</th>";
	echo "<th></th>";
	echo "</tr>";
	echo "</thead><tbody>";
	
	$courseid = getparam('courseid');
	if($courseid)
		$extracourse = "and courseid=$courseid";
	else
		$extracourse = "";
		
	$list = getdbolist('QuizAttempt', "quizid=$object->id and userid=$user->id $extracourse order by id");
	foreach($list as $i=>$attempt)
	{
		$number = $i+1;
		
		$duration = sectoa($attempt->duration);
		$result = $attempt->result===null? '': round($attempt->result, 2).' %';
		$url = "/studentreport?id=$object->id&attemptid=$attempt->id&number=$number";
		
		// TODO:
		$filecount = getdbocount('QuizAttemptAnswer', "attemptid=$attempt->id and answerfileid");
		
		echo "<tr class='ssrow'>";
		echo "<td><a href='$url'><b>#$number - $attempt->started</b></a></td>";
		echo "<td>$duration</td>";
		echo "<td>$attempt->statusText</td>";
		echo "<td>$result</td>";
		echo "<td>$filecount</td>";
		
		echo "<td>";
		
		if(controller()->rbac->objectUrl($object, 'teacherreport'))
			echo "<a href='javascript:delete_attempt($attempt->id)' title='Delete this attempt'>".mainimg('16x16_delete.png')."</a>";
		
		echo "</td>";
		echo "</tr>";
	}

	$avgresult = round(dboscalar("select avg(result) from QuizAttempt where quizid=$quiz->quizid and userid=$user->id $extracourse and result is not null"), 2);
	$avgtime = sectoa(dboscalar("select avg(duration) from QuizAttempt where quizid=$quiz->quizid and userid=$user->id $extracourse"));
	
	echo "<tr>";
	echo "<td><b>Average:</b></td>";
	echo "<td>$avgtime</td>";
	echo "<td></td>";
	echo "<td>$avgresult %</td>";
	
	echo "<td></td>";
	echo "</tr>";
	
	echo "</tbody></table>";
}

echo '<br><br>';

if(controller()->rbac->objectUrl($object, 'teacherreport'))
	echo <<<end
<script>

function delete_attempt(id)
{
	if(confirm('Are you sure you want to delete this attempt?'))
		window.location.href='/quiz/deleteattempt?id='+id;
}

</script>

end;





