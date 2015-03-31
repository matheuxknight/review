<?php

class ChatController extends CommonController
{
	public $defaultAction='show';
	
	public function actionStart()
	{
		if(user()->isGuest) return;
		$this->render('start');
	}

	public function actionShow()
	{
		if(user()->isGuest) return;
		$this->render('show');
	//	include "show.php";
	}

	public function actionInternalListChat()
	{
		if(user()->isGuest) return;
		$user = getUser();

		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');

		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";
		
		$chats = getdbolist('ChatUser', "userid=$user->id and selected");
		foreach($chats as $chatuser)
			echo Channel2Xml($chatuser->chat);

		echo "</objects>";
	}
	
}





