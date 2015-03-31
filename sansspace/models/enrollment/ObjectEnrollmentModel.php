<?php

class ObjectEnrollment extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'ObjectEnrollment';
	}

	public function rules()
	{
		return array(
			array('userid, roleid, objectid', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'user'=>array(self::BELONGS_TO, 'User', 'userid'),
			'role'=>array(self::BELONGS_TO, 'Role', 'roleid'),
			'object'=>array(self::BELONGS_TO, 'Object', 'objectid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'=>'Id',
			'userid'=>'User',
			'roleid'=>'Role',
			'objectid'=>'Object',
		);
	}

}


