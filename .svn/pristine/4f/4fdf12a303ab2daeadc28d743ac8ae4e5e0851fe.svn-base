<?php

class Shortcut extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Shortcut';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
			'command'=>array(self::BELONGS_TO, 'Command', 'commandid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}
}

