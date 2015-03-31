<?php

class RosterEntry
{
	public $coursename;
	public $foldername;
	public $username;
	public $userlogon;
	public $useremail;
	public $userrole;
	public $teachername;
	public $teacherlogon;
	public $teacheremail;
	public $customcourse;
	public $customuser;
	public $languagename;
	public $roleid;
	
	public function parse($line, $roster)
	{
		eval('$namemap=array('.$roster->languagetable.');');
		
		eval('$this->coursename=trim("'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->coursename).'");');
		eval('$this->foldername=trim("'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->foldername).'");');
	//	eval('languagename="'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->languagename).'");');
		
		eval('$this->username=trim("'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->username).'");');
		eval('$this->userlogon=trim("'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->userlogon).'");');
		$this->userlogon = strtolower($this->userlogon);
		eval('$this->useremail=trim("'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->useremail).'");');
		eval('$this->userrole=trim("'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->userrole).'");');
			
		eval('$this->teachername=trim("'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->teachername).'");');
		eval('$this->teacherlogon=trim("'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->teacherlogon).'");');
		$this->teacherlogon = strtolower($this->teacherlogon);
		eval('$this->teacheremail=trim("'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->teacheremail).'");');
		
		eval('$this->customcourse=trim("'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->customcourse).'");');
		eval('$this->customuser=trim("'.preg_replace('/\$([0-9]*)/', '{\$line[$1]}', $roster->customuser).'");');
		
		if(!empty($this->userrole))
		{
			if(strtolower($this->userrole[0]) == 's') $this->userrole = 'student';
			if(strtolower($this->userrole[0]) == 't') $this->userrole = 'teacher';
			if(strtolower($this->userrole[0]) == 'f') $this->userrole = 'teacher';
			
			$role = getdbosql('Role', "name='$this->userrole'");
			if($role) $this->roleid = $role->id;
		}
		else
		{
			$this->roleid = SSPACE_ROLE_STUDENT;
			$this->userrole = 'student';
		}
		
		if(!empty($roster->extracode))
			eval($roster->extracode);
		
		$this->languagename = 'New Language';
		ereg("(^[A-Za-z]+)", $this->coursename, $match);

		if(isset($namemap[$match[1]]))
			$this->languagename = $namemap[$match[1]];
		
		else
		{
			$this->languagename = $match[1];
			foreach($namemap as $t)
			{
				if(strstr($this->coursename, $t))
				{
					$this->languagename = $t;
					break;
				}
			}
		}
		
	//	debuglog();
		
		$this->coursename = addslashes($this->coursename);
		$this->foldername = addslashes($this->foldername);
		$this->username = addslashes($this->username);
		$this->userlogon = addslashes($this->userlogon);
		$this->useremail = addslashes($this->useremail);
		$this->teachername = addslashes($this->teachername);
		$this->teacherlogon = addslashes($this->teacherlogon);
		$this->teacheremail = addslashes($this->teacheremail);
		$this->customcourse = addslashes($this->customcourse);
		$this->customuser = addslashes($this->customuser);
		$this->languagename = addslashes($this->languagename);
	}
	
}

//////////////////////////////////////////////////////////////////

class RosterController extends CommonController
{
	public $defaultAction = 'admin';
	private $_roster;

	public function actionCreate()
	{
		$defaulttable = "
'ARAB'=>'Arabic',
'CHIN'=>'Chinese',
'FREN'=>'French',
'GERM'=>'German',
'ITAL'=>'Italian',
'JPAN'=>'Japanese',
'PORT'=>'Portuguese',
'RUS' =>'Russian',
'SPAN'=>'Spanish',";
		
		$roster = new Roster;

		$roster->example = 'SPAN101,mwood,"Mary Wood",student';
		$roster->domainid = 1;
		$roster->coursename = '$0';
		$roster->foldername = '';
		$roster->languagename = '';
		$roster->username = '$2';
		$roster->userlogon = '$1';
		$roster->useremail = '$1@school.edu';
		$roster->userrole = '$3';
		$roster->languagetable = $defaulttable;
		
		if(isset($_POST['Roster']))
		{
			$roster->attributes = $_POST['Roster'];
			if($roster->save())
				$this->redirect(array('admin'));
		}
		$this->render('create', array('roster'=>$roster));
	}

	public function actionUpdate()
	{
		$roster = $this->loadroster();
		if(isset($_POST['Roster']))
		{
			$roster->attributes = $_POST['Roster'];
			if($roster->save())
			{
				$filename = GetUploadedFilename();
				if($filename)
				{
					$this->internalProcessFile($filename);
					@unlink($filename);
			
					user()->setFlash('message', 'Roster file processed.');
				}
				
			//	$this->redirect(array('admin'));
			}
		}
		$this->render('update', array('roster'=>$roster));
	}
	
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$roster = $this->loadroster();
			
			$cronjob = getdbo('Cronjob', $roster->cronjobid);
			if ($cronjob)$cronjob->delete();
			
			$roster->delete();
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();
		
		$rosters = getdbolist('Roster');
		$this->render('admin', array('rosters'=>$rosters));
	}

	public function loadroster($id=null)
	{
		if($this->_roster===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_roster=getdbo('Roster', $id!==null ? $id : $_GET['id']);
			//Roster::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_roster===null)
				throw new CHttpException(500,'The requested roster does not exist.');
		}
		return $this->_roster;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$roster = $this->loadroster($_POST['id']);
			
			$cronjob = getdbo('Cronjob', $roster->cronjobid);
			if ($cronjob)$cronjob->delete();
			
			$roster->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
	
	///////////////////////////////////////////////////////////////
	
	public function actionCreateCronJob()
	{
		$roster = $this->loadroster();
	
		$cronjob = new Cronjob;
		$cronjob->name = "Roster $roster->name";
		$cronjob->enable = true;
		$cronjob->url = "/roster/autoprocess&id=$roster->id";
		$cronjob->crontime = "0 3 * * *";
		$cronjob->save();
		
		$roster->cronjobid = $cronjob->id;
		$roster->save();
	
		$this->redirect(array('cronjob/update', 'id'=>$cronjob->id));
	}
	
	public function actionAutoProcess()
	{
		$roster = $this->loadroster();
		$sourcefile = $this->_roster->sourcefile;
		
		if(empty($sourcefile)) return;
		if(is_dir($sourcefile)) $sourcefile .= '/*';
		
		foreach(glob($sourcefile) as $filename)
		{
			if(filetype($filename) != 'file') continue;
			
			$this->internalProcessFile($filename);
			if($this->_roster->deleteafter) @unlink($filename);
		}
	}
	
	private function internalProcessFile($filename)
	{
		debuglog("import-roster started $filename");
		
		$file = fopen($filename, 'r');
		if(!$file) return;

		$semester = getCurrentSemester();
		$languagecourses = safeCreateObject("Language Courses", CMDB_OBJECTROOT_ID);
		
		if($this->_roster->hassemester)
		{
			$line = fgetcsv($file);
			
			$semester = getdbosql('Semester', "name='{$line[0]}'");
			if(!$semester)
			{
				$semester = new Semester;
				$semester->name = $line[0];
			}
			
			$semester->starttime = date("Y-m-d", strtotime($line[1]));
			$semester->endtime = date("Y-m-d", strtotime($line[2]));
			$semester->save();
		}
		
		if($this->_roster->skipfirst)
			$line = fgetcsv($file);

		$cleaned = array();
		while(!feof($file))
		{
			$line = fgetcsv($file);
			if(!$line || empty($line)) continue;
			
			$entry = new RosterEntry;
			$entry->parse($line, $this->_roster);

			if(empty($entry->coursename)) continue;
			if(empty($entry->userlogon)) continue;
				
			if(empty($entry->username)) $entry->username = $entry->userlogon;
			if(empty($entry->teachername)) $entry->teachername = $entry->teacherlogon;
				
			$language = safeCreateObject($entry->languagename, $languagecourses->id);
			$language->model = true;
			$language->save();
			
			$parentid = $language->id;
			if(!empty($entry->foldername))
			{
				$folder = safeCreateObject($entry->foldername, $parentid);
				$folder->model = true;
				$folder->save();
			
				$parentid = $folder->id;
			}
			
			$course = safeCreateCourse($entry->coursename, $parentid, $semester->id);
			$course->model = true;
			$course->semesterid = $semester->id;
			$course->save();
			
			if(!empty($entry->customcourse))
			{
				$course->object->ext->custom = $entry->customcourse;
				$course->object->ext->save();
			}
			
			if(!isset($cleaned[$course->id]))
			{
				dborun("update CourseEnrollment set deleted=true where objectid=$course->id and roleid=".SSPACE_ROLE_STUDENT);
				$cleaned[$course->id] = true;
			}
			
			$user = safeCreateUser($entry->userlogon, $entry->username, $entry->useremail, $this->_roster->domainid);
			safeCourseEnrollment($user->id, $entry->roleid, $course->id);
			
			if(!empty($entry->customuser))
			{
				$user->custom1 = $entry->customuser;
				$user->save();
			}

			if(!empty($entry->teacherlogon))
			{
				$teacher = safeCreateUser($entry->teacherlogon, $entry->teachername, $entry->teacheremail, $this->_roster->domainid);
				safeCourseEnrollment($teacher->id, SSPACE_ROLE_TEACHER, $course->id);
			}
		}
	
		fclose($file);
		
		foreach($cleaned as $courseid=>$dum)
			dborun("delete from CourseEnrollment where objectid=$courseid and deleted");
		
		debuglog("import-roster completed");
	}

}


