<?php

require_once('libpm.php');

class PmController extends CommonController
{
	const PAGE_SIZE = 30;

	public $defaultAction = 'inbox';
	private $_pm;

	public function DoUpdate($pm, $page)
	{
		$user = getUser();
		$pm->attributes = $_POST['PrivateMessage'];
		
		if(empty($pm->touserid) && empty($pm->togroupid))
		{
			user()->setFlash('error', 'Your message has no destination.');
		
			$this->render($page, array('pm'=>$pm));
			return;
		}
		
		if(empty($pm->name))
		{
			user()->setFlash('error', 'The "Subject" field is empty.');
		
			$this->render($page, array('pm'=>$pm));
			return;
		}
		
		if(empty($pm->doctext))
		{
			user()->setFlash('error', 'Your message is empty.');
		
			$this->render($page, array('pm'=>$pm));
			return;
		}
		
		$pm->senttime = now();
		$pm->authorid = userid();
		$pm->recv = false;
		
		if($pm->togroupid)
		{
			$pm->save();

			if($pm->smtp && !$pm->draft)
			{
				$es = getdbolist('CourseEnrollment', "objectid=$pm->togroupid");
				foreach($es as $model)
				{
					if(!$model->userid) continue;
					if($pm->smtp)
					{
						$usertarget = getdbo('User', $model->userid);
						$servername = getFullServerName();
						
						mailex($user->name, $user->email, $usertarget->email, 
							$pm->name, $pm->doctext.
	"<hr>Click the following link to view this email in sansspace.<br><br>".
	"{$servername}/pm/show&id={$pm->id}<br><br>");
					}
				}
			}
		}
		
		else
		{
			$userlist = explode(';', $pm->touserid);
			foreach($userlist as $userid)
			{
				$userid = trim($userid);
				if(empty($userid)) continue;
				
				$pm->touserid = $userid;
				$pm->save();
				
				if($pm->smtp && !$pm->draft)
				{
					$servername = getFullServerName();
					$usertarget = getdbo('User', $userid);
					//User::model()->findByPk($userid);
					
					mailex($user->name, $user->email, $usertarget->email, 
						$pm->name, $pm->doctext.
	"<hr>Click the following link to view this email in sansspace.<br><br>".
	"{$servername}/pm/show&id={$pm->id}<br><br>");
				}
				
				$temp = $pm;
				$pm = new PrivateMessage;
				$pm->attributes = $temp->attributes;
			}
		}
		
		if($pm->draft)
			$this->redirect(array('draft'));
			
		else if($pm->togroupid)
			$this->redirect(array('sent'));
			
		else
			$this->redirect(array('outbox'));
	}
	
	public function actionCreate()
	{
		$pm = new PrivateMessage;
	//	$pm->smtp = true;
		
		if(isset($_POST['PrivateMessage']) && !isset($_POST['draft']))
		{
			$this->DoUpdate($pm, 'create');
			return;
		}
		
		if(isset($_POST['PrivateMessage']))
			$pm->attributes = $_POST['PrivateMessage'];
			
		else if(isset($_GET['id']))
			$pm->togroupid = intval($_GET['id']);
		
		else if(isset($_GET['userid']))
			$pm->touserid = $_GET['userid'];
		
		$this->render('create', array('pm'=>$pm));
	}

	public function actionUpdate()
	{
		$pm = $this->loadpm();
		if(isset($_POST['PrivateMessage']))
		{
			$this->DoUpdate($pm, 'update');
			return;
		}
		
		$this->render('update', array('pm'=>$pm));
	}
	
	public function actionForward()
	{
		$pm = $this->loadpm();
		$pm->touserid = 0;
		$pm->touser = null;
		
		if(!strstr($pm->name, 'Fwd: '))
			$pm->name = 'Fwd: ' . $pm->name;
		
		$pm->doctext = "<p></p><hr><span style='color: black;'><b>{$pm->author->name}</b> 
			wrote on $pm->senttime:</span>" . $pm->doctext;
		
		if(isset($_POST['PrivateMessage']))
		{
			$pm = new PrivateMessage;
			$pm->attributes = $_POST['PrivateMessage'];
			
			$this->DoUpdate($pm, 'forward');
			return;
		}
		
		$this->render('forward', array('pm'=>$pm));
	}
	
	public function actionReply()
	{
		$pm = $this->loadpm();
		$pm->touserid = $pm->authorid;
		$pm->touser = getdbo('User', $pm->authorid);
		//User::model()->findByPk($pm->authorid);
		
		if(!strstr($pm->name, 'Re: '))
			$pm->name = 'Re: ' . $pm->name;
			
		$pm->doctext = "<p></p><hr><span style='color: black;'><b>{$pm->touser->name}</b> 
			wrote on $pm->senttime:</span>" . $pm->doctext;
		
		if(isset($_POST['PrivateMessage']))
		{
			$pm = new PrivateMessage;
			$pm->attributes = $_POST['PrivateMessage'];
			
			$this->DoUpdate($pm, 'forward');
		}
		
		$this->render('forward', array('pm'=>$pm));
	}
	
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$pm = $this->loadpm();
			$pm->delete();
			
			if(isset($_GET['page']))
				$this->redirect(array($_GET['page']));
				
			$this->redirect(app()->getRequest()->getUrlReferrer());
		}
		else
			throw new CHttpException(500, 'Invalid request. Please do not repeat this request again.');
	}
	
	///////////////////////////////////////////////////////////////////
	
	public function actionShow()
	{
		$this->processAdminCommand();
		$pm = $this->loadpm();
		$page = getparam('page');

		if($pm->touserid == userid() && !$pm->recv)
		{
			$pm->recv = true;
			$pm->recvtime = now();
			$pm->save();
		}
		
		$this->render('show', array('pm'=>$pm, 'page'=>$page));
	}
	
	public function actionDraft()
	{
		$this->processAdminCommand();
		$user = getUser();
		
		$criteria = new CDbCriteria;
		$criteria->condition = "authorid=$user->id and draft";
		
		$pages = new CPagination(getdbocount('PrivateMessage', $criteria));
		$pages->pageSize = self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort = new CSort('PrivateMessage');
		$sort->defaultOrder = 'senttime desc';

		$sort->attributes = array(
			'touser.name'=>'to',
			'PrivateMessage.name'=>'subject',
			'PrivateMessage.senttime'=>'sent on',
		);

		$sort->applyOrder($criteria);

		$pms = PrivateMessage::model()->with('touser')->findAll($criteria);		
		$this->render('draft', array('pms'=>$pms, 'sort'=>$sort, 'pages'=>$pages));
	}

	public function actionInbox()
	{
		$this->processAdminCommand();
		$user = getUser();
		
		$criteria = new CDbCriteria;
		$criteria->condition = 
			"(touserid=$user->id or togroupid in ".
			"(select objectid from courseenrollment where userid=$user->id)) and not draft";
		
		$pages = new CPagination(getdbocount('PrivateMessage',$criteria ));
		$pages->pageSize = self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort = new CSort('PrivateMessage');
		$sort->defaultOrder = 'senttime desc';

		$sort->attributes = array(
			'author.name'=>'from',
			'touser.name'=>'to',
			'PrivateMessage.name'=>'subject',
			'PrivateMessage.senttime'=>'sent on',
		);

		$sort->applyOrder($criteria);
		
		$pms = PrivateMessage::model()->with('touser')->findAll($criteria);		
		$this->render('inbox', array('pms'=>$pms, 'sort'=>$sort, 'pages'=>$pages));
	}

	public function actionOutbox()
	{
		$this->processAdminCommand();
		$user = getUser();

		$criteria = new CDbCriteria;
		$criteria->condition = "authorid=$user->id and not recv and not draft";
		
		$pages = new CPagination(getdbocount('PrivateMessage',$criteria ));
		$pages->pageSize = self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort = new CSort('PrivateMessage');
		$sort->defaultOrder = 'senttime desc';
		
		$sort->attributes = array(
			'touser.name'=>'to',
			'PrivateMessage.name'=>'subject',
			'PrivateMessage.senttime'=>'sent on',
		);

		$sort->applyOrder($criteria);

		$pms = PrivateMessage::model()->with('touser')->findAll($criteria);		
		$this->render('outbox', array('pms'=>$pms, 'sort'=>$sort, 'pages'=>$pages));
	}

	public function actionSent()
	{
//		$this->processAdminCommand();
		$user = getUser();

		$criteria = new CDbCriteria;
		$criteria->condition = "authorid=$user->id and recv and not draft";
		
		$pages = new CPagination(getdbocount('PrivateMessage',$criteria ));
		$pages->pageSize = self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort = new CSort('PrivateMessage');
		$sort->defaultOrder = 'senttime desc';

		$sort->attributes = array(
			'touser.name'=>'to',
			'PrivateMessage.name'=>'subject',
			'PrivateMessage.senttime'=>'sent on',
		);

		$sort->applyOrder($criteria);

		$pms = PrivateMessage::model()->with('touser')->findAll($criteria);		
		$this->render('sent', array('pms'=>$pms, 'sort'=>$sort, 'pages'=>$pages));
	}

	/////////////////////////////////////////////////////////////////
	
	public function loadpm($id=null)
	{
		if($this->_pm===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_pm=getdbo('PrivateMessage', $id!==null ? $id : $_GET['id']);
			//PrivateMessage::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_pm===null)
				throw new CHttpException(500, 'The requested PM does not exist.');
		}
		return $this->_pm;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadpm($_POST['id']);
			$this->actionDelete();
			
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
	
	
}






