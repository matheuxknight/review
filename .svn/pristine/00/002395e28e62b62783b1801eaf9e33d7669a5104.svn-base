<?php

class QuizQuestionSelect extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'QuizQuestionSelect';
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
			'file'=>array(self::BELONGS_TO, 'VFile', 'fileid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}


	
}



