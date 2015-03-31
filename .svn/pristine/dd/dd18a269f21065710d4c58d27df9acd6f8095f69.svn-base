<?php

class Cronjob extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Cronjob';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>200),
			array('url', 'length', 'max'=>200),
			array('delay', 'length', 'max'=>200),
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
			'url'=>'Url',
			'delay'=>'Time',
			'enable'=>'Enable',
			'phpcode'=>'Script',
		);
	}

	public function getNowint()
	{
		$a = explode(' ', now());
		return isset($a[0])? $a[0]: '';
	}
	
	public function getNowmonthint()
	{
		$a = explode('-', $this->nowint);
		return isset($a[1])? $a[1]: '';
	}
	
	public function getNowdayint()
	{
		$a = explode('-', $this->nowint);
		return isset($a[2])? $a[2]: '';
	}
	
	public function getNowmonthstring()
	{
		$month = $this->nowmonthint;
		if ($month == 1 ){
			$month = "Jan";}
		elseif ($month == 2 ){
			$month = "Feb";}
		elseif ($month == 3 ){
			$month = "Mar";}
		elseif ($month == 4 ){
			$month = "Apr";}
		elseif ($month == 5 ){
			$month = "May";}
		elseif ($month == 6 ){
			$month = "Jun";}
		elseif ($month == 7 ){
			$month = "Jul";}
		elseif ($month == 8 ){
			$month = "Aug";}
		elseif ($month == 9 ){
			$month = "Sep";}
		elseif ($month == 10 ){
			$month = "Oct";}
		elseif ($month == 11 ){
			$month = "Nov";}
		elseif ($month == 12 ){
			$month = "Dec";}
		else{
			$month = "NaN";}

		return $month;
	}
	

}


