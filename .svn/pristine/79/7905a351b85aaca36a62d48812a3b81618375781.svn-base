<?php

class Certificate extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Certificate';
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
			'commonname'=>'Common Name',
			'organisationunit'=>'Organisation Unit',
			'city'=>'City/Locality',
			'state'=>'State/Province',
			'country'=>'Country/Region',
			'issigned'=>'Signed',
			'privatekey'=>'Private Key',
			'certrequest'=>'Certificate Request',
			'certificate'=>'Certificate',
		);
	}

	public function getOptions()
	{
		$list = CHtml::listData(getdbolist('Certificate', ""), 'id', 'commonname');
		$list[0] = '';
		
		return $list;
	}

	public function getText()
	{
		$options = $this->options;
		return isset($options[$this->id])? $options[$this->id]: "Unknown ({$this->id})";
	}
	
}





