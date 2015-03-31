<?php

class PrivateMessage extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'PrivateMessage';
	}

	public function rules()
	{
		return array(
//			array('name', 'required'),
			array('name', 'length', 'max'=>200),
			array('authorid', 'required'),
			array('authorid', 'numerical'),
		);
	}

	public function relations()
	{
		return array(
	        'author'=>array(self::BELONGS_TO, 'User', 'authorid'),	//, 'alias'=>'author'),
	        'touser'=>array(self::BELONGS_TO, 'User', 'touserid'),	//, 'alias'=>'touser'),
		    'togroup'=>array(self::BELONGS_TO, 'Object', 'togroupid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name'=>'Subject',
			'senttime'=>'Sent On',
			'authorid'=>'From',
			'touserid'=>'To User',
			'togroupid'=>'To Group',
			'smtp'=>'SMTP',
		);
	}


	
}



