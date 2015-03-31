<?php

class Bookmark extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Bookmark';
	}

	public function rules()
	{
		return array(
		//	array('name', 'required'),
			array('name', 'length', 'max'=>200),
		);
	}

	public function relations()
	{
		return array(
	        'author'=>array(self::BELONGS_TO, 'User', 'authorid'),
	        'file'=>array(self::BELONGS_TO, 'VFile', 'fileid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}


}



