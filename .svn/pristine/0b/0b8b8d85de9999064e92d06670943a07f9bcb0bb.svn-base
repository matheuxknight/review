<?php

class TranscodeTemplate extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'TranscodeTemplate';
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
			'id'=>'Id',
			'audiocodec'=>'Codec',
			'videocodec'=>'Codec',
			'audiobitrate'=>'Bitrate',
			'audiofreq'=>'Frequency',
			'videobitrate'=>'Bitrate',
			'videodimension'=>'Lines',
			'active'=>'Default',
		);
	}
	
	//////////////////////////////

	public function getOptions()
	{
		return CHtml::listData(getdbolist('TranscodeTemplate',""), 'id', 'name');
	}

	public function getOptionText($option)
	{
		$options = $this->getOptions();
		return isset($options[$option])? $options[$option]: "Unknown ($option)";
	}
	
}

