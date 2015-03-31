<?php

class Roster extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'RosterTemplate';
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
			'example'=>'Sample',
			'coursename'=>'Course Name',
			'foldername'=>'Folder Name',
			'languagename'=>'Language Name',
			'username'=>'User Name',
			'userlogon'=>'User Logon',
			'useremail'=>'User Email',
			'userrole'=>'User Role',
			'teachername'=>'Teacher Name',
			'teacherlogon'=>'Teacher Logon',
			'teacheremail'=>'Teacher Email',
			'languagetable'=>'Language Table',
			'extracode'=>'Extra PHP Code',
			'domainid'=>'Domain',
			'customcourse'=>'Custom Course',
			'customuser'=>'Custom User',
			'hassemester'=>'Has Semester',
			'skipfirst'=>'Skip First Line',
			'deleteafter'=>'Delete After',
			'sourcefile'=>'Source File',
		);
	}

}





