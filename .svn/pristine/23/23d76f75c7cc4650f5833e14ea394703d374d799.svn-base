<?php

class QuizQuestion extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'QuizQuestion';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
			'bank'=>array(self::BELONGS_TO, 'Object', 'bankid'),
			'file'=>array(self::BELONGS_TO, 'VFile', 'fileid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'answertype'=>'Question Type',
			'timelimit'=>'Time Limit',
			'shuffleanswers'=>'Shuffle Answers',
			'enumtype'=>'Enumeration Type 1',
			'enumtype2'=>'Enumeration Type 2',
			'fileid'=>'File',
		);
	}

	public function getAnswerTypeOptions()
	{
		return array(
			CMDB_QUIZQUESTION_SHORTTEXT=>'Short Text',
			CMDB_QUIZQUESTION_SELECT=>'Multiple Choice',
			CMDB_QUIZQUESTION_MATCHING=>'Matching',
			CMDB_QUIZQUESTION_LONGTEXT=>'Long Text',
			CMDB_QUIZQUESTION_RECORD=>'Record',
			CMDB_QUIZQUESTION_COMPARATIVE=>'Comparative',
			CMDB_QUIZQUESTION_CLOZE=>'Cloze',
			CMDB_QUIZQUESTION_NONE=>'Description',
		);
	}
	
	public function getAnswerTypeText()
	{
		$options = $this->answerTypeOptions;
		return isset($options[$this->answertype])? 
			$options[$this->answertype]: "Unset";
	}
	
	//////////////////////////////////////////////////////////////////////////////
	
	public function getEnumTypeOptions()
	{
		return array(
			CMDB_ENUMTYPE_NONE=>'None',
			CMDB_ENUMTYPE_NUMBER=>'Number',
			CMDB_ENUMTYPE_LETTERUP=>'Uppercase Letter',
			CMDB_ENUMTYPE_LETTERLOW=>'Lowercase Letter',
		//	CMDB_ENUMTYPE_ROMANUP=>'Roman Up',
		//	CMDB_ENUMTYPE_ROMANLOW=>'Roman Low',
		);
	}
	
	public function getEnumTypeText()
	{
		$options = $this->enumTypeOptions;
		return isset($options[$this->answertype])? $options[$this->answertype]: "Unset";
	}
	
	
	
}





