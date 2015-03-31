<?php

class ConnectionController extends CommonController
{
	public function actionPing()
	{
		$user = getUser();
		if(!$user)
		{
			$this->identity->logout();
			return;
		}
		
		header('Content-Type: text/xml');
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		
		$session = $this->identity->session;
		
		$session->duration = time() - strtotime($session->starttime);
		$session->status = CMDB_SESSIONSTATUS_CONNECTED;
		$session->timeping = time();
		$session->save();

		$user->status = CMDB_USERSTATUS_ONLINE;
		$user->accessed = now();
		$user->used = now();
		$user->save();
		
		$connected = CMDB_SESSIONSTATUS_CONNECTED;
		$online = getdbocount('Session', "status=$connected and not isguest");
		
		/////////////////////////

		if(!user()->isGuest && !$this->rbac->globalAdmin())
		{
			$logoff = $session->forcelogout;
			$i = getparam('i');
			
			if(!$logoff && $i >= 5)
			{
				$diff = $session->timeping - $session->timepage;
				if(param('logofftimeout') && $diff > param('logofftimeout') * 60)
				{
					// here: file chat record
					if(	!strstr($session->lastpage, "/file") &&
						!strstr($session->lastpage, "/chat") &&
						!strstr($session->lastpage, "/connect") &&
						!strstr($session->lastpage, "/recorder"))
						$logoff = true;
				}
			}
			
			if($logoff)
			{
				echo "<?xml version='1.0' encoding='utf-8' ?>";
				echo "<response>";
				echo "<logoff>1</logoff>";
				echo "</response>";
				return;
			}
		}
		
		/////////////////////////

		$refresh = 0;

		$objectid = user()->getState('currentobject');
		$version = user()->getState('currentversion');

		if($objectid && $version)
		{
			$object = getdbo('Object', $objectid);
			if($object && $version != $object->version)
			{
				user()->setState('currentversion', $object->version);
				$refresh = 1;
			}
		}

		/////////////////////////
		
// 		$chatmenu = '';
// 		$totalchatcount = 0;
// 		$chatusers = getdbolist('ChatUser', "userid=$user->id");
		
// 		$mintime = date('Y-m-d H:i', time()-48*60*60);
// 		$chatusertable = array();
		
// 		foreach($chatusers as $chatuser)
// 		{
// 			if($chatuser->selected) continue;
// 			$chatcount = dboscalar(
// 				"select count(*) from ChatTextLog where chatid=$chatuser->chatid and sent>'$chatuser->lastlog' and sent>'$mintime'");
			
// 			$totalchatcount += $chatcount;
// 			$chatusertable[$chatuser->chatid] = $chatcount;
			
// 			if($chatcount)
// 			{
// 				$chat = getdbo('Chat', $chatuser->chatid);
// 				if($chat->type == CMDB_CHATTYPE_PERSONAL)
// 				{
// 					$peerid = dboscalar("select userid from ChatUser where chatid=$chat->id and userid!=$user->id");
// 					$peer = getdbo('User', $peerid);
					
// 					$image = iconimg("user.png", '', array('width'=>16));
// 					$chatmenu .= '<li>'.l("$image &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$peer->name ({$chatusertable[$chat->id]})",
// 						array('chat/', 'chatid'=>$chat->id)).'</li>';
// 				}
// 			}
// 		}
		
// 		$chats = getdbolist('Chat', "type=".CMDB_CHATTYPE_PUBLIC);
// 		foreach($chats as $chat)
// 		{
// 			$image = iconimg("chat.png", '', array('width'=>16));
			
// 			if(isset($chatusertable[$chat->id]) && $chatusertable[$chat->id])
// 				$chatmenu .= '<li>'.l("$image &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$chat->name ({$chatusertable[$chat->id]})",
// 					array('chat/', 'chatid'=>$chat->id)).'</li>';
// 			else
// 				$chatmenu .= '<li>'.l("$image &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$chat->name",
// 					array('chat/', 'chatid'=>$chat->id)).'</li>';
// 		}
		
// 		$semester = getCurrentSemester();
// 		foreach($user->courseenrollments as $e)
// 		{
// 			$course = $e->course;
// 			if($course->type != CMDB_OBJECTTYPE_COURSE) continue;
// 			if($course->semesterid && $course->semesterid != $semester->id) continue;
				
// 			$chat = getdbo('Chat', $course->callid);
// 			if(!$chat) continue;
		
// 			$image = objectImage($course, 16);

// 			if(isset($chatusertable[$chat->id]) && $chatusertable[$chat->id])
// 				$chatmenu .= '<li>'.l("$image &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$chat->name ({$chatusertable[$chat->id]})", 
// 					array('chat/', 'chatid'=>$chat->id)).'</li>';
// 			else
// 				$chatmenu .= '<li>'.l("$image &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$chat->name", 
// 					array('chat/', 'chatid'=>$chat->id)).'</li>';
// 		}

		//////////////////////////////////////////////

	//	if(!$this->rbac->globalAdmin()) return;
		
		$server = getdbo('Server', '1');
	//	debuglog("netmessage: $server->netmessage");
		
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<response>";

		echo "<logoff>0</logoff>";
		echo "<online>$online</online>";
		echo "<refresh>$refresh</refresh>";
//		echo "<chatcount>$totalchatcount</chatcount>";
//		echo "<chatmenu><![CDATA[$chatmenu]]></chatmenu>";
		echo "<netmessage><![CDATA[$server->netmessage]]></netmessage>";
		echo "</response>";
	}

	public function actionForceLogout()
	{
		if(!$this->rbac->globalAdmin()) return;
		
		$session = getdbo('Session', getparam('id'));
		if($session)
		{
			$session->forcelogout = true;
			$session->save();
		}
		
		$this->goback();
	}
	
}




