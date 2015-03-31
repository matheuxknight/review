<?php

class Enrollment extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Enrollment';
	}

	public function rules()
	{
		return array(
			array('id, type, userid, objectid, roleid, status', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'user'=>array(self::BELONGS_TO, 'User', 'userid', 'condition'=>'Enrollment.type='.CMDB_ENROLLTYPE_USER),
			'group'=>array(self::BELONGS_TO, 'Object', 'objectid', 'condition'=>'Enrollment.type='.CMDB_ENROLLTYPE_GROUP),
			'role'=>array(self::BELONGS_TO, 'Role', 'roleid'),
			'object'=>array(self::BELONGS_TO, 'Object', 'id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'=>'Id',
			'type'=>'Type',
			'objectid'=>'Group',
			'roleid'=>'Role',
			'description'=>'Notes',
			'userid'=>'User Name',
		);
	}

	/////////////////////

	public function getTypeOptions()
	{
		return array(
			CMDB_ENROLLTYPE_USER=>'User',
			CMDB_ENROLLTYPE_GROUP=>'Group',
			CMDB_ENROLLTYPE_ROLE=>'Role',
		);
	}

	public function getTypeText()
	{
		$options = $this->typeOptions;
		return isset($options[$this->type])? $options[$this->type]: "Unknown ({$this->type})";
	}


}


