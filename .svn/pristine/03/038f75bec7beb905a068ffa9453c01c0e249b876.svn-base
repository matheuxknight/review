<?php

class Course extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Course';
	}

	public function rules()
	{
		return array(
			VCourse::$startdate_required? array('startdate', 'required'): null,

			array('startdate, enddate', 'type', 'type'=>'datetime', 'datetimeFormat'=>'yyyy-MM-dd', 'allowEmpty'=>true),
		);
	}
	
}


