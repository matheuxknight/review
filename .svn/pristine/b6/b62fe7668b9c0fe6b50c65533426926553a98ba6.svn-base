<?php

class SurveyAnswer extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'SurveyAnswer';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
	        'survey'=>array(self::BELONGS_TO, 'Survey', 'surveyid'),
			'option'=>array(self::BELONGS_TO, 'SurveyOption', 'optionid'),
			'user'=>array(self::BELONGS_TO, 'User', 'userid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}

	
	
}



