<?php

function QuizQuestionClozeUpdateEmbedded($quiz, $question)
{
	$b = preg_match_all('/{(\d+)}/', $question->cloze, $matches);
	if(!$b)
	{
		// answers???
		dborun("delete from QuizQuestionEnrollment where quizid=$quiz->quizid and clozeid=$question->id");
		return;
	}

	$list = getdbolist('QuizQuestionEnrollment', "quizid=$quiz->quizid and clozeid=$question->id");
	foreach($list as $qqe)
	{
		$found = array_search($qid, $matches[1]);
		if($found === false)
			$qqe->delete();
	}
	
	foreach($matches[1] as $qid)
	{
		$qqe = getdbosql('QuizQuestionEnrollment', "quizid=$quiz->quizid and questionid=$qid and clozeid=$question->id");
		if(!$qqe)
		{
			// add it
			$qqe = new QuizQuestionEnrollment;
			$qqe->quizid = $quiz->quizid;
			$qqe->questionid = $qid;
			$qqe->clozeid = $question->id;
			$qqe->displayorder = 0;
			$qqe->save();
		}
	}
}

function QuizAutoCorrection($quiz, $attempt)
{
	$list = getdbolist('QuizQuestionEnrollment', "quizid=$quiz->quizid");
	foreach($list as $e)
	{
		$question = getdbo('QuizQuestion', $e->questionid);
		
		if(	$question->answertype == CMDB_QUIZQUESTION_NONE ||
			$question->answertype == CMDB_QUIZQUESTION_CLOZE)
			continue;

		switch($question->answertype)
		{
			case CMDB_QUIZQUESTION_SHORTTEXT:
				$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
				if(!$answer) continue;

				//$answer->result = 0;
				$lista = getdbolist('QuizQuestionShortText', "questionid=$question->id");

				foreach($lista as $a)
				{
					if(strtolower($answer->answershort) == strtolower($a->value)){
							$answer->result = $a->valid * $question->grade / 100;
							$answer->save();
							}
					if($answer->result > 0){
							$answer->save();
							}
					else{
						$answer->result = 0;
						$answer->save();
							}
				}
				
				//if($answer->result == 0 && !empty($answer->answershort) && $quiz->applypenalties)
				//	$answer->result = -$question->penalty * $question->grade / 100;

				//$answer->save();
				break;

			case CMDB_QUIZQUESTION_SELECT:
				$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
				if(!$answer) continue;
				
				//$answer->result = 0;
					
				$lista = getdbolist('QuizQuestionSelect', "questionid=$question->id");
				
				
				foreach($lista as $a) 
					{	
						if($answer->result > 0){
							$answer->save();
							}
						elseif($answer->answerselectid == $a->id){
							$answer->result = $a->valid * $question->grade / 100;
							$answer->save();
							}
						elseif($answer->answerselectid == NULL){
							$answer->result = 0;
							$answer->save();
							}
						else{
							$answer->result = 0;
							$answer->save();
							}
					}	

				//if($answer->result == 0 && $answer->answerselectid != 0 && $quiz->applypenalties)
				//	$answer->result = -$question->penalty * $question->grade / 100;

				
				break;

			case CMDB_QUIZQUESTION_MATCHING:
				$answers = getdbolist('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
				foreach($answers as $answer)
				{
					$answer->result = 0;

					if($answer->answermatchingid1 == $answer->answermatchingid2)
					{
						$qqm = getdbo('QuizQuestionMatching', $answer->answermatchingid1);
						$answer->result = $qqm->valid * $question->grade / 100;
						$answer->save();
					}

					
					//if($answer->result == 0 && $answer->answermatchingid1 != 0 && $quiz->applypenalties)
					//	$answer->result = -$question->penalty * $question->grade / 100;
				
					$answer->save();
				}

				break;

			case CMDB_QUIZQUESTION_LONGTEXT:
				$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
				if(!$answer) continue;
				
				if(empty($answer->answerlong) && !$answer->answerfileid)
					$answer->result = 0;

				$answer->save();
				break;
				
			case CMDB_QUIZQUESTION_COMPARATIVE:
			case CMDB_QUIZQUESTION_RECORD:
				$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
				if(!$answer) continue;
				
				if(!$answer->answerfileid)
				{
					$answer->result = 0;
					$answer->save();
				}
						
				break;
		}
	}
	
	//////////////////////////////////////////////////////////////////////////////////
	
	$total_result = 0;
	$total_grade = 0;

	foreach($list as $e)
	{
		$question = getdbo('QuizQuestion', $e->questionid);

		if(	$question->answertype == CMDB_QUIZQUESTION_NONE ||
			$question->answertype == CMDB_QUIZQUESTION_CLOZE)
			continue;
		
		switch($question->answertype)
		{
			case CMDB_QUIZQUESTION_MATCHING:
				$result = 0;
		
				$count = getdbocount('QuizQuestionMatching', "questionid=$question->id");
				$answers = getdbolist('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
		
				foreach($answers as $answer)
					$result += $answer->result;
		
				$answerresult = $result / $count;
				break;
		
			case CMDB_QUIZQUESTION_SHORTTEXT:
			case CMDB_QUIZQUESTION_SELECT: 
			case CMDB_QUIZQUESTION_COMPARATIVE:
			case CMDB_QUIZQUESTION_RECORD:
			case CMDB_QUIZQUESTION_LONGTEXT:
				$answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
				$answerresult = $answer->result;
				break;
		}
		
		if($answerresult === null)
			return;
		
		$total_result += $answerresult;
		$total_grade += $question->grade;
	}
	
//	debuglog($total_result);
//	debuglog($total_grade);
	
	$attempt->result = $total_result * 100 / $total_grade;
	
	if($attempt->result >= $quiz->passthreshold)
		$attempt->status = CMDB_QUIZATTEMPT_PASSED;
	else
		$attempt->status = CMDB_QUIZATTEMPT_FAILED;
	
	$attempt->save();
}








