<?php

class Server extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Server';
	}

	public function rules()
	{
		return array(
			array('localname','length','max'=>200),
			array('localip','length','max'=>200),
			array('remotename','length','max'=>200),
			array('remoteip','length','max'=>200),
			array('version','length','max'=>200),
			array('signature','length','max'=>200),
			array('serialnumber','length','max'=>200),
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
			'localname'=>'Local Name',
			'localip'=>'Local IP',
			'remotename'=>'Router DNS',
			'remoteip'=>'Router IP',
			'lastaccess'=>'Last Access',
			'version'=>'Version',
			'signature'=>'Signature',
			'serialnumber'=>'Serial Number',
			'title'=>'Title',
			'porthttp'=>'HTTP Port',
			'description'=>'Home',
			'accessdenied'=>'Login Message',
			'footer'=>'Footer',
			'mymessage'=>'My SANSSpace',
			'netmessage'=>'Network Message',
			'registerpage'=>'Register Form',
		);
	}
}

