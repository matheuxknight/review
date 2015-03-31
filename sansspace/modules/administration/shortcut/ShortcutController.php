<?php

class ShortcutController extends CommonController
{
	const PAGE_SIZE=20;

	public $defaultAction = 'show';
	private $_shortcut;

	public function actionShow()
	{
		$this->render('show');
	}
	
	public function actionUpdate()
	{
		$shortcut = $this->loadshortcut();
		if(isset($_POST['Shortcut']))
		{
			$shortcut->attributes = $_POST['Shortcut'];
			
			if($shortcut->save())
				$this->redirect(array('admin'));
		}

		$this->render('update', array('shortcut'=>$shortcut));
	}


	public function loadshortcut($id=null)
	{
		if($this->_shortcut===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_shortcut= getdbo('Shortcut', $id!==null ? $id : $_GET['id']);

			if($this->_shortcut===null)
				throw new CHttpException(500, 'The requested shortcut does not exist.');
		}
		return $this->_shortcut;
	}

	protected function processAdminCommand()
	{
	}
	
	
}
