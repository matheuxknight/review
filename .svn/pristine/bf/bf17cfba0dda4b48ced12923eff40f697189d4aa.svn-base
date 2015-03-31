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

}



