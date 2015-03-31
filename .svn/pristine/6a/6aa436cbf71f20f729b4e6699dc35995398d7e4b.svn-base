<?php

class CronjobController extends CommonController
{
	public $defaultAction='admin';
	private $_cronjob;

	public function actionCreate()
	{
		$cronjob = new Cronjob;
		$cronjob->crontime = '* * * * *';
		
		if(isset($_POST['Cronjob']))
		{
			$cronjob->attributes = $_POST['Cronjob'];
			if(empty($cronjob->crontime))
				$cronjob->crontime = implode(' ', $_POST['crontime']);

			if($cronjob->save())
			{
				sendMessageSansspaceAsync("RESET Cron");
				$this->redirect(array('admin'));
			}
		}
		$this->render('create',array('cronjob'=>$cronjob));
	}
	
	public function actionUpdate()
	{
		$cronjob=$this->loadcronjob();
		if(isset($_POST['Cronjob']))
		{
			$crontime = $cronjob->crontime;
			$cronjob->attributes = $_POST['Cronjob'];
			
			if($crontime == $cronjob->crontime)
				$cronjob->crontime = implode(' ', $_POST['crontime']);

			if($cronjob->save())
			{
				sendMessageSansspaceAsync("RESET Cron");
				$this->redirect(array('admin'));
			}
		}
		$this->render('update',array('cronjob'=>$cronjob));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadcronjob()->delete();
			
			sendMessageSansspaceAsync("RESET Cron");
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();
		$criteria = new CDbCriteria;

		$cronjobList = getdbolist('Cronjob', $criteria);
		//Cronjob::model()->findAll($criteria);
		$this->render('admin', array('cronjobList'=>$cronjobList));
	}

	public function loadcronjob($id=null)
	{
		if($this->_cronjob===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_cronjob=getdbo('Cronjob', $id!==null ? $id : $_GET['id']);
			//Cronjob::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_cronjob===null)
				throw new CHttpException(500, 'The requested cronjob does not exist.');
		}
		return $this->_cronjob;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadcronjob($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}

		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='runnow')
		{
			$this->actionRunnow();
		}
	}

	public function actionRunnow()
	{
		$job = $this->loadcronjob($_REQUEST['id']);
		if(!$job)
			throw new CHttpException(500, 'Invalid request. Please do not repeat this request again.');

		$job->lastrun = now();
		$job->save();

		$this->actionInternalRun();
		$this->goback();
	}

	public function actionInternalRun()
	{
		$cronjob = $this->loadcronjob();

		if(!empty($cronjob->url))
			sendHttpRequestAsync($cronjob->url.'&internaluser=system');

		if(!empty($cronjob->phpcode))
			eval($cronjob->phpcode);

		user()->setFlash('message', 'Cron job started.');
	}

	/////////////////////////////////////////////////////

	// not used anymore
	public function actionInternalResetSession()
	{
		dborun('update user set status='.CMDB_USERSTATUS_OFFLINE.' where status = '.CMDB_USERSTATUS_AWAY);
		dborun('update user set status='.CMDB_USERSTATUS_AWAY.' where status = '.CMDB_USERSTATUS_ONLINE);
		
		$status = CMDB_SESSIONSTATUS_COMPLETE;
		$timelimit = time()-120;

		dborun("update Session set status=$status where status!=$status and timeping<$timelimit");
		$sessionlist = getdbolist('Session', 'status='.CMDB_SESSIONSTATUS_CONNECTED);
	}
	
	public function actionFulluserinfocsv(){
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename=FullUserInfo.csv');
		
		echo "Name,Username,Email,Role,Enrollment Status,Exemption Status,Account Created,Last Login,\r\n";
		$users = getdbolist('user');
		foreach($users as $user)
		{
			$rolename = str_replace(',', '', $user->roleText);
			echo "$user->name,$user->logon,$user->email,$rolename,$user->enrolled,$user->exempt,$user->createdint,$user->lastlogint,\r\n";
		}
	}
	
	public function actionFullcourseinfocsv(){
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename=FullCourseInfo.csv');
		
		echo "Course Name,Textbook,Teacher Name,Teacher Email,Exemption Status,Enrollment Number,Course Creation Date,Course Start Date,\r\n";
		
		$courses = getdbolist('VCourse',array('condition'=>'type='.CMDB_OBJECTTYPE_COURSE.
			' and not deleted and not hidden', 'order'=>'parentid' ));
		foreach($courses as $course)
			{
				$coursename = str_replace(',', '-', $course->name);
				if ($course->parentid == 4145)
					$course->parentid = "Azulejo";
				elseif ($course->parentid == 4149)
					$course->parentid = "Tejidos";
				elseif ($course->parentid == 4151)
					$course->parentid = "Triangulo Aprobado";
				elseif ($course->parentid == 4158)
					$course->parentid = "Neue Blickwinkel";
				elseif ($course->parentid == 7600)
					$course->parentid = "Chiarissimo Uno";
				elseif ($course->parentid == 8613)
					$course->parentid = "APprenons";
				$teacher = $course->getTeacherName(false);
				$teacher = str_replace(',', '', $teacher);
				$teacheremail = $course->getTeacherName2(false);
				$teacheremail = str_replace(',', '', $teacheremail);
				$count = dboscalar("select count(*) from CourseEnrollment where objectid=$course->id");
				
				if ($course->parentid == "Azulejo" || $course->parentid == "Tejidos" || $course->parentid == "Triangulo Aprobado"
					|| $course->parentid == "Neue Blickwinkel" || $course->parentid == "Chiarissimo Uno" || $course->parentid == "APprenons"){
				echo "$coursename,$course->parentid,$teacher,$teacheremail,$course->exempt,$count,$course->createdint,$course->startdate,\r\n";}
			}
	}
	public function actionTeacheremailcsv(){
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename=TeacherEmailList.csv');
		
		$courses = getdbolist('VCourse',array('condition'=>'type='.CMDB_OBJECTTYPE_COURSE.
			' and not deleted and not hidden', 'order'=>'parentid' ));
		foreach($courses as $course)
			{
				$coursename = str_replace(',', '-', $course->name);
				if ($course->parentid == 4145)
					$course->parentid = "Azulejo";
				elseif ($course->parentid == 4149)
					$course->parentid = "Tejidos";
				elseif ($course->parentid == 4151)
					$course->parentid = "Triangulo Aprobado";
				elseif ($course->parentid == 4158)
					$course->parentid = "Neue Blickwinkel";
				elseif ($course->parentid == 7600)
					$course->parentid = "Chiarissimo Uno";
				elseif ($course->parentid == 8613)
					$course->parentid = "APprenons";
				$teacheremail = $course->getTeacherName2(false);
				$teacheremail = str_replace(',', '', $teacheremail);
				
				if ($course->parentid == "Azulejo" || $course->parentid == "Tejidos" || $course->parentid == "Triangulo Aprobado"
					|| $course->parentid == "Neue Blickwinkel" || $course->parentid == "Chiarissimo Uno" || $course->parentid == "APprenons"){
					if (strpos($teacheremail, 'test') == false)
						if(strpos($teacheremail, 'email.com') == false)
							if(strpos($teacheremail, 'demo.com') == false)
								echo "$teacheremail,\r\n";}
			}
	}
}



