<?php

class SemesterController extends CommonController
{
	public $defaultAction = 'admin';
	private $_semester;

	public function actionBump()
	{
		$semester = new Semester;
		if(isset($_POST['Semester']))
		{
			$semester->attributes = $_POST['Semester'];
			if($semester->save())
				$this->redirect(array('admin'));
		}
		
		$semester2 = $this->loadsemester();
		
		$semester->starttime = dateIncrementYear($semester2->starttime);
		$semester->endtime = dateIncrementYear($semester2->endtime);
		
		$this->render('create', array('semester'=>$semester));
	}
	
	public function actionCreate()
	{
		$semester = new Semester;
		if(isset($_POST['Semester']))
		{
			$semester->attributes = $_POST['Semester'];
			if($semester->save())
				$this->redirect(array('admin'));
		}
		$this->render('create', array('semester'=>$semester));
	}

	public function actionUpdate()
	{
		$semester = $this->loadsemester();
		if(isset($_POST['Semester']))
		{
			$semester->attributes = $_POST['Semester'];
			if($semester->save())
				$this->redirect(array('admin'));
		}
		$this->render('update', array('semester'=>$semester));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadsemester()->delete();
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();
		$criteria = new CDbCriteria;
		$criteria->order = 'starttime desc';
		
		$semesterList = getdbolist('Semester', $criteria);
		//Semester::model()->findAll($criteria);
		$this->render('admin', array('semesterList'=>$semesterList));
	}

	public function loadsemester($id=null)
	{
		if($this->_semester===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_semester=getdbo('Semester', $id!==null ? $id : $_GET['id']);
			//Semester::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_semester===null)
				throw new CHttpException(500,'The requested semester does not exist.');
		}
		return $this->_semester;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadsemester($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
