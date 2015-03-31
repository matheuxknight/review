<?php

class UserCode extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'UserCode';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
			'object'=>array(self::BELONGS_TO, 'Object', 'objectid'),
			'course'=>array(self::BELONGS_TO, 'VCourse', 'courseid'),
			'user'=>array(self::BELONGS_TO, 'User', 'userid'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}

	public function getStatusOptions()
	{
		return array(
			CMDB_USERCODE_UNUSED=>'Unused',
			CMDB_USERCODE_USED=>'Used',
			CMDB_USERCODE_EXPIRED=>'Expired',
			CMDB_USERCODE_REVOKED=>'Revoked',
		);
	}
	
	public function getStatusText()
	{
		$options = $this->statusOptions;
		return isset($options[$this->status])? $options[$this->status]: '???';
	}
	
	
	
}



