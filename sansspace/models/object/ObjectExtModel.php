<?php

class ObjectExt extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'ObjectExt';
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
			'doctext'=>'Description',
			'customcolor1'=>'Custom Color 1',
			'customcolor2'=>'Quiz Color Theme',
			'customheader'=>'Header',
			'customiconset'=>'Theme',
		);
	}

}



