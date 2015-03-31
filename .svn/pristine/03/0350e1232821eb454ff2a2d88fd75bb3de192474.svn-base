<?php

require_once('/extensions/cas/CAS.php');

class Domain extends CActiveRecord
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Domain';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length','max'=>200),
			array('ldapserver', 'length','max'=>200),
			array('extractfolder', 'length','max'=>200),
			array('ldapssl, deleteextracts', 'numerical', 'integerOnly'=>true),
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
			'ldapenable'=>'Enable',
			'ldaptype'=>'Authentication Type',
			'ldapserver'=>'Server',
			'ldapdn'=>'Base DN',
			'ldapssl'=>'SSL',
			'ldapuid'=>'UID',
			'ldapemail'=>'Email',
			'ldapdisplayname'=>'Display Name',
			'ldapfilter'=>'Filter',
			'casenable'=>'Enable',
			'casserver'=>'Server',
			'casport'=>'Port Number',
			'cascontext'=>'Context',
			'casautologin'=>'Auto Login',
			'casexclusive'=>'Exclusive Login',
			'winenable'=>'Enable',
			'winserver'=>'Server',
			'windomain'=>'Domain',
			'extractfolder'=>'Folder',
			'deleteextracts'=>'Delete Files',
			'importscript'=>'Import Script',
		);
	}

	/////////////////////
	
	public function casInitialize()
	{
	}

}



