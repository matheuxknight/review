<?php

class SimplexmlController extends CommonController
{
	public $defaultAction = 'query';
	
	private $resultxml_success = "<?xml version='1.0' encoding='utf-8'?><methodResponse><status>200</status></methodResponse>";
	private $resultxml_unauthorized = "<?xml version='1.0' encoding='utf-8'?><methodResponse><status>401</status><error>Unauthorized</error></methodResponse>";
	private $resultxml_notfound = "<?xml version='1.0' encoding='utf-8'?><methodResponse><status>404</status><error>Not found</error></methodResponse>";
	private $resultxml_conflict = "<?xml version='1.0' encoding='utf-8'?><methodResponse><status>409</status><error>Conflict</error></methodResponse>";
	
	public function actionQuery()
	{
	//	debuglog(__METHOD__);
		
		$postdata = file_get_contents("php://input");
		$postdata = trim($postdata);
	//	debuglog($postdata);
		$xml = simplexml_load_string($postdata);
		
		$method = (string)$xml->methodName;
		if($method != 'login')
		{
			$token = addslashes((string)$xml->token);
			$user = getdbosql('User', "guid='$token'");
			if(!$user) return $this->sendData($this->resultxml_unauthorized);
		}
		
		$this->$method($xml->params);
	}
	
	/////////////////////////////////////////////////////////////////////////

	private function internal_logon($logon, $password)
	{
	//	debuglog("internal_logon($logon, ...)");
		
		if(empty($logon)) return null;
// 		if(MD5($password) == SANSSPACE_UDID)
// 		{
// 			$user = getdbosql('User', "logon='$logon'");
// 			if($user) return $user;
// 		}
		
		$domains = getdbolist('Domain', "enable order by displayorder");
		foreach($domains as $domain)
		{
			if(empty($password))
			{
				$user = getdbosql('User', 
					"domainid=$domain->id and logon='$logon' and password=''");
				
				if(!$user) $user = getdbosql('User', 
					"domainid=$domain->id and logon='$logon@$domain->name' and password=''");
			}
			
			if(!$user) $user = getdbosql('User', 
				"domainid=$domain->id and logon='$logon' and password=MD5('$password')");
				
			if(!$user) $user = getdbosql('User', 
				"domainid=$domain->id and logon='$logon@$domain->name' and password=MD5('$password')");
			
			if($user) return $user;
		}

		return null;
	}
	
	private function login($params)
	{
	//	debuglog(__METHOD__);
		
		$logon = addslashes((string)$params->logon);
		$password = addslashes((string)$params->password);
		
		$user = $this->internal_logon($logon, $password);
		if(!$user) return $this->sendData($this->resultxml_unauthorized);

		$user->guid = base64_encode(uniqid('', true));
		$user->save();
		
		$xml = simplexml_load_string($this->resultxml_success);
		$xml->addChild('token', $user->guid);
		
		return $this->sendData($xml->asXML());
	}
	
	private function get_user($params)
	{
	//	debuglog(__METHOD__);
		
		$user = $this->paramsToUser($params);
		if(!$user) return $this->sendData($this->resultxml_notfound);
		
		$this->sendUser($user);
	}
	
	private function create_user($params)
	{
	//	debuglog(__METHOD__);
		
		$user = safeCreateUser((string)$params->logon, (string)$params->name, 
			(string)$params->email, (int)$params->domainid);
		$user->custom1 = (string)$params->customuserid;
		
		$user->save();
		$this->sendUser($user);
	}
	
	private function update_user($params)
	{
	//	debuglog(__METHOD__);

		$user = $this->paramsToUser($params);
		if(!$user) return $this->sendData($this->resultxml_notfound);

		if(isset($params->customuserid)) $user->custom1 = (string)$params->customuserid;
		if(isset($params->name)) $user->name = (string)$params->name;
		if(isset($params->email)) $user->email = (string)$params->email;
		if(isset($params->domainid)) $user->domainid = (int)$params->domainid;
		
		if(isset($params->enable)) $user->enable = (int)$params->enable;
		if(isset($params->usedate)) $user->userdate = (int)$params->usedate;
		if(isset($params->startdate)) $user->startdate = (string)$params->startdate;
		if(isset($params->enddate)) $user->enddate = (string)$params->enddate;
		
		$user->save();
		$this->sendUser($user);
	}
	
	private function delete_user($params)
	{
	//	debuglog(__METHOD__);
		
		$user = $this->paramsToUser($params);
		if(!$user) return $this->sendData($this->resultxml_notfound);
		
		userDelete($user);
		return $this->sendData($this->resultxml_success);
	}
	
	/////////////////////////////////////////////////////////////////////////
	
	private function get_semester($params)
	{
		$semester = getdbo('Semester', (int)$params->id);
		if(!$semester) return $this->sendData($this->resultxml_notfound);
		
		$this->sendSemester($semester);
	}
	
	private function get_semester_list($params)
	{
	//	debuglog(__METHOD__);
		
		$semesters = getdbolist('Semester');
		$xml = simplexml_load_string($this->resultxml_success);
		
		foreach($semesters as $semester)
			$this->semesterToXml($xml, $semester);
		
		$this->sendData($xml->asXML());
	}
	
	private function get_semester_course_list($params)
	{
	//	debuglog(__METHOD__);
		
		$semester = getdbo('Semester', (int)$params->id);
		if(!$semester) $courses = getdbolist('VCourse', "semesterid=0");
		else $courses = getdbolist('VCourse', "semesterid=$semester->id");
		$xml = simplexml_load_string($this->resultxml_success);
		
		foreach($courses as $course)
			$this->courseToXml($xml, $course);
		
		$this->sendData($xml->asXML());
	}
	
	private function create_semester($params)
	{
	//	debuglog(__METHOD__);
		
		$name = addslashes((string)$params->name);
		$semester = getdbosql('Semester', "name='$name'");
		
		if(!$semester)
		{
			$semester = new Semester;
			$semester->name = (string)$params->name;
		}
		
		$semester->starttime = (string)$params->startdate;
		$semester->endtime = (string)$params->enddate;
		
		$semester->save();
		$this->sendSemester($semester);
	}
	
	private function update_semester($params)
	{
	//	debuglog(__METHOD__);

		$semester = getdbo('Semester', (int)$params->id);
		if(!$semester) return $this->sendData($this->resultxml_notfound);

		if(isset($params->name)) $semester->name = (string)$params->name;
		if(isset($params->startdate)) $semester->starttime = (string)$params->startdate;
		if(isset($params->enddate)) $semester->endtime = (string)$params->enddate;
		
		$semester->save();
		$this->sendSemester($semester);
	}
	
	private function delete_semester($params)
	{
	//	debuglog(__METHOD__);

		$semester = getdbo('Semester', (int)$params->id);
		if(!$semester) return $this->sendData($this->resultxml_notfound);

		$semester->delete();
		return $this->sendData($this->resultxml_success);
	}
	
	/////////////////////////////////////////////////////////////////////////
	
	private function get_object($params)
	{
		$object = $this->paramsToObject($params);
		if(!$object) return $this->sendData($this->resultxml_notfound);
		
		$this->sendObject($object);
	}
	
	private function get_object_list($params)
	{
	//	debuglog(__METHOD__);
		
		$object = $this->paramsToObject($params);
		if(!$object) return $this->sendData($this->resultxml_notfound);
		
		$objects = getdbolist('Object', "parentid=$object->id");
		$xml = simplexml_load_string($this->resultxml_success);
		
		foreach($objects as $object)
			$this->objectToXml($xml, $object);
		
		$this->sendData($xml->asXML());
	}
	
	private function create_object($params)
	{
	//	debuglog(__METHOD__);
		
		$object = getdbo('Object', (int)$params->parentid);
		if(!$object) return $this->sendData($this->resultxml_notfound);
		
		$object = objectCreate((string)$params->name, (int)$params->parentid);
		
		$object->tags = (string)$params->tags;
		$object->post = (int)$params->ispost;
		$object->hidden = (int)$params->ishidden;
		$object->model = (int)$params->model;
		$object->displayorder = (int)$params->displayorder;
		$object->linkid = (int)$params->linkid;
		$object->save();
		
		$object->ext->custom = (string)$params->customid;
		$object->ext->doctext = (string)$params->doctext;
		$object->ext->save();
		
		$this->sendObject($object);
	}
	
	private function update_object($params)
	{
	//	debuglog(__METHOD__);
		
		$object = $this->paramsToObject($params);
		if(!$object) return $this->sendData($this->resultxml_notfound);
		
		if(isset($params->parentid)) $object->parentid = (int)$params->parentid;
		if(isset($params->name)) $object->name = (string)$params->name;
		if(isset($params->tags)) $object->tags = (string)$params->tags;
		if(isset($params->ispost)) $object->post = (int)$params->ispost;
		if(isset($params->ishidden)) $object->hidden = (int)$params->ishidden;
		if(isset($params->model)) $object->model = (int)$params->model;
		if(isset($params->displayorder)) $object->displayorder = (int)$params->displayorder;
		if(isset($params->linkid)) $object->linkid = (int)$params->linkid;
		$object->save();
		
		if(isset($params->customid)) $object->ext->custom = (string)$params->customid;
		if(isset($params->doctext)) $object->ext->doctext = (string)$params->doctext;
		$object->ext->save();
		
		scanObjectBackground($object); 
		$this->sendObject($object);
	}
	
	private function delete_object($params)
	{
	//	debuglog(__METHOD__);
		
		$object = $this->paramsToObject($params);
		if(!$object) return $this->sendData($this->resultxml_notfound);
		
		objectDelete($object);
		return $this->sendData($this->resultxml_success);
	}
	
	/////////////////////////////////////////////////////////////////////
	
	private function create_course($params)
	{
	//	debuglog(__METHOD__);
		
		$object = getdbo('Object', (int)$params->parentid);
		if(!$object) return $this->sendData($this->resultxml_notfound);

		$course = safeCreateCourse((string)$params->name, (int)$params->parentid, 
			(int)$params->semesterid);

		$course->tags = (string)$params->tags;
		$course->hidden = (int)$params->ishidden;
		$course->model = (int)$params->model;
		$course->displayorder = (int)$params->displayorder;
		$course->linkid = (int)$params->linkid;
		$course->save();
		
		$course->ext->custom = (string)$params->customid;
		$course->ext->doctext = (string)$params->doctext;
		$course->ext->save();
		
		$this->sendObject($course);
	}
	
	private function update_course($params)
	{
	//	debuglog(__METHOD__);
		
		$object = $this->paramsToObject($params);
		if(!$object) return $this->sendData($this->resultxml_notfound);
		
		$rcourse = getdbo('Course', $object->id);
		if(!$rcourse) return $this->sendData($this->resultxml_notfound);
		
		if(isset($params->tags)) $object->tags = (string)$params->tags;
		if(isset($params->parentid)) $object->parentid = (int)$params->parentid;
		if(isset($params->name)) $object->name = (string)$params->name;
		if(isset($params->ishidden)) $object->hidden = (int)$params->ishidden;
		if(isset($params->model)) $object->model = (int)$params->model;
		if(isset($params->displayorder)) $object->displayorder = (int)$params->displayorder;
		if(isset($params->linkid)) $object->linkid = (int)$params->linkid;
		$object->save();
		
		if(isset($params->customid)) $object->ext->custom = (string)$params->customid;
		if(isset($params->doctext)) $object->ext->doctext = (string)$params->doctext;
		$object->ext->save();
		
		if(isset($params->semesterid)) $rcourse->semesterid = (int)$params->semesterid;
		$rcourse->save();
		
		scanObjectBackground($object); 
		$this->sendObject($object);
	}
	
	/////////////////////////////////////////////////////////////////////
	
	private function get_course_enrollments($params)
	{
	//	debuglog(__METHOD__);
	
		$object = $this->paramsToObject($params);
		$es = getdbolist('CourseEnrollment', "objectid=$object->id");

		$xml = simplexml_load_string($this->resultxml_success);
		foreach($es as $e)
			$this->userToXml($xml, $e->user, $e->role->name);
		
		$this->sendData($xml->asXML());
	}
	
	private function enroll_course($params)
	{
	//	debuglog(__METHOD__);
	
		$object = $this->paramsToObject($params);
		if(!$object) return $this->sendData($this->resultxml_notfound);
		
		$user = $this->paramsToUser($params);
		if(!$user) return $this->sendData($this->resultxml_notfound);
		
		$roleid = SSPACE_ROLE_STUDENT;
		if(isset($params->role))
		{
			$rolename = addslashes((string)$params->role);
			
			$role = getdbosql('Role', "name='$rolename'");
			if(!$role) return $this->sendData($this->resultxml_notfound);
			
			$roleid = $role->id;
		}
		
		safeCourseEnrollment($user->id, $roleid, $object->id);
		return $this->sendData($this->resultxml_success);
	}
	
	private function unenroll_course($params)
	{
	//	debuglog(__METHOD__);
	
		$object = $this->paramsToObject($params);
		if(!$object) return $this->sendData($this->resultxml_notfound);
		
		$user = $this->paramsToUser($params);
		if(!$user) return $this->sendData($this->resultxml_notfound);
				
		$e = getdbosql('CourseEnrollment', "userid=$user->id and objectid=$object->id");
		if(!$e) return $this->sendData($this->resultxml_notfound);
		
		$e->delete();
		return $this->sendData($this->resultxml_success);
	}
	
	/////////////////////////////////////////////////////////////////////
	
	private function paramsToUser($params)
	{
		if(isset($params->userid))
			$user = getdbo('User', (int)$params->userid);
		
		else if(isset($params->customuserid))
		{
			$customid = addslashes((string)$params->customuserid);
			$user = getdbosql('User', "custom1='$customid'");
		}
		
		else if(isset($params->logon))
		{
			$logon = addslashes((string)$params->logon);
			$user = getdbosql('User', "logon='$logon'");
		}
		
		return $user;
	}
	
	private function paramsToObject($params)
	{
		if(isset($params->id))
			$object = getdbo('Object', (int)$params->id);
		
		else if(isset($params->customid))
		{
			$customid = addslashes((string)$params->customid);
			$objectext = getdbosql('ObjectExt', "custom='$customid'");
			$object = getdbo('Object', $objectext->objectid);
		}
		
		else if(isset($params->parentid) && isset($params->name))
		{
			$name = addslashes((string)$params->name);
			$parentid = (int)$params->parentid;
			$object = getdbosql('Object', "name='$name' and parentid=$parentid");
		}
		
		return $object;
	}
	
	//////////////////////////////////////////////////////////////////////

	private function sendData($textxml)
	{
		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
		
	//	echo $textxml;
	//	return;
	
	//	debuglog($textxml);
		
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($textxml);
		echo $dom->saveXML();
	}
	
	private function sendUser($user)
	{
		$xml = simplexml_load_string($this->resultxml_success);
		$this->userToXml($xml, $user);
		
		$this->sendData($xml->asXML());
	}
	
	private function sendSemester($semester)
	{
		$xml = simplexml_load_string($this->resultxml_success);
		$this->semesterToXml($xml, $semester);
		
		$this->sendData($xml->asXML());
	}
	
	private function sendObject($object)
	{
		$xml = simplexml_load_string($this->resultxml_success);
		$this->objectToXml($xml, $object);

		$this->sendData($xml->asXML());
	}
	
	private function sendCourse($course)
	{
		$xml = simplexml_load_string($this->resultxml_success);
		$this->courseToXml($xml, $course);
		
		$this->sendData($xml->asXML());
	}
	
	private function sendFile($file)
	{
		$xml = simplexml_load_string($this->resultxml_success);
		$this->fileToXml($xml, $file);
		
		$this->sendData($xml->asXML());
	}
	
	//////////////////////////////////////////////////////////////////////

	private function userToXml($xml, $user, $role='user')
	{
		$x = $xml->addChild($role);
		$x->addChild('userid', $user->id);
 		$x->addChild('customuserid', $user->custom1);
		$x->addChild('logon', $user->logon);
		$x->addChild('name', $user->name);
		$x->addChild('email', $user->email);
		$x->addChild('domainid', $user->domainid);
		$x->addChild('folderid', $user->folderid);
		$x->addChild('created', $user->created);
		$x->addChild('accessed', $user->accessed);
		$x->addChild('coursecount', $user->getCurrentCourseCount());
		return $xml;
	}
	
	private function objectToXml($xml, $object)
	{
		switch($object->type)
		{
			case CMDB_OBJECTTYPE_COURSE:
				return $this->courseToXml($xml, $object->course);
					
			case CMDB_OBJECTTYPE_FILE:
				return $this->fileToXml($xml, $object->file);
		}

		if($object->linkid)
			$x = $xml->addChild('link');
		else
			$x = $xml->addChild('object');
		
		$x->addChild('id', $object->id);
		$x->addChild('customid', $object->ext->custom);
		$x->addChild('parentid', $object->parentid);
		$x->addChild('authorid', $object->authorid);
		$x->addChild('name', htmlspecialchars($object->name));
		$x->addChild('tags', $object->tags);
	//	$x->addChild('doctext', "<![CDATA[{$object->ext->doctext}]]>");
		$x->addChild('doctext', base64_encode($object->ext->doctext));
		$x->addChild('created', $object->created);
		$x->addChild('updated', $object->updated);
		$x->addChild('accessed', $object->accessed);

		$x->addChild('views', $object->ext->views);
		$x->addChild('size', $object->size);
		$x->addChild('duration', $object->duration);
		$x->addChild('displayorder', $object->displayorder);
		$x->addChild('model', $object->model);

		$x->addChild('ispost', $object->post);
		$x->addChild('isrecording', $object->recordings);
		$x->addChild('ishidden', $object->hidden);
		$x->addChild('isdeleted', $object->deleted);
		
		$x->addChild('importid', $object->folderimportid);
		$x->addChild('pathname', $object->pathname);
		$x->addChild('linkid', $object->linkid);
		
		return $xml;
	}
	
	private function courseToXml($xml, $course)
	{
		$x = $xml->addChild('course');
		
		$x->addChild('id', $course->id);
		$x->addChild('customid', $course->ext->custom);
		$x->addChild('parentid', $course->parentid);
		$x->addChild('authorid', $course->authorid);
		$x->addChild('name', htmlspecialchars($course->name));
		$x->addChild('tags', $course->tags);
	//	$x->addChild('doctext', "<![CDATA[{$course->ext->doctext}]]>");
		$x->addChild('doctext', base64_encode($course->ext->doctext));
		$x->addChild('created', $course->created);
		$x->addChild('updated', $object->updated);
		$x->addChild('accessed', $course->accessed);

		$x->addChild('views', $course->ext->views);
		$x->addChild('size', $course->size);
		$x->addChild('duration', $course->duration);
		$x->addChild('displayorder', $course->displayorder);
		$x->addChild('model', $course->model);

		$x->addChild('isdeleted', $course->deleted);
		$x->addChild('ishidden', $course->hidden);
		
		$x->addChild('semesterid', $course->semesterid);
		$x->addChild('recordingid', $course->recordingid);
		$x->addChild('chatid', $course->callid);
		
		$enrollments = getdbolist('CourseEnrollment', "objectid=$course->id and roleid=".SSPACE_ROLE_TEACHER);
		if($enrollments) foreach($enrollments as $e)
		{
			if(!$e->user) continue;
			$this->userToXml($x, $e->user, 'teacher');
		}
		
		return $xml;
	}
	
	private function fileToXml($xml, $file)
	{
		$x = $xml->addChild('file');
		
		$x->addChild('id', $file->id);
		$x->addChild('customid', $file->ext->custom);
		$x->addChild('parentid', $file->parentid);
		$x->addChild('authorid', $file->authorid);
		$x->addChild('name', htmlspecialchars($file->name));
		$x->addChild('tags', $file->tags);
	//	$x->addChild('doctext', "<![CDATA[{$file->ext->doctext}]]>");
		$x->addChild('doctext', base64_encode($file->ext->doctext));
		$x->addChild('created', $file->created);
		$x->addChild('updated', $object->updated);
		$x->addChild('accessed', $file->accessed);

		$x->addChild('views', $file->ext->views);
		$x->addChild('size', $file->size);
		$x->addChild('duration', $file->duration);
		$x->addChild('displayorder', $file->displayorder);

		$x->addChild('isdeleted', $file->deleted);
		$x->addChild('ishidden', $file->hidden);
		$x->addChild('importid', $file->folderimportid);
		$x->addChild('pathname', $file->pathname);
		
		$x->addChild('filetype', $file->filetype);
		$x->addChild('mimetype', $file->mimetype);
		$x->addChild('bitrate', $file->bitrate);
		$x->addChild('audiocodec', $file->audiocodec);
		$x->addChild('videocodec', $file->videocodec);
		$x->addChild('width', $file->width);
		$x->addChild('height', $file->height);
		$x->addChild('framerate', $file->framerate);
		$x->addChild('pixelratio', $file->pixelratio);
		$x->addChild('displayratio', $file->displayratio);
		$x->addChild('masterid', $file->originalid);
		
		return $xml;
	}
	
	private function semesterToXml($xml, $semester)
	{
		$x = $xml->addChild('semester');
		
		$x->addChild('id', $semester->id);
		$x->addChild('name', $semester->name);
		$x->addChild('startdate', $semester->starttime);
		$x->addChild('enddate', $semester->endtime);
		
		return $xml;
	}
	
	/////////////////////////////////////////////////////////////////////////
	
	public function actionDebug()
	{
	//	$fp = @fsockopen(SERVER_LOCALHOST, SANSSPACE_HTTPIPORT);
		if(!$fp) return;
		
		debuglog("here");
	
	$xml = <<<END
<?xml version="1.0"?>
<methodCall>
	<token>NTI4YTgwN2ViNTY3YzUuMjI1MzYwMjE=</token>
	<methodName>get_object_list</methodName>
	<params>
		<id>1</id>
	</params>
</methodCall>

END;

		$length = strlen($xml);
		$sitename = SANSSPACE_ALIASNAME;
	
		$out  = "POST /simplexml HTTP/1.1\r\n";
		$out .= "Host: $sitename\r\n";
		$out .= "Content-Type: text/xml\r\n";
		$out .= "Content-Length: $length\r\n\r\n";
		$out .= $xml;
		$out .= "\r\n\r\n";
	
		//	debuglog($out);
		fwrite($fp, $out);
		while(!feof($fp))
		{
			$readbuffer = fread($fp, 2048);
			echo $readbuffer;
		}
		
		fclose($fp);
	}
	
	
}


// $xml = <<<END
//< ? // xml version="1.0"? >
// <methodCall>
//   <token>NTFiMDg2YWM1M2UyMDYuNzc0MDEwOTY=</token>
//   <methodName>create_course</methodName>
//   <params>
//     <semesterid>14</semesterid>
//     <parentid>93</parentid>

//     <name>FREN 0484A: Culture in Interwar France</name>
//     <doctext><![CDATA[<strong>The Cultural Front in Interwar France</strong><br />
// In this senior seminar we will explore creative works produced in France in the
// 1920s and 1930s.  In close readings of novels, screen plays, songs, comics, and
// essays, we will examine how conflicting notions of popular and elitist culture
// evolved in the years leading up to World War II.  We will pay close attention to
// technological innovation (for example, the advent of sound in film and photography
// in the daily press) and how it changed patterns of culture, production, and
// consumption.  Students will undertake a significant piece of independent research
// to present to the class. (Open to French Senior Majors).
// 3 hrs. lect./disc.]]></doctext>

//     <customid>section/201320/22304</customid>
//   </params>
// </methodCall>
// END;

// $xml = <<<END
//< ? // xml version='1.0' encoding='utf-8'? >
// <methodCall>
// 	<methodName>login</methodName>
// 	<params>
// 		<logon>admin</logon>
// 		<password>mkfdo</password>
// 	</params>
// </methodCall>
// END;

// $xml = <<<END
// < ? // xml version="1.0"? >
// <methodCall>
//   <token>NTFiMDg2YWM1M2UyMDYuNzc0MDEwOTY=</token>
//   <methodName>create_user</methodName>
//   <params>
//     <logon>943ECA4FC732B31E4F1E816A3704589A</logon>
//     <name>William Poulin-Deltour</name>
//     <email>wpoulind@middlebury.edu</email>
//     <domainid>2</domainid>
//   </params>
// </methodCall>
// END;
