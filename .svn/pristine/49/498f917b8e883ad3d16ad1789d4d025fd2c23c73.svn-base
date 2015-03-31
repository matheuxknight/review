<?php

class RecorderController extends CommonController
{
	public $defaultAction = 'show';

	public function actionShow()
	{
		$this->render('show');
	}

	////////////////////////////////////////////////////////////
	
	public function actionInternalQuickRecorder()
	{
	//	$user = getUser();
		$masterid = getparam('id');
		
		$flashvars = "masterid=$masterid";
		ShowApplication($flashvars, 'recorder', 'sansrecorder', '100%', false);
	}
	
	public function actionRecord()
	{
		if(isset($_GET['courseid']))
		{
			$course = getdbo('Object', $_GET['courseid']);
			$folder = userRecordingFolder($course);
			
			$_REQUEST['parentid'] = $folder->id;
			unset($_GET['courseid']);
		}
		
		if(isset($_GET['id']))
		{
			$_REQUEST['parentid'] = $_GET['id'];
			unset($_GET['id']);
		}
		
		$this->render('show');
	}

	public function actionOpenFile()
	{
		$_REQUEST['recordid'] = $_GET['id'];
		unset($_GET['id']);
		
		$this->render('show');
	}

	public function actionOpenMaster()
	{
		$_REQUEST['masterid'] = $_GET['id'];
		unset($_GET['id']);
		
		$this->render('show');
	}

	public function actionScreenCapture()
	{
		$this->render('screencapture');
	}

	public function actionShowLive()
	{
		include "showlive.php";
		//$this->render('showlive');
	}

	////////////////////////////////////////////////////////////////////

	public function actionInternalNew()
	{
		$phpsessid = session_id();
		$user = getUser();
		$session = getdbosql('Session', "phpsessid='$phpsessid'");
		
		$questionid = getparam('questionid');
	
		dborun("delete from RecordSession 
			where sessionid=$session->id and fileid=0 and userid=$user->id");
		
		if($questionid)
			$pattern = SANSSPACE_TEMP."/phpsessid=$phpsessid&questionid=$questionid*";
		else
			$pattern = SANSSPACE_TEMP."/phpsessid=$phpsessid*";
		
		foreach(glob($pattern) as $filename)
		{
			debuglog("delete $filename");
			$b = @unlink($filename);
			if(!$b)
			{
				sleep(2);
				@unlink($filename);
			}
		}
	}

	public function actionInternalDeleteSelection()
	{
		$phpsessid = session_id();

		$startpos = intval(getparam('startpos'));
		$endpos = intval(getparam('endpos'));
		$insert = getparam('insert');

		sendMessageSansspace("DELETESELECTION Recording",
			"phpsessid=$phpsessid&startpos=$startpos&endpos=$endpos&insert=$insert");
	}

	public function actionInternalInsertBlank()
	{
		$phpsessid = session_id();

		$pos = intval(getparam('pos'));
		$duration = intval(getparam('duration'));
		
		sendMessageSansspace("INSERTBLANK Recording",
			"phpsessid=$phpsessid&pos=$pos&duration=$duration");
	}

	public function actionInternalRemoveBlanks()
	{
		$phpsessid = session_id();
		sendMessageSansspace("REMOVEBLANKS Recording", "phpsessid=$phpsessid");
	}

	public function actionInternalInsertFile()
	{
		$phpsessid = session_id();

		$pos = intval(getparam('pos'));
		$fileid = getparam('fileid');
		
		sendMessageSansspace("INSERTFILE Recording",
			"phpsessid=$phpsessid&pos=$pos&fileid=$fileid");
	}

	public function actionInternalMergeFiles()
	{
		$phpsessid = session_id();

		$audioid = getparam('audioid');
		$videoid = getparam('videoid');
		
		sendMessageSansspace("MERGEFILES Recording",
			"phpsessid=$phpsessid&audioid=$audioid&videoid=$videoid");
	}

	public function actionInternalResizeVideo()
	{
		$phpsessid = session_id();

		$size = getparam('size');
		$gop = getparam('gop');
		$codec = getparam('codec');
		$quality = getparam('quality');
		
		sendMessageSansspace("RESIZEVIDEO Recording",
			"phpsessid=$phpsessid&size=$size&gop=$gop&codec=$codec&quality=$quality");
	}

	////////////////////////////////////////////////////////////////////

	public function actionInternalOpen()
	{
		$phpsessid = session_id();
		$user = getUser();

		$fileid = getparam('id');
		$file = getdbo('VFile', $fileid);

		if(!$file) return;
		copyFile2Temp($file);
		
		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');

		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";

		echo File2Xml($file);
		echo "</objects>";
	}

	public function actionInternalSave()
	{
//		debuglog(__METHOD__);
		$phpsessid = session_id();
		$user = getUser();
		$session = getdbosql('Session', "phpsessid='$phpsessid'");

		$masterid = getparam('masterid');
		$parentid = getparam('parentid');
		
		if(param('keepfileextension'))
			$name = str_replace('.flv', '', getparam('name')).'.flv';
		else
			$name = str_replace('.flv', '', getparam('name'));
		
		if(!$parentid)
			$parentid = $user->folderid;

		$fileid = getparam('fileid');
		$file = getdbo('VFile', $fileid);

		if(!$file)
		{
			$file = safeCreateFile($name, $parentid, '.flv', $masterid);
		}

		else
		{
			if(!controller()->rbac->objectAction($file, 'edit'))
				return;
				
			$file->name = $name;
			$file->parentid = $parentid;
			$file->originalid = $masterid;
			$file->updated = now();
			$file->update();
			
			$indexname = objectPathnameIndex($file);
			@unlink($indexname);
			
			$thumbnailpath = objectPathnameThumbnail($file);
			delete_folder($thumbnailpath);
		}

		$filename = objectPathname($file);
		$fileindex = objectPathnameIndex($file);
		
		@unlink($filename);
		@unlink($fileindex);
		
		$inname = SANSSPACE_TEMP."/phpsessid=$phpsessid.flv";
		debuglog("copy $inname, $filename");
		@copy($inname, $filename);

		$file = scanFile($file);
		
		dborun("update RecordSession set fileid=$file->id 
			where sessionid=$session->id and fileid=0 and userid=$user->id");

		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');

		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";
		echo File2Xml($file);
		echo "</objects>";
	}

	public function actionInternalSavechat()
	{
	//	debuglog($_REQUEST);
		$phpsessid = session_id();
		$user = getUser();

		$parentid = getparam('parentid');
		$name = getparam('name');
		
		$folder = safeCreateObject($name, $parentid);
		$master = safeCreateFile("Chat-$user->name.flv", $folder->id, SANSSPACE_TEMP."/phpsessid=$phpsessid&chat.flv");

		$pattern = SANSSPACE_TEMP."/phpsessid=$phpsessid&chat=live-*";
		foreach(glob($pattern) as $filename)
		{
			preg_match('/&chat=live-([0-9]*)-([0-9]*)\.flv$/', $filename, $match);
			$session = getdbo('Session', $match[2]);
			
			safeCreateFile("Chat-{$session->user->name}.flv", $folder->id, $filename, $master->id);
		}
	}

	////////////////////////////////////////////////////////////

	public function actionInternalGuessFolder()
	{
		$user = getUser();
		
		$filetype = getparam('filetype');
		$parentid = getparam('parentid');
		
	//	debuglog("actionInternalGuessFolder() $filetype, $parentid");
		
		if($parentid)
		{
			$parent = getdbo('Object', $parentid);
			if(!$parent) return;
			
			$name = 'untitled - '.date('Y-m-d h:i');
			
			if(	!controller()->rbac->objectAction($parent, 'create') &&
				!controller()->rbac->objectAction($parent, 'createforum'))
				$parentid = 'myfolders';
		}
		else
		{
			$parentid = 'myfolders';
			$masterid = getparam('masterid');
			if(!$masterid) $masterid = getparam('id');

		//	debuglog("actionInternalGuessFolder2() $masterid, $parentid");
				
			$master = getdbo('Object', $masterid);
			if(!$master) return;
	
			$name = param('defaultprefix').' - '.removeExtension($master->name);
		//	if($this->rbac->objectAction($master->parent, 'create'))
			if($this->rbac->objectUrl($master->parent, 'recorder', 'record'))
			{
				$parentid = $master->parentid;
				$name = param('commentprefix').' - '.removeExtension($master->name);
			}
	
			else
			{
				$semester = getCurrentSemester();
				foreach($user->courseenrollments as $e)
				{
					if($e->object->type != CMDB_OBJECTTYPE_COURSE) continue;
					$course = $e->object->course;
			
					if(isCourseOutOfDate($course)) continue;
					if($course->semesterid && $course->semesterid != $semester->id) continue;
					
					if(isCourseHasObject($course, $master))
					{
						$folder = userRecordingFolder($course);
						$parentid = $folder->id;
						
					//	break;
					}
				}
			}

			if($filetype == CMDB_FILETYPE_BOOKMARKS)
			{
				$bookmarkprefix = param('bookmarkprefix');
				if(!empty($bookmarkprefix))
					$name = "$bookmarkprefix - ".removeExtension($master->name);
				else
					$name = $master->name;
			}
		}
		
		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<object><parentid>$parentid</parentid><name>$name</name></object>";
		
	//	debuglog("$parentid, $name");
	}
	
	public function actionInternalListMenu()
	{
		$phpsessid = session_id();
		$user = getUser();
		
		if(isset($_GET['semesterid']))
			$semesterid = $_GET['semesterid'];
		else
		{
			$semester = getCurrentSemester();
			$semesterid = $semester->id;
		}
		
		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		
		$parentid = getparam('parentid');
		
		echo "<objects>";

		if(controller()->rbac->globalAdmin())
		{
			echo "<object><id>mycourses</id><name>My Courses</name></object>";
			echo "<object><id>myfolders</id><name>My Saved Work</name></object>";
			echo "<object><id>1</id><name>All Resources</name></object>";
		}
		
		else if(controller()->rbac->globalTeacher())
		{
// 			$list = objectList('mycourses');
// 			foreach($list as $course)
// 			{
// 				echo "<object><id>$course->id</id><name>$course->name</name></object>";
				
// 				$folder = $course->recording;
// 				echo "<object><id>$folder->id</id><name>Students' Work ($course->name)</name></object>";
// 			}

			echo "<object><id>mycourses</id><name>My Courses</name></object>";
			echo "<object><id>myfolders</id><name>Students' Work</name></object>";
			
			echo "<object><id>mylocations</id><name>Other Resources</name></object>";
			echo "<object><id>$user->folderid</id><name>My Practice Folder</name></object>";
		}
		
		else
		{
			foreach($user->courseenrollments as $enrollment)
			{
				if($enrollment->object->type != CMDB_OBJECTTYPE_COURSE) continue;
				$course = $enrollment->object->course;
					
				if($course->semesterid != $semesterid && $course->semesterid != 0 && $semesterid != 0)
					continue;
					
				if(isCourseOutOfDate($enrollment->object)) continue;
				
				$folder = userRecordingFolder($course, $user);
				echo "<object><id>$folder->id</id><name>$course->name</name></object>";
			}
			
			echo "<object><id>$user->folderid</id><name>My Practice Folder</name></object>";
		}

		echo "</objects>";
	}
	
	public function actionInternalListObject()
	{
		$phpsessid = session_id();
		$user = getUser();

		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');

		echo "<?xml version='1.0' encoding='utf-8' ?>";

		$id = getparam('id');
		$write = getparam('write');
		$filetype = getparam('filetype');
		
		$objects = objectList($id);
		echo "<objects>";

		foreach($objects as $o)
		{
		//	debuglog("$o->name");
			if($filetype > 0 && $o->type == CMDB_OBJECTTYPE_FILE)
			{
				$file = getdbo('VFile', $o->id);
				if($file->filetype != $filetype)
					continue;
			}
			
			$show = controller()->rbac->objectAction($o);
			$update = controller()->rbac->objectAction($o, 'update');

			if(($write && $update) || (!$write && $show))
				echo Object2Xml($o);
		}

		echo "</objects>";
	}

	////////////////////////////////////////////////////////////

	public function actionInternalListParent()
	{
	//	debuglog(__METHOD__);
		$user = getUser();
		
		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');

		$id = getparam('id');
		$write = getparam('write');

		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";

		$object = getdbo('Object', $id);
		if($object)
		{
// 			if($object->parent->recordings)
// 				$object->name = "{$object->parent->parent->name} Saved Work";
				
		//	debuglog("$object->name");
			$object = filterRecordingName($object);
		//	debuglog("$object->name");
			echo Object2Xml($object);
			
			$parent = $object->parent;
			$show = controller()->rbac->objectAction($parent);
			$update = controller()->rbac->objectAction($parent, 'update');
				
			if(($write && $update) || (!$write && $show))
			{
// 				if($parent->parent->recordings)
// 					$parent->name = "{$parent->parent->parent->name} Saved Work";
			
				$parent = filterRecordingName($parent);
				echo Object2Xml($parent);
			}
		}
		else
		{
			$name = $id;
			if($name == 'mylocations')
				$name = 'My Locations';
			
			else if($name == 'myfolders')
				$name = 'My Saved Work';
			
			else if($name == 'mycourses')
				$name = 'My Courses';
			
			echo "<object>
			<id>$id</id>
			<name>$name</name>
			<type>0</type>
			<message></message>
			</object>";
		}

		echo "</objects>";
	}

// 	public function actionInternalStream()
// 	{
// 		$name = getparam('name');
// 		$fileid = getparam('fileid');
// 		$parentid = getparam('parentid');
		
// 		$file = getdbo('VFile', $fileid);
// 		if(!$file)
// 			$file = safeCreateFile($name, $parentid, '.flv', 0, CMDB_FILETYPE_LIVE);
// 		else
// 		{
// 			$file->filetype = CMDB_FILETYPE_LIVE;
// 			$file->update();
// 		}

// 		header("Content-Type: text/xml");
// 		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
// 		header('Pragma: no-cache');

// 		echo "<?xml version='1.0' encoding='utf-8' ? >";
// 		echo "<objects>";

// 		echo File2Xml($file);
// 		echo "</objects>";
// 	}
	
	
}





