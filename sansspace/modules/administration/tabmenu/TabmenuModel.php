<?php

class Tabmenu extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Tabmenu';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
			'object'=>array(self::BELONGS_TO, 'Object', 'objectid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}

}





