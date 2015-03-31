<?php

class VSession extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'VSession';
	}

	public function primaryKey()
	{
		return 'id';
	}

	public function rules()
	{
		return array();
	}

	public function relations()
	{
        $relations = Object::model()->relations();
		return $relations;
	}

	public function attributeLabels()
	{
		return array(
			'remoteip'=>'From Computer',
			'starttime'=>'When',
			'status'=>'Status',
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

}




