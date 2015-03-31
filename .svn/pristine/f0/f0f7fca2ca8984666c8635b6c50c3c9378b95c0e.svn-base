<?php

class ChatUser extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'ChatUser';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
	        'user'=>array(self::BELONGS_TO, 'User', 'userid'),
	        'chat'=>array(self::BELONGS_TO, 'Chat', 'chatid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}

	
}



