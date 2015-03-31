<?php

class Command extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Command';
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

	public function getImage($size=16)
	{
		$icon = '/images/base/dot.png';
		if($this->icon)
		{
			$iconset = param('iconset');
			$icon = preg_replace('/\{iconset\}/', "images/iconset/$iconset", $this->icon);
		}
		
		return img($icon, $this->name, array('width'=>$size));
	}
}






