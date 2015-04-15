<?php

class CommonController extends CController
{
	public $object = null;
	public $rbac = null;
//	public $command = null;
	public $identity = null;
	
	///////////////////////////////////

	public function goback($count=-1)
	{
		Javascript("window.history.go($count)");
		die;
	}

	public function beforeAction($action)
	{
	//	debuglog("CommonCtrl {$this->id}/{$this->action->id}");
		$this->identity = new SansspaceIdentity;

		$this->loadCurrentObject();
		$this->rbac = new RBAC3(getUser());
		
		$allowed = array('site/login', 'site/mobileinit', 'site/register', 'site/forgot', 'site/password', 'site/captcha', 
			'file/embed', 'xml/serverinfo', 'site/admin');
		$url = "$this->id/{$this->action->id}";

		foreach($allowed as $a)
		{
			if($a == $url)
				return true;
		}

		if(param('mustlogin') && user()->isGuest && !strstr($this->id, 'internal') && getparam('internaluser') != 'system')
			user()->loginRequired();
		
		$hasaccess = $this->rbac->objectUrl($this->object, $this->id, $this->action->id);
		if(!$hasaccess)
		{
			$user = getUser();
			debuglog("ACCESS DENIED: {$user->logon}, {$_SERVER['REQUEST_URI']}");

			if(user()->isGuest)
			{
				if($this->identity->casdomain && $this->identity->casdomain->casexclusive)
					user()->loginUrl =  array('site/cas');
				
				user()->loginRequired();
			}
			
			$this->redirect(array('site/denied'));
		}
		
		///////////////////////////////////////////////////////////////////
		
		$courseid = intval(getparam('courseid'));
		if($courseid)
			setContextCourse($courseid);
		
		else
		{
			$courseid = getContextCourseId();
			if(!$courseid)
			{
				$parent = $this->object->parent;
				while($parent)
				{
					if($parent->type == CMDB_OBJECTTYPE_COURSE)
					{
						$courseid = $parent->id;
						break;
					}
			
					$parent = $parent->parent;
				}
			
				if($courseid) setContextCourse($courseid);
			}
		}

		return true;
	}
	
	private function loadCurrentObject()
	{
		if(!isset($_REQUEST['id']) || empty($_REQUEST['id'])) return null;
		$id = null;
		
		switch(controller()->id)
		{
			case 'recorder':
			case 'object':
			case 'file':
			case 'course':
			case 'report':
			case 'favorite':
				$id = $_REQUEST['id'];
				break;

			case 'enroll':
				$id = $_REQUEST['id'];
				if(controller()->action->id == 'deletecourse')
				{
					$enrollment = getdbo('CourseEnrollment', $id);
					if($enrollment)
						$id = $enrollment->objectid;
				}

				else if(controller()->action->id == 'delete' ||
						controller()->action->id == 'update')
				{
					$enrollment = getdbo('ObjectEnrollment', $id);
					if($enrollment)
						$id = $enrollment->objectid;
				}
				
				break;
				
// 			case 'quiz':
// 				$id = $_REQUEST['id'];
// 				if(	controller()->action->id == 'update' ||
// 					controller()->action->id == 'movedown' ||
// 					controller()->action->id == 'moveup')
// 				{
// 					$q = getdbo('QuizQuestion', $id);
// 					$id = $q->quizid;
// 				}

// 				else if(controller()->action->id == 'report')
// 				{
// 					$q = getdbo('QuizUserStatus', $id);
// 					//QuizUserStatus::model()->findByPk($id);
// 					$id = $q->quizid;
// 				}
//				break;

			case 'comment':
				$id = $_REQUEST['id'];
				if(controller()->action->id != 'create')
				{
					$comment = getdbo('Comment', $id);
					$id = $comment->parentid;
				}
				break;

			default:
				return null;
		}

//		debuglog($id);
		if(!$id) return null;
			
		$this->object = getdbo('Object', $id);
		return $this->object;
	}


}







