<?php

class QuizQuestionMatching extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'QuizQuestionMatching';
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
			'file1'=>array(self::BELONGS_TO, 'VFile', 'fileid1'),
			'file2'=>array(self::BELONGS_TO, 'VFile', 'fileid2'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}


	
}



