<?php

class UserEnrollment extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'UserEnrollment';
	}

	public function rules()
	{
		return array(
			array('userid, roleid', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'user'=>array(self::BELONGS_TO, 'User', 'userid'),
			'role'=>array(self::BELONGS_TO, 'Role', 'roleid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'=>'Id',
			'userid'=>'User Name',
			'roleid'=>'Role Name',
		);
	}

}


