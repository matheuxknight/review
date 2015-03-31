<?php

class SurveyOption extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'SurveyOption';
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
			'file'=>array(self::BELONGS_TO, 'VFile', 'fileid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}

	
	
}



