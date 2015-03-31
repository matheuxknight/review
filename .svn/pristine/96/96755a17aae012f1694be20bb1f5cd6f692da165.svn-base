<?php

class XmlController extends CommonController
{
	public function actionSavelist()
	{
		$user = getUser();
		if(!$user) return;

		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";

		$id = 0;
		if(isset($_GET['id']))
			$id = $_GET['id'];

		if($id)
		{
			$parent = getdbo('Object', $_GET['id']);
			//Object::model()->findByPk($_GET['id']);
			if(controller()->rbac->objectAction($parent, 'create'))
			{
				if($parent->recordings)
				{
					$course = $parent->parent->parent;
					if($parent->authorid == $user->id)
					{
						if($course->id == CMDB_OBJECTROOT_ID)
							$parent->name = '(personal) '.$user->name;
							
						else if($course->type == CMDB_OBJECTTYPE_COURSE)
							$parent->name = '(course) '.$course->name;
							
					//	else if($course->type == CMDB_OBJECTTYPE_ACTIVITY)
					//		$parent->name = '(activity) '.$course->name;
					}
					
					else
						$parent->name = "({$parent->author->logon}) $course->name";
				}
				
				echo Object2Xml($parent);
			}
		}
		
		$courses = getdbolist('Object', "type=".CMDB_OBJECTTYPE_COURSE.
			" and id in (select objectid from CourseEnrollment where userid=$user->id)");
	
		$semester = getCurrentSemester();
		foreach($courses as $course)
		{
			$course = $course->course;
			$courseid = $course->id;
			$course->name = '(course) '.$course->name;
			$course->id = userRecordingFolder($course)->id;

			if($semester && $course->semesterid &&
				$course->semesterid != $semester->id)
				continue;
			
			if($course->id != $id)
				echo Object2Xml($course);
	
// 			$activities = getdbolist('Object', "type=".CMDB_OBJECTTYPE_ACTIVITY.
// 				" and parentlist like '%, {$courseid}, %' and id in (select objectid from CourseEnrollment where userid=$user->id)");
	
// 			foreach($activities as $activity)
// 			{
// 				$activity->name = '(activity) '.$activity->name;
// 				$activity->id = userRecordingFolder($activity)->id;
				
// 				if($activity->id != $id)
// 					echo Object2Xml($activity);
// 			}
		}
	
		$folder = $user->folder; 
		if($id != $folder->id)
		{
			$folder->name = '(personal) '.$user->name;
			echo Object2Xml($folder);
		}
		
		echo "</objects>";
	}

	public function actionTeacherCourselist()
	{
		$user = getUser();
		if(!$user) return;

		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";

		$courses = getdbolist('VCourse', "type=".CMDB_OBJECTTYPE_COURSE.
			" and id in (select id from courseenrollment where userid=$user->id and roleid=".
			SSPACE_ROLE_TEACHER.")");
	
		$semester = getCurrentSemester();
		foreach($courses as $course)
		{
			if($semester && $course->semesterid &&
				$course->semesterid != $semester->id)
				continue;
				
			echo Object2Xml($course);
		}
	
		echo "</objects>";
	}

	////////////////////////////////////////////////
	
	public function actionUserinfo()
	{
		$phpsessid = session_id();

		$user = getUser();
		if(!$user) return;

		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";
		echo "<user>
				<id>$user->id</id>
				<name>$user->name</name>
				<logon>$user->logon</logon>
				<phpsessid>$phpsessid</phpsessid>
			</user>";
		echo "</objects>";
	}
	
	////////////////////////////////////////////////////////////////////
	
	public function actionNextMedia()
	{
		$user = getUser();
		if(!$user) return;

		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";
		
		if(isset($_GET['id']))
		{
			$object = getdbo('Object', $_GET['id']);
			if(!$object) die;
			
			$shownext = false;
			
			$objects = getdbolist('Object', "parentid={$object->parentid} and not deleted and not hidden and type=".
				CMDB_OBJECTTYPE_FILE." order by displayorder, name");
				//Object::model()->findAll("parentid={$object->parentid} and not deleted and not hidden and type=".
				//CMDB_OBJECTTYPE_FILE." order by displayorder, name");
			if($objects) foreach($objects as $object2)
			{
				//mydump($object2); die;
				if($object->id == $object2->id)
				{
					$shownext = true;
					continue;
				}
					
				if($shownext && controller()->rbac->objectAction($object2))
				{
					echo Object2Xml($object2);
					break;
				}
			}
			
		}
		
		echo "</objects>";
	}
	
	public function actionObject()
	{
		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
				
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";
		
		if(isset($_GET['id']))
		{
			$object = getdbo('Object', $_GET['id']);
			echo Object2Xml($object);
		}
		
		echo "</objects>";
	}
	
	public function actionFile()
	{
		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
				
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";

		$id = getparam('id');
		$templateid = getparam('templateid');
		
		if($id == 0)
			echo TempFile2Xml();
		
		else
		{
			$file = getdbo('VFile', $id);
			$template = getdbo('TranscodeTemplate', $templateid);
			
			echo File2Xml($file, $template);
		}
		
		echo "</objects>";
	}
	
	public function actionServerInfo()
	{
		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
	
		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";
	
		echo "<object>
			<servertitle>".param('title')."</servertitle>
			<servername>".$_SERVER['HTTP_HOST']."</servername>
			<connect>".getPlayerConnect()."</connect>
			<connecthttp>".getFullServerName()."</connecthttp>

 			<headercolor>".preg_replace('/#/', '0x', param('appheadercolor'))."</headercolor>
 			<headerback>".preg_replace('/#/', '0x', param('appheaderback'))."</headerback>
 			<maincolor>".preg_replace('/#/', '0x', param('appmaincolor'))."</maincolor>
			<mainback>".preg_replace('/#/', '0x', param('appmainback'))."</mainback>
			<mainalpha>".preg_replace('/#/', '0x', param('appmainalpha'))."</mainalpha>
			<slidercolor>".preg_replace('/#/', '0x', param('appslidercolor'))."</slidercolor>
			<bookmarkprefix>".param('bookmarkprefix')."</bookmarkprefix>";

 		$phpsessid = getparam('phpsessid');
 		if($phpsessid)
 		{
 			$session = getdbosql('Session', "phpsessid='$phpsessid'");
 			if($session)
 			{
 				$user = getdbo('User', $session->userid);
// 				controller()->identity->authorize($user);

				echo "<userid>$user->id</userid>
					<username>$user->name</username>
					<userlogon>$user->logon</userlogon>
		 			<userimage>".userImageUrl($user)."</userimage>
					<phpsessid>$phpsessid</phpsessid>";
 				}
 		}
		
 		else if(!user()->isGuest)
 		{
			$phpsessid = session_id();
			$user = getUser();
			
			echo "<userid>$user->id</userid>
				<username>$user->name</username>
				<userlogon>$user->logon</userlogon>
	 			<userimage>".userImageUrl($user)."</userimage>
				<phpsessid>$phpsessid</phpsessid>";
 		}
 		else
 			echo "<userid>0</userid>";
 			
		echo "</object>";
		echo "</objects>";
	}
	

}









