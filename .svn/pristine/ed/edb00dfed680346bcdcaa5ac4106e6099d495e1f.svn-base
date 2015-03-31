<?php

class VFileSession extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'VFileSession';
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
		$relations['session'] = array(self::BELONGS_TO, 'Session', 'sessionid');
        return $relations;
	}

	public function attributeLabels()
	{
		return array(
			'objectname'=>'File',
			'parentname'=>'Folder',
		);
	}

	/////////////////////


}




