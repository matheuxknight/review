<?php

class CourseEnrollment extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'CourseEnrollment';
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
			'object'=>array(self::BELONGS_TO, 'Object', 'objectid'),	//here:
			'course'=>array(self::BELONGS_TO, 'VCourse', 'courseid'),	//here:
			'recording'=>array(self::BELONGS_TO, 'Object', 'recordingid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'=>'Id',
			'userid'=>'User',
			'roleid'=>'Role',
			'objectid'=>'Course',
			'description'=>'Notes',
		);
	}

	/////////////////////
	
	public function getStatusOptions()
	{
		return array(
				CMDB_ENROLLSTATUS_NONE=>'n/a',
				CMDB_ENROLLSTATUS_STARTED=>'Started',
				CMDB_ENROLLSTATUS_COMPLETED=>'Completed',
				CMDB_ENROLLSTATUS_PASSED=>'Passed',
				CMDB_ENROLLSTATUS_FAILED=>'Failed',
				CMDB_ENROLLSTATUS_CANCELLED=>'Cancelled',
		);
	}
	
	public function getStatusText()
	{
		$options = $this->statusOptions;
		return isset($options[$this->status])? $options[$this->status]: "";
	}
	
	
}


