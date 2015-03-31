<?php

class CategoryObject extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'CategoryObject';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
	        'category'=>array(self::BELONGS_TO, 'Category', 'categoryid'),
	        'categoryitem'=>array(self::BELONGS_TO, 'CategoryItem', 'categoryitemid'),
	        'object'=>array(self::BELONGS_TO, 'Object', 'objectid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}


}



