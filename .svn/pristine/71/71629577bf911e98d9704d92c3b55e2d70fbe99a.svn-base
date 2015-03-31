<?php

class File extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'File';
	}

	public function rules()
	{
		return array(
			array('objectid, filetype, width, height, originalid', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
		);
	}

}

