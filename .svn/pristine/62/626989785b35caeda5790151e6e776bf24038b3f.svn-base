<?php

class Semestertemplate extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Semestertemplate';
	}

	public function rules()
	{
		return array(
			array('name','length','max'=>200),
			array('name', 'required'),
			array('starttime, endtime', 'type', 'type'=>'datetime', 'datetimeFormat'=>'yyyy-MM-dd', 'allowEmpty'=>false),
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
			'id'=>'Id',
			'name'=>'Name',
			'starttime'=>'Start Time',
			'endtime'=>'End Time',
		);
	}
	
}



