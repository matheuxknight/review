<?php

class Client extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Client';
	}

	public function rules()
	{
		return array(
			array('remotename','length','max'=>200),
			array('remoteip','length','max'=>200),
			array('remoteip','required'),
			array('sessionid', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'session'=>array(self::BELONGS_TO, 'Session', 'sessionid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'=>'Id',
			'sessionid'=>'Last Session',
			'remotename'=>'Computer Name',
			'remoteip'=>'IP Address',
		);
	}
}

