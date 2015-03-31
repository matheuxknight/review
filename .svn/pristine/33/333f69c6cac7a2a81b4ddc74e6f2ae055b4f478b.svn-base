<?php

class QuizQuestionEnrollment extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'QuizQuestionEnrollment';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
			'question'=>array(self::BELONGS_TO, 'QuizQuestion', 'questionid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}


	
}



