<?php

class SemestertemplateController extends CommonController
{
	public $defaultAction = 'admin';
	private $_semestertemplate;

	public function actionCreate()
	{
		$semestertemplate = new Semestertemplate;
		if(isset($_POST['Semestertemplate']))
		{
			$semestertemplate->attributes = $_POST['Semestertemplate'];
			if($semestertemplate->save())
				$this->redirect(array('admin'));
		}
		$this->render('create', array('semestertemplate'=>$semestertemplate));
	}

	public function actionUpdate()
	{
		$semestertemplate = $this->loadsemestertemplate();
		if(isset($_POST['Semestertemplate']))
		{
			$semestertemplate->attributes = $_POST['Semestertemplate'];
			if($semestertemplate->save())
				$this->redirect(array('admin'));
		}
		$this->render('update', array('semestertemplate'=>$semestertemplate));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadsemestertemplate()->delete();
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();
		$criteria = new CDbCriteria;
		$criteria->order = 'starttime';
		
		$semestertemplates = getdbolist('Semestertemplate', $criteria);
		//Semestertemplate::model()->findAll($criteria);
		$this->render('admin', array('semestertemplates'=>$semestertemplates));
	}

	public function loadsemestertemplate($id=null)
	{
		if($this->_semestertemplate===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_semestertemplate=getdbo('Semestertemplate', $id!==null ? $id : $_GET['id']);
			//Semestertemplate::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_semestertemplate===null)
				throw new CHttpException(500,'The requested semestertemplate does not exist.');
		}
		return $this->_semestertemplate;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadsemestertemplate($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
