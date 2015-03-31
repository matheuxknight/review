<?php

class ClientController extends CommonController
{
	const PAGE_SIZE = 25;

	public $defaultAction = 'admin';
	private $_client;

	public function actionUpdate()
	{
		$client = $this->loadclient();
		if(isset($_POST['Client']))
		{
			$client->attributes = $_POST['Client'];
			if($client->save())
				$this->redirect(array('admin'));
		}
		$this->render('update', array('client'=>$client));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadclient()->delete();
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();

		$criteria = new CDbCriteria;
		if(isset($_GET['search']))
		{
			$search = $_GET["search"];
			$criteria->condition = 
				"remoteip like :sterm or remotename like :sterm or platform like :sterm";
			$criteria->params = array(":sterm"=>"%$search%");
		}

		$pages = new CPagination(getdbocount('Client', $criteria));
		$pages->pageSize = self::PAGE_SIZE;
		$pages->applyLimit($criteria);
		
		$clients = getdbolist('Client', $criteria);
		//Client::model()->findAll($criteria);
		$this->render('admin', array('clients'=>$clients, 'pages'=>$pages));
	}

	public function actionLoadResults()
	{
		$criteria = new CDbCriteria;
		if(isset($_GET['search']))
		{
			$search = $_GET["search"];
			$criteria->condition = 
				"remoteip like :sterm or remotename like :sterm";
			$criteria->params = array(":sterm"=>"%$search%");
		}

		$pages = new CPagination(getdbocount('Client', $criteria));
		$pages->pageSize = self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$clients = getdbolist('Client', $criteria);
		$this->renderPartial('results', array('clients'=>$clients, 'pages'=>$pages));
	}
	
	public function loadclient($id=null)
	{
		if($this->_client===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_client=getdbo('Client', $id!==null ? $id : $_GET['id']);
			//Client::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_client===null)
				throw new CHttpException(500,'The requested client does not exist.');
		}
		return $this->_client;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadclient($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
	
}






