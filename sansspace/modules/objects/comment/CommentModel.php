<?php

class Comment extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Comment';
	}

	public function rules()
	{
		return array(
            array('doctext', 'required'),
			array('authorid, parentid, pinned', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'object'=>array(self::BELONGS_TO, 'Object', 'parentid'),
			'course'=>array(self::BELONGS_TO, 'VCourse', 'courseid'),
			'author'=>array(self::BELONGS_TO, 'User', 'authorid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'=>'Id',
			'authorid'=>'Author',
			'doctext'=>'',
			'updated'=>'Updated',
			'created'=>'Created',
			'accessed'=>'Accessed',
			'name'=>'Title',
			'parentid'=>'Parent',
			'pinned'=>'Pinned',
			'courseid'=>'Context Course',
		);
	}
}


