<?php

class RegisterForm extends CFormModel
{
	public $user;
	public $register_role;
	public $confirm_password;
	public $verifyCode;
	public $firstname;
	public $lastname;
	
	public function rules()
	{
		return array(
			array('confirm_password', 'required'),
			array('confirm_password', 'compare', 'compareValue'=>$this->user->password),
			array('verifyCode', 'captcha', 'allowEmpty'=>!extension_loaded('gd')),
			array('verifyCode', 'required'),
			array('register_role', 'required'),
			array('firstname', 'required'),
			array('lastname', 'required'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
			'register_role'=>'',
			'firstname'=>'First Name',
			'lastname'=>'Last Name',
		);
	}

}
