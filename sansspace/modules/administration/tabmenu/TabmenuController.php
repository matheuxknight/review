<?php

class TabmenuController extends CommonController
{
	public $defaultAction='admin';
	private $_tabmenu;

	public function actionCreate()
	{
		$tabmenu = new Tabmenu;
		
		if(isset($_POST['Tabmenu']))
		{
			$tabmenu->attributes = $_POST['Tabmenu'];
			
			if(empty($tabmenu->name))
			{
				$object = getdbo('Object', $tabmenu->objectid);
				$tabmenu->name = $object->name;
			}
			
			if($tabmenu->save())
				$this->redirect(array('admin'));
		}
		
		$this->render('create', array('tabmenu'=>$tabmenu));
	}

	public function actionUpdate()
	{
		$tabmenu = $this->loadtabmenu();
		if(isset($_POST['Tabmenu']))
		{
			$tabmenu->attributes = $_POST['Tabmenu'];
			
			if($tabmenu->save())
				$this->redirect(array('admin'));
		}
		
		$this->render('update', array('tabmenu'=>$tabmenu));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadtabmenu()->delete();
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();

		$tabmenuList = getdbolist('Tabmenu', "1 order by displayorder");
		$this->render('admin', array('tabmenuList'=>$tabmenuList));
	}

	public function loadtabmenu($id=null)
	{
		if($this->_tabmenu===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_tabmenu=getdbo('Tabmenu', $id!==null ? $id : $_GET['id']);
			//Tabmenu::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_tabmenu===null)
				throw new CHttpException(500, 'The requested tabmenu does not exist.');
		}
		return $this->_tabmenu;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadtabmenu($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}

	//////////////////////////////////////////////////////////
	
	public function actionSetOrder()
	{
		if(!Yii::app()->request->isAjaxRequest || !isset($_GET['id'])) return;
	//	debuglog($_SERVER['REQUEST_URI']);

		$tabmenu = $this->loadtabmenu();
		$order = getparam('order');
	
		$oldorder = $tabmenu->displayorder;
	
		$bros = getdbolist('Tabmenu', "1 order by displayorder");
		foreach($bros as $n=>$o)
		{
			if($o->id == $tabmenu->id)
				$o->displayorder = $order;
				
			else if($o->displayorder < $order && $o->displayorder < $oldorder)
				$o->displayorder = $n;
	
			else if($o->displayorder > $order && $o->displayorder > $oldorder)
				$o->displayorder = $n;
				
			else if($order < $oldorder)
				$o->displayorder = $n + 1;
			else
				$o->displayorder = $n - 1;
				
		//	debuglog("saving $o->name");
			$o->save();
		}

	//	debuglog("actionSetOrder() complete");
	}
	
}
