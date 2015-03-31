<?php

class ContactController extends CommonController
{
	public $defaultAction='admin';
	private $_contact;

	public function actionCreate()
	{
		$contact = new Contact;
		$contact->created = now();
		
		if(isset($_POST['Contact']))
		{
			$contact->attributes=$_POST['Contact'];
			if($contact->save())
				$this->redirect(array('admin'));
		}
		$this->render('create',array('contact'=>$contact));
	}

	public function actionUpdate()
	{
		$contact = $this->loadcontact();
		if(isset($_POST['Contact']))
		{
			$contact->attributes=$_POST['Contact'];
			if($contact->save())
				$this->redirect(array('admin'));
		}
		$this->render('update',array('contact'=>$contact));
	}

	public function actionEdit()
	{
		$server = getdbo('Server',1);
		//Server::model()->findByPk(1);
		if(isset($_POST['Server']))
		{
			$server->attributes = $_POST['Server'];
			$server->save();
			
			user()->setFlash('message', 'Contact page saved.');
		}

		$this->render('edit', array('server'=>$server));
	}
	
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadcontact()->delete();
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();
		$criteria=new CDbCriteria;

		$contactList= getdbolist('Contact', $criteria);
		//Contact::model()->findAll($criteria);
		$this->render('admin', array('contactList'=>$contactList));
	}

	public function loadcontact($id=null)
	{
		if($this->_contact===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_contact= getdbo('Contact', $id!==null ? $id : $_GET['id']);
			//Contact::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_contact===null)
				throw new CHttpException(500, 'The requested contact does not exist.');
		}
		return $this->_contact;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadcontact($_POST['id'])->delete();
			$this->refresh();
		}
	}
}

