<?php

class Favorite extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Favorite';
	}

	public function rules()
	{
		return array(
			array('userid, id', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'user'=>array(self::BELONGS_TO, 'User', 'userid'),
			'object'=>array(self::BELONGS_TO, 'Object', 'id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'userid'=>'User',
			'id'=>'Object',
		);
	}

}


