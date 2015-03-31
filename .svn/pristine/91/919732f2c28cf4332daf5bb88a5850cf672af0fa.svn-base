<?php

class PasswordForm extends CFormModel
{
	public $password;
	public $confirm_password;
	
	public function rules()
	{
		return array(
			array('password', 'required'),
			array('confirm_password', 'required'),
			array('confirm_password', 'compare', 'compareValue'=>$this->password),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}

}
