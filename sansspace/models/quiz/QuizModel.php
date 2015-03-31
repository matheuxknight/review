<?php

class Quiz extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Quiz';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
	        'object'=>array(self::BELONGS_TO, 'Object', 'quizid'),
	        'bank'=>array(self::BELONGS_TO, 'Object', 'bankid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'allowback'=>'Allow Back',
			'allowvideo'=>'Allow Video',
			'allowedattempt'=>'Allowed Attempts',
			'timelimit'=>'Time Limit',
				
			'expiredaction'=>'Expired Action',
			'passthreshold'=>'Pass Threshold',
			'gradingmethod'=>'Grading Method',
			'applypenalties'=>'Apply Penalties',
			'questionperpage'=>'Question per Page',
			'shufflequestion'=>'Shuffle Questions',
				
			'introfeedback'=>'Introduction Text',
			'completefeedback'=>'Quiz Submitted Text',
			'passfeedback'=>'Passing Feedback',
			'failfeedback'=>'Failing Feedback',
				
		);
	}

	//////////////////////////////////////////////////////////////////////////////
	
	public function getExpiredActionOptions()
	{
		return array(
			CMDB_QUIZEXPIRED_NONE=>'None',
			CMDB_QUIZEXPIRED_SUBMIT=>'Submit',
			CMDB_QUIZEXPIRED_IGNORE=>'Fail',
		);
	}
	
	public function getExpiredActionText()
	{
		$options = $this->expiredActionOptions;
		return isset($options[$this->expiredaction])? $options[$this->expiredaction]: "Unset";
	}
	
	//////////////////////////////////////////////////////////////////////////////
	
	public function getGradingMethodOptions()
	{
		return array(
		//	CMDB_QUIZGRADING_NONE=>'None',
			CMDB_QUIZGRADING_HIGH=>'Highest',
			CMDB_QUIZGRADING_AVG=>'Average',
			CMDB_QUIZGRADING_FIRST=>'First',
			CMDB_QUIZGRADING_LAST=>'Last',
		);
	}
	
	public function getGradingMethodText()
	{
		$options = $this->gradingMethodOptions;
		return isset($options[$this->gradingmethod])? $options[$this->gradingmethod]: "Unset";
	}
	
	
	
	
}



