<?php

class Role extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Role';
	}

	public function rules()
	{
		return array(
			array('name','required'),
			array('name','length','max'=>200),
			array('description','length','max'=>200),
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
			'description'=>'Description',
		);
	}

	/////////////////////

	public function getUserData()
	{
		return CHtml::listData(RbacUserRoleTable(), 'id', 'description');
	}
	
	public function getObjectData()
	{
		return CHtml::listData(RbacObjectRoleTable(), 'id', 'description');
	}
	
	public function getCourseData()
	{
		return CHtml::listData(RbacCourseRoleTable(), 'id', 'description');
	}
	
	///////////////////////////////////////////////////////////////////////
	
	public function getUserOptions()
	{
		$htmloptions = array();
		return CHtml::listOptions(SSPACE_ROLE_USER, $this->userData, $htmloptions);
	}
	
	public function getObjectOptions()
	{
		$htmloptions = array();
		return CHtml::listOptions(SSPACE_ROLE_USER, $this->objectData, $htmloptions);
	}
	
	public function getCourseOptions()
	{
		$htmloptions = array();
		return CHtml::listOptions(SSPACE_ROLE_STUDENT, $this->courseData, $htmloptions);
	}
	
	
}



