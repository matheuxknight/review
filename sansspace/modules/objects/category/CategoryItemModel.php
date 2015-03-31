<?php

class CategoryItem extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'CategoryItem';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>200),
		);
	}

	public function relations()
	{
		return array(
	        'category'=>array(self::BELONGS_TO, 'Category', 'categoryid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}


}



