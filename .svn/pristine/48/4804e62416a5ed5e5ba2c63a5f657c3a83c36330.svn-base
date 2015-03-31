<?php

class CourseController extends CommonController
{
	public $defaultAction='show';
	private $_course;

	public function loadcourse($id=null)
	{
		if($this->_course===null)
		{
			$id = isset($_GET['id'])? $_GET['id']: 1;
			$this->_course = getdbo('VCourse', $id);

			if($this->_course===null)
				throw new CHttpException(500, 'The requested course does not exist.');
		}
		return $this->_course;
	}

	public function actionShow()
	{
		$course = $this->loadcourse();
		$object = $course->object;

		//$user = getUser();
		//CheckCourseStatus($course, $user);
	
		if(isset($_POST['dropdown_command']) && isset($_POST['all_objects']))
		{
			objectHandleDropdownCommand();
			$this->redirect(array('show', 'id'=>$object->id));
		}

		$objectext = getdbo('ObjectExt', $object->id);
		$objectext->views++;
		$objectext->save();

		$this->render('show', array('course'=>$course));
	}

	public function actionCreate()
	{
		$semester = getCurrentSemester();
		$course = new VCourse;
		$course->ext = new ObjectExt;
		$course->type = CMDB_OBJECTTYPE_COURSE;
		$course->enrolltype = param('defaultenrollment');
		$course->model = param('defaultinherit');
		$course->semesterid = $semester->id;
		
		$this->Create($course);
		$this->render('create', array('course'=>$course));
	}

	private function Create($course)
	{
		$course->startdate = nowDate();
		$course->enddate = nowDate();

		if(isset($_POST['VCourse']))
		{
			$course2 = courseCreateData($course, $_GET['id'], $_POST['VCourse'], $_POST['ObjectExt']);
			if(!$course2)
			{
				$this->render('create', array('course'=>$course));
				return;
			}
			
			objectHandleImage($course2);
			objectHandleCategory($course2);
			objectUpdateParent($course2, now());
	
			$this->redirect(array('show', 'id'=>$course2->id));
		}
	}

	public function actionUpdate()
	{
		$course = $this->loadcourse();
		if(isset($_POST['VCourse']))
		{
			$oldtype = $course->type;
			
			$course2 = courseUpdateData($course, $_POST['VCourse'], $_POST['ObjectExt']);
			if(!$course2)
			{
				$this->render('update', array('course'=>$course));
				return;
			}
			
			objectHandleImage($course2);
			objectHandleCategory($course2);
			objectUpdateParent($course2, now());
			objectUpdateType($course2, $oldtype);
			
			user()->setFlash('message', 'Course attributes saved.');
			$this->render('update', array('course'=>$course2));
		}

		$this->render('update', array('course'=>$course));
	}
	
	///////////////////////////////////////////////////////////////////////////////////////
	
	public function actionCreateTeacher()
	{
		VCourse::$startdate_required = true;
		$parent = getdbo('Object', getparam('id'));
		
		$course = new VCourse;
		$course->ext = new ObjectExt;
		$course->type = CMDB_OBJECTTYPE_COURSE;
		
		$nexty = date('Y')+1;
		$course->startdate = date("Y-m-d", time());
		$course->enddate = "$nexty" . date("-m-d", time());

		$user = getUser();
	//	$course->name = "$parent->name ($user->organisation)";
		
		if(isset($_POST['VCourse']))
		{
			$course->attributes = $_POST['VCourse'];
			$coursename = addslashes($course->name);
				
			if(getdbosql('VCourse', "name='$coursename'"))
			{
				user()->setFlash('error', 'This course name has already been taken. Choose another unique course name.');
				$this->render('createteacher', array('course'=>$course));
								
				return;
			}
			
			$course2 = courseCreateData($course, $_GET['id'], $_POST['VCourse'], $_POST['ObjectExt']);
			if(!$course2)
			{
				$this->render('createteacher', array('course'=>$course));
				return;
			}
			
			objectUpdateParent($course2, now());
			$object = $course2->object;
			
			$object->enrolltype = CMDB_OBJECTENROLLTYPE_NONE;
			$object->model = true;
			$object->authorid = 0;
			$object->tags = "$user->organisation $user->city $user->state $user->postal $user->country";
			$object->save();
			
			$rcourse = $course2->rcourse;
			$rcourse->usedate = true;
			$rcourse->semesterid = 0;
			$rcourse->save();
				
 			safeCourseEnrollment($user->id, SSPACE_ROLE_TEACHER, $object->id);
			$this->redirect(array('createdteacher', 'id'=>$course2->id));
		}

		$this->render('createteacher', array('course'=>$course));
	}

	public function actionUpdateTeacher()
	{
		VCourse::$startdate_required = true;
		
		$course = $this->loadcourse();
		if(isset($_POST['VCourse']))
		{
			$course->attributes = $_POST['VCourse'];
			$coursename = addslashes($course->name);
			
			if(getdbosql('VCourse', "name='$coursename' and id!=$course->id"))
			{
				user()->setFlash('error', 'This course name has already been taken. Choose another unique course name.');
				$this->render('updateteacher', array('course'=>$course));
								
				return;
			}
			
			$course2 = courseUpdateData($course, $_POST['VCourse'], $_POST['ObjectExt']);
			if(!$course2)
			{
				$this->render('updateteacher', array('course'=>$course));
				return;
			}
			
			objectUpdateParent($course2, now());
			user()->setFlash('message', 'Course settings have been saved');
				
			$this->render('updateteacher', array('course'=>$course2));
		}

		$this->render('updateteacher', array('course'=>$course));
	}
	
	public function actionCreatedTeacher()
	{
		$course = $this->loadcourse();
		$this->render('createdteacher', array('course'=>$course));
	}
	
	///////////////////////////////////////////////////////////////////////////////////////
	
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$object = getdbo('Object', $_REQUEST['id']);
			$parentid = $object->parentid;

			objectDelete($object);
			$this->redirect(array('object/show', 'id'=>$parentid));
		}
		else
			throw new CHttpException(500, 'Invalid request. Please do not repeat this request again.');
	}

	public function actionDeleteActivity()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$object = getdbo('Object', $_REQUEST['id']);
			$parentid = $object->parentid;

			objectDelete($object);
			$this->redirect(array('object/show', 'id'=>$parentid));
		}
		else
			throw new CHttpException(500, 'Invalid request. Please do not repeat this request again.');
	}

	///////////////////////////////////////////////////////////////

	public function actionMyRecordings()
	{
		$course = getdbo('Object', getparam('id'));
		$user = getUser();
		
		$object = userRecordingFolder($course, $user);
		$this->redirect(array('object/show', 'id'=>$object->id));
	}
	
	public function actionRecordings()
	{
		$object = getdbo('Object', getparam('id'));
		$user = getUser();

		if($object->type == CMDB_OBJECTTYPE_COURSE)
		{
			$folder = $object->course->recording;
			$this->redirect(array('object/show', 'id'=>$folder->id));
		}
		
		else
			$this->render('show_recordings', array('object'=>$object));
	}
	
	///////////////////////////////////////////////////////////////

	private function internalAddUser($course, $tag)
	{
		$userid = $_POST["userid_$tag"];
		$userroleid = $_POST["roleid_$tag"];

		if($userid)
		{
			$user = getdbo('User', $userid);
			if(!$user) return;
		}
		else
		{
			$userlogon = $_POST["logon_$tag"];
			$username = $_POST["name_$tag"];
			$useremail = $_POST["email_$tag"];

			if(empty($userlogon) || empty($username)) return;

			$user = getdbosql('User', "logon='".addslashes($userlogon)."'");
			if($user) return;
			
			$user = new User;
			$user->logon = $userlogon;
			$user->name = $username;
			$user->email = $useremail;
			$user->password = '';
			$user->domainid = param('defaultdomain');
			$user->status = CMDB_USERSTATUS_OFFLINE;
			$user->updated = now();
			$user->created = now();
			$user->accessed = now();
			$user->used = now();
			$user->startdate = nowDate();
			$user->enddate = nowDate();
			$user->save();
		}

		safeCourseEnrollment($user->id, $userroleid, $course->id);
	}

	public function actionAddUsers()
	{
		$course = $this->loadcourse();
		if(isset($_POST['enrollcount']))
		{
			for($i = 0; $i < $_POST['enrollcount']; $i++)
			{
				$userenroll = $_POST["enroll_$i"];
				if(!$userenroll) continue;

				$this->internalAddUser($course, $i);
			}

			$this->internalAddUser($course, 'new');
			$this->redirect(array('teacherreport/', 'id'=>$course->id));
		}
		
		$this->render('addusers', array('course'=>$course, 'filename'=>null));
	}
	
	public function actionAddRoster()
	{
		$course = $this->loadcourse();
		$this->render('addroster', array('course'=>$course));
	}
	
	///////////////////////////////////////////////////////////////////

	public function actionCall()
	{
		$course = $this->loadcourse();
		$confcall = null;
		
		if($course->callid)
			$confcall = getdbo('Confcall', $course->callid);
		
		if(!$confcall)
		{
			$confcall = new Confcall;
			
			$confcall->password = '';
			$confcall->public_ = false;
			
			$confcall->created = now();
			$confcall->updated = now();
			$confcall->accessed = now();
			
			$confcall->name = $course->name;
			$confcall->save();
			
			$course->callid = $confcall->id;
			$course->save();
		}
		
		$this->redirect(array('call/show', 'id'=>$confcall->id));
	}
	
}




