<?php

class ForgotForm extends CFormModel
{
	public $name;
	public $email;
	public $verifyCode;
	
	public function rules()
	{
		return array(
			array('email', 'email'),
			array('verifyCode', 'captcha', 'allowEmpty'=>!extension_loaded('gd')),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name'=>'User Name',
			'verifyCode'=>'Verification Code',
		);
	}
	
	
}


