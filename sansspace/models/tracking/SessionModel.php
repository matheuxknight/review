<?php

class Session extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Session';
	}

	public function rules()
	{
		return array(
			array('phpsessid','length','max'=>200),
			array('starttime', 'required'),
			array('userid, clientid, status', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'client'=>array(self::BELONGS_TO, 'Client', 'clientid'),
			'user'=>array(self::BELONGS_TO, 'User', 'userid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'=>'Id',
			'userid'=>'User',
			'clientid'=>'Client',
			'starttime'=>'Start Time',
			'duration'=>'Duration',
			'status'=>'Status',
			'phpsessid'=>'Phpsess',
		);
	}

	/////////////////////

	public function getStatusOptions()
	{
		return array(
			CMDB_SESSIONSTATUS_UNKNOWN		=> 'Unknown',
			CMDB_SESSIONSTATUS_CONNECTED	=> 'Connected',
			CMDB_SESSIONSTATUS_COMPLETE		=> 'Complete',
			CMDB_SESSIONSTATUS_NOLICENSE	=> 'No License',
			CMDB_SESSIONSTATUS_ERROR		=> 'Error',
		);
	}

	public function getStatusText()
	{
		$options = $this->statusOptions;
		return isset($options[$this->status])? $options[$this->status]: "Unknown ({$this->status})";
	}

	public function getStatusIcon()
	{
		switch($this->status)
		{
			case CMDB_SESSIONSTATUS_CONNECTED:
				return mainimg('online.gif');
				
			case CMDB_SESSIONSTATUS_COMPLETE:
				return mainimg('offline.gif');

			case CMDB_SESSIONSTATUS_ERROR:
				return 'ERROR';
				
		}
	}

	//////////////////////////////////////////////////////////////
	
	// user
	// client
	//
	// init - read phpsessid
	// authenticate
	
	
}




