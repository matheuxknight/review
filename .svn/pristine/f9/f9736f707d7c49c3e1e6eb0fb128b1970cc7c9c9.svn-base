<?php

class TranscodeObject extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'TranscodeObject';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
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
			CMDB_OBJECTTRANSCODE_NONE		=>'',
			CMDB_OBJECTTRANSCODE_QUEUED		=>'Scheduled',
			CMDB_OBJECTTRANSCODE_QUEUED2	=>'Scheduled Next',
			CMDB_OBJECTTRANSCODE_QUEUED3	=>'Scheduled Next',
			CMDB_OBJECTTRANSCODE_CURRENT	=>'Processing...',
			CMDB_OBJECTTRANSCODE_INDEXING	=>'Indexing...',
			CMDB_OBJECTTRANSCODE_COMPLETE	=>'Ready',
			CMDB_OBJECTTRANSCODE_NATIVE		=>'Native',
			CMDB_OBJECTTRANSCODE_ERROR		=>'Error',
			);
	}

	public function getStatusText()
	{
		if($this->status == CMDB_OBJECTTRANSCODE_CURRENT)
			return $this->message;
		
		$options = $this->statusOptions;
		return isset($options[$this->status])? $options[$this->status]: "Unknown ({$this->status})";
	}

	
}

