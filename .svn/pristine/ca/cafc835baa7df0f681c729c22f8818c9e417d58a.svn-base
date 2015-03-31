<?php

class QuizAttempt extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'QuizAttempt';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
			'course'=>array(self::BELONGS_TO, 'VCourse', 'quizid'),
			'quiz'=>array(self::BELONGS_TO, 'Quiz', 'quizid'),
			'user'=>array(self::BELONGS_TO, 'User', 'userid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}
	
	public function getstatusOptions()
	{
		return array(
			CMDB_QUIZATTEMPT_NONE=>'None',
			CMDB_QUIZATTEMPT_STARTED=>'Started',
			CMDB_QUIZATTEMPT_COMPLETED=>'Evaluation pending',
			CMDB_QUIZATTEMPT_PASSED=>'Pass',
			CMDB_QUIZATTEMPT_FAILED=>'Fail',
			CMDB_QUIZATTEMPT_CANCELLED=>'Cancelled',
		);
	}
	
	public function getStatusText()
	{
		$options = $this->statusOptions;
		return isset($options[$this->status])? $options[$this->status]: "Unset";
	}
	
	
}



