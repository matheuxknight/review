<?php

function TempFile2Xml()
{
	$phpsessid = session_id();
	$userid = userid();
	
	$pattern = SANSSPACE_TEMP."/phpsessid=$phpsessid&*.flv";
	
	$result = glob($pattern);
	if($result)
	{
		$x = "<object>
				<id>0</id>
				<name>untitled</name>
				<authorid>$userid</authorid>
				<size>0</size>
				<duration>0</duration>
				<hasaudio>0</hasaudio>
				<hasvideo>0</hasvideo>
				<masterid>0</masterid>
				<width>0</width>
				<height>0</height>
				<ready>0</ready>
				<message>Merging Files, Please Wait...</message>
			</object>";
		
//		debuglog("merging file");
		return $x;
	}
	
	$filename = SANSSPACE_TEMP."/phpsessid=$phpsessid.flv";
	if(!file_exists($filename))
	{
		$x = "<object>
				<id>0</id>
				<name>untitled</name>
				<authorid>$userid</authorid>
				<recordmode>1</recordmode>
				<size>0</size>
				<duration>0</duration>
				<hasaudio>0</hasaudio>
				<hasvideo>0</hasvideo>
				<masterid>0</masterid>
				<width>0</width>
				<height>0</height>
				<ready>1</ready>
				<message></message>
				<canwrite>1</canwrite>
			</object>";
		
//		debuglog("file not found");
		return $x;
	}
	
	require_once('extensions/ffmpeg/phpvideotoolkit.php5.php');
	$size = sprintf("%u", @filesize($filename));
	
	$_toolkit = new PHPVideoToolkit();
	$_toolkit->on_error_die = false;
	
	$_toolkit->setInputFile($filename);
	$data = $_toolkit->getFileInfo();
	
	$duration = $data['duration']['seconds']*1000 + 999; 
	//	$data['duration']['timecode']['seconds']['excess']*10;
		
	$hasaudio = isset($data['audio'])? 1: 0;
	$hasvideo = isset($data['video'])? 1: 0;
	
	if($hasvideo)
	{
		$width = $data['video']['dimensions']['width'];
		$height = $data['video']['dimensions']['height'];
	}
	else
	{
		$width = 0;
		$height = 0;
	}
				
	$canwrite = '0';
	if(isset($_GET['parentid']) && $_GET['parentid'] != 0)
	{
		$parent = getdbo('Object', $_GET['parentid']);
		if(controller()->rbac->objectAction($parent))
			$canwrite = '1';
	}
	
	$x = "<object>
			<id>0</id>
			<name>untitled</name>
			<authorid>$userid</authorid>
			<recordmode>1</recordmode>
			<size>$size</size>
			<duration>$duration</duration>
			<hasaudio>$hasaudio</hasaudio>
			<hasvideo>$hasvideo</hasvideo>
			<masterid>0</masterid>
			<width>$width</width>
			<height>$height</height>
			<ready>1</ready>
			<message></message>
			<canwrite>$canwrite</canwrite>
		</object>";
	
//	debuglog("found file ".$filename);
	return $x;
}

function objectMessageDisplay($object)
{
	$result = '';
	if($object1->file)
	{
		if($object->file->filetype == CMDB_FILETYPE_MEDIA)
		{
			if($object->file->hasaudio)
				$result .= "Audio";
				
			if($object->file->hasaudio && $object->file->hasvideo)
				$result .= "/";
				
			if($object->file->hasvideo)
				$result .= "Video";
		
			$result .= ' - '; 
		}
		else if($object->file->filetype == CMDB_FILETYPE_UNKNOWN)
			;
		else
			$result .= $object->file->fileTypeText.' - ';
	}
	
	if($object->duration)
		$result .= objectDuration2a($object);

	if($object->size)
		$result .= " (".Itoa($object->size).")";
		
	return $result;
}

function Object2Xml($object)
{
	if($object->type == CMDB_OBJECTTYPE_FILE)
		return File2Xml($object->file);
	
	$user = getUser();
	
	$url = getFullServerName().objectImageUrl($object);
	$message = objectMessageDisplay($object);
	
	$canwrite = '0';
	if(controller()->rbac->objectAction($object, 'update'))
		$canwrite = '1';
	
	$x = "<object>
			<id>{$object->id}</id>
			<type>{$object->type}</type>
			<name>{$object->name}</name>
			<parentid>{$object->parent->id}</parentid>
			<parentname>{$object->parent->name}</parentname>
			<authorid>{$object->authorid}</authorid>
			<size>".Itoa($object->size)."</size>
			<duration>".objectDuration2a($object)."</duration>
			<image>{$url}</image>
			<canwrite>$canwrite</canwrite>
			<message>{$message}</message>
		</object>";
	 
	return $x;
}

function File2Xml($file, $template=null)
{
	$ready = '0';
	$message = '';
	
	if($template)
	{
		$to = getdbosql('TranscodeObject', "fileid=$file->id and templateid=$template->id");
		if($to) switch($to->status)
		{
			case CMDB_OBJECTTRANSCODE_NATIVE:
			case CMDB_OBJECTTRANSCODE_COMPLETE:
				$message = 'Loading...';
				$ready = '1';
				break;
				
			case CMDB_OBJECTTRANSCODE_ERROR:
				$message = 'ERROR - The file cannot be played.';
				break;
				
			case CMDB_OBJECTTRANSCODE_NONE:
				$message = 'ERROR - The file is not transcoded.';
				break;
				
			case CMDB_OBJECTTRANSCODE_CURRENT:
				$message = 'Processing file...';
				break;

			case CMDB_OBJECTTRANSCODE_QUEUED:
			case CMDB_OBJECTTRANSCODE_QUEUED2:
				$message = 'This file is scheduled for processing.&#13;Please come back later to view it.';
				break;
		}
		else
		{
			$message = 'Initializing file...';
		}
	}
	
	else
		$ready = '1';
	
	$parent = $file->parent;
	$parentid = $parent->id;
	$parentname = $parent->name;
	
// 	if($parent->recordings)
// 	{
// 		$parent = $parent->parent->parent;
		
// 		if($parent->id == CMDB_OBJECTROOT_ID)
// 			$parentname = 'Practice Folder';
// 		else
// 			$parentname = $parent->name;
// 	}

	$url = getFullServerName().objectImageUrl($file);
	
	$canwrite = '0';
	if(controller()->rbac->objectAction($file, 'delete'))
		$canwrite = '1';
	
//	debuglog($canwrite);
//	debuglog("parentid $parentid");
	$x = "<object>
			<id>$file->id</id>
			<type>$file->type</type>
			<name>$file->name</name>
			<parentid>$parentid</parentid>
			<parentname>$parentname</parentname>
			<authorid>$file->authorid</authorid>
			<size>".Itoa($file->size)."</size>
			<duration>".objectDuration2a($file)."</duration>
			<image>$url</image>
			<filetype>$file->filetype</filetype>
			<hasaudio>$file->hasaudio</hasaudio>
			<hasvideo>$file->hasvideo</hasvideo>
			<width>$file->width</width>
			<height>$file->height</height>
			<masterid>$file->originalid</masterid>
			<ready>$ready</ready>
			<message>{$message}</message>
			<canwrite>$canwrite</canwrite>
		</object>";

	return $x;
}

// function ChannelUser2Xml($user)
// {
// 	$image = userImageUrl($user);
// 	$type = CMDB_CHATTYPE_PERSONAL;
// 	$role = CMDB_CHATROLE_PARTICIPANT;
// 	$count = 0;
// 	$me = getUser();

// 	$chatid = dboscalar(
// 		"select chat.id from chat, chatuser as chatuser1, chatuser as chatuser2 where ".
// 		"chat.type = 3 and ".
// 		"chatuser1.chatid=chat.id and chatuser1.userid=$me->id and ".
// 		"chatuser2.chatid=chat.id and chatuser2.userid=$user->id");
// 	if(empty($chatid)) $chatid = 0;

// 	$chatuser = getdbosql('ChatUser', "userid=$me->id and chatid=$chatid");
// 	if($chatuser)
// 	{
// 		$role = $chatuser->role;
// 		$count = dboscalar("select count(*) from ChatTextLog where chatid=$chatid and userid!=$me->id and sent>'$chatuser->lastlog'");
// 	}
	
// 	$x = "<object>
// 		<chatid>$chatid</chatid>
// 		<type>$type</type>
// 		<name>$user->name</name>
// 		<role>$role</role>
// 		<userid>$user->id</userid>
// 		<selected>0</selected>
// 		<hasaudio>0</hasaudio>
// 		<hasvideo>0</hasvideo>
// 		<image>$image</image>
// 		<count>$count</count>
// 		</object>";
	
// 	return $x;
// }

function Channel2Xml($chat)
{
//	debuglog($chat);
// 	switch($chat->type)
// 	{
// 		case CMDB_CHATTYPE_COURSE:
// 			$image = iconurl('course.png');
// 			break;

// 		case CMDB_CHATTYPE_PERSONAL:
// 			$image = iconurl('user.png');
// 			break;

// 		default:
// 			$image = iconurl('chat.png');
// 			break;
// 	}

	$name = $chat->name;
	if(empty($name))
	{
		$chatusers = getdbolist('ChatUser', "chatid=$chat->id");
		foreach($chatusers as $chatuser)
		{
			if($chatuser->user->id != userid())
				$name .= $chatuser->user->name.',';
		}
		
		$name = rtrim($name, ',');
		debuglog($name);
	}

	$x = "<object>
		<id>$chat->id</id>
		<type>$chat->type</type>
		<name>$name</name>
		</object>";
	
	return $x;
}



