<?php

class FolderImport extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'FolderImport';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>200),
			array('pathname', 'required'),
			array('pathname', 'length', 'max'=>200),
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
			'id'=>'Id',
			'objectid'=>'Object',
			'status'=>'Status',
			'autoscan'=>'Auto Scan',
			'autotranscode'=>'Auto Transcode',
			'lastscan'=>'Last Scan',
			'pathname'=>'Pathname',
		);
	}
	
}


