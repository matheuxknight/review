<?php

class RecordSession extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'RecordSession';
	}

	public function rules()
	{
		return array(
			array('starttime', 'required'),
			array('sessionid, fileid, userid, duration, status', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'user'=>array(self::BELONGS_TO, 'User', 'userid'),
			'file'=>array(self::BELONGS_TO, 'VFile', 'fileid'),
			'session'=>array(self::BELONGS_TO, 'Session', 'sessionid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'=>'Id',
			'sessionid'=>'Session',
			'fileid'=>'File',
			'userid'=>'User',
			'starttime'=>'Starttime',
			'duration'=>'Duration',
			'status'=>'Status',
		);
	}

	/////////////////////

	public function getStatusOptions()
	{
		return array(
			CMDB_FILESESSIONSTATUS_UNKNOWN		=> 'Unknown',
			CMDB_FILESESSIONSTATUS_OPEN			=> 'Open',
			CMDB_FILESESSIONSTATUS_COMPLETE		=> 'Complete',
			CMDB_FILESESSIONSTATUS_NOLICENSE	=> 'No License',
			CMDB_FILESESSIONSTATUS_ERROR		=> 'Error',
		);
	}

	public function getStatusText()
	{
		$options = $this->statusOptions;
		return isset($options[$this->status])? $options[$this->status]: "Unknown ({$this->status})";
	}


}



