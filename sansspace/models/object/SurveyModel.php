<?php

class Survey extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Survey';
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
			'file'=>array(self::BELONGS_TO, 'VFile', 'fileid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'fileid'=>'File',
			'allowupdate'=>'Allow Update',
			'allowmultiple'=>'Allow Multiple',
			'enumtype'=>'Enumeration Type',
		);
	}

	public function getAnswerTypeOptions()
	{
		return array(
			CMDB_SURVEYTYPE_TEXT=>'Text',
			CMDB_SURVEYTYPE_SELECT=>'Multiple Choice',
			CMDB_SURVEYTYPE_RANK=>'Rank',
			CMDB_SURVEYTYPE_CLOZE=>'Cloze',
			CMDB_SURVEYTYPE_NONE=>'Description',
		);
	}
	
	public function getAnswerTypeText()
	{
		$options = $this->answerTypeOptions;
		return isset($options[$this->answertype])? $options[$this->answertype]: "Unset";
	}
	
	
	
}



