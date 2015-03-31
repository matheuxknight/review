<?php

class AutocompleteController extends CController
{
	public function actionUser()
	{
		if(!Yii::app()->request->isAjaxRequest || !isset($_GET['term'])) return;
		$name = $_GET['term'];

		$criteria = new CDbCriteria;
		$criteria->condition = "name like :sterm or logon like :sterm or custom1 like :sterm";
		$criteria->sort = 'name';
		$criteria->params = array(":sterm"=>"%$name%");
		$criteria->limit = 30;

		$users = getdbolist('User', $criteria);
		//User::model()->findAll($criteria);

		echo '[';
		if($users && count($users)) foreach($users as $n=>$user)
		{
			if($n) echo ',';
			echo <<<END
{"id": "$user->id", "label": "{$user->name} ({$user->logon})"}
END;
		}
		
//		else echo <<<END
//{"id": "new", "label": "$name (new...)"}
//END;
		echo ']';
	}
	
	//////////////////////////////////////////////////////////////////
	
	public function actionUserLogon()
	{
		if(!Yii::app()->request->isAjaxRequest || !isset($_GET['term'])) return;
		$name = $_GET['term'];
		$courseid = $_GET['id'];

		$criteria = new CDbCriteria;
		$criteria->condition = "logon like :sterm";
		$criteria->sort = 'logon';
		$criteria->params = array(":sterm"=>"%$name%");
		$criteria->limit = 20;

		$users = getdbolist('User', $criteria);
		//User::model()->findAll($criteria);

		$n = 0;
		echo '[';
		if($users && count($users)) foreach($users as $user)
		{
			if($courseid && isUserEnrolled($courseid, $user->id))
				continue;
						
			if($n) echo ',';
			echo '{';
			echo "\"id\": \"{$user->id}\",";
			echo "\"logon\": \"{$user->logon}\",";
			echo "\"name\": \"{$user->name}\",";
			echo "\"email\": \"{$user->email}\",";
			echo "\"label\": \"{$user->logon}\"";
			echo '}';
			$n++;
		}
		echo ']';
	}

	//////////////////////////////////////////////////////////////////
	
	public function actionUserName()
	{
		if(!Yii::app()->request->isAjaxRequest || !isset($_GET['term'])) return;
		$name = $_GET['term'];
		$courseid = getparam('id');
		
		$criteria = new CDbCriteria;
		$criteria->condition = "name like :sterm";
		$criteria->sort = 'name';
		$criteria->params = array(":sterm"=>"%$name%");
		$criteria->limit = 20;

		$users = getdbolist('User', $criteria);
		//User::model()->findAll($criteria);

		$n = 0;
		echo '[';
		if($users && count($users)) foreach($users as $user)
		{
			if($courseid && isUserEnrolled($courseid, $user->id))
				continue;
						
			if($n) echo ',';
			echo '{';
			echo "\"id\": \"{$user->id}\",";
			echo "\"logon\": \"{$user->logon}\",";
			echo "\"name\": \"{$user->name}\",";
			echo "\"email\": \"{$user->email}\",";
			echo "\"label\": \"{$user->name}\"";
			echo '}';
			$n++;
		}
		echo ']';
	}
	
	public function actionPage()
	{
	//	if(!Yii::app()->request->isAjaxRequest || !isset($_GET['term'])) return;
		$name = $_GET['term'];
		
		$criteria = new CDbCriteria;
		$criteria->condition = "type != ".CMDB_OBJECTTYPE_FILE." and name LIKE :sterm and not deleted";
		$criteria->sort = 'name';
		$criteria->params = array(":sterm"=>"%$name%");
		$criteria->limit = 30;

		$pages = getdbolist('Object', $criteria);
		//Object::model()->findAll($criteria);

		echo '[';
		if($pages && count($pages)) foreach($pages as $n=>$object)
		{
			if($n) echo ',';
			echo <<<END
{"id": "$object->id", "label": "{$object->name}"}
END;
		}
		
		echo ']';
	}
	
	
}




