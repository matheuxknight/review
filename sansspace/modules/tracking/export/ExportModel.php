<?php

class Export extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'UsageExportTemplate';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
			'cronjob'=>array(self::BELONGS_TO, 'Cronjob', 'cronjobid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'titleformat'=>'Title Format',
			'dataformat'=>'Data Format',
			'timeformat'=>'Time Format',
			'targetfile'=>'Target File',
			'autotype'=>'Report Range',
		);
	}

}





