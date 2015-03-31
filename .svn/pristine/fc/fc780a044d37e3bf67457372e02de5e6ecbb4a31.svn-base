<?php

class QuizAttemptAnswer extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'QuizAttemptAnswer';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
			'attempt'=>array(self::BELONGS_TO, 'QuizAttempt', 'userid'),
			'question'=>array(self::BELONGS_TO, 'QuizQuestion', 'questionid'),
			'answerfile'=>array(self::BELONGS_TO, 'VFile', 'answerfileid'),
			'answerselect'=>array(self::BELONGS_TO, 'QuizQuestionSelect', 'answerselectid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}

	public function getCorrectionOptions()
	{
		return array(
			CMDB_QUIZCORRECTION_NONE=>'?',
			CMDB_QUIZCORRECTION_PASS=>'<font color=green>Pass</font>',
			CMDB_QUIZCORRECTION_FAIL=>'<font color=red>Fail</font>',
		);
	}
	
	public function getCorrectionText()
	{
		$options = $this->correctionOptions;
		return isset($options[$this->correction])? 
			$options[$this->correction]: '???';
	}
	
	
	
}



