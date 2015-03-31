<?php

class EnrollController extends CommonController
{
	public $defaultAction = 'admin';
	private $_enrollment;

	public function actionAdmin()
	{
		$object = controller()->object;
		$this->render('admin', array('object'=>$object));
	}

	public function actionCreate()
	{
		$enrollment = new ObjectEnrollment;
		$enrollment->objectid = getparam('id');
		$enrollment->roleid = SSPACE_ROLE_USER;
		$enrollment->userid = 0;

		if(isset($_POST['ObjectEnrollment']))
		{
			$enrollment->attributes = $_POST['ObjectEnrollment'];
			
			if($enrollment->save())
				$this->goback(-2);
		}

		$this->render('create', array('enrollment'=>$enrollment));
	}

	public function actionUpdate()
	{
		$enrollment = getdbo('ObjectEnrollment', getparam('id'));
		if(!$enrollment) $this->goback();

		if(isset($_POST['ObjectEnrollment']))
		{
			$enrollment->attributes = $_POST['ObjectEnrollment'];
			if($enrollment->save())
				$this->goback(-2);
		}

		$this->render('update', array('enrollment'=>$enrollment));
	}

	//////////////////////////////////////////////////////

	public function actionEnroll()
	{
		safeCourseEnrollment(getUser()->id, SSPACE_ROLE_STUDENT, getparam('id'));
		$this->redirect(array('object/show', 'id'=>getparam('id')));
	}

	public function actionUnenroll()
	{
		$e = isCourseEnrolled(getUser()->id, getparam('id'));
		if($e) $e->delete();

		$this->redirect(array('object/show', 'id'=>$e->objectid));
	}

	//////////////////////////////////////////////////////

	public function actionDeleteAll()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$id = getparam('id');
			$object = getdbo('Object', $id);

			dborun("delete from ObjectEnrollment where objectid=$object->id");
			$this->goback();
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$id = getparam('id');

			$enrollment = getdbo('ObjectEnrollment', $id);
			if($enrollment) $enrollment->delete();
			
			$this->goback();
		}
		else
			throw new CHttpException(500, 'Invalid request. Please do not repeat this request again.');
	}

	public function actionDeleteCourse()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$id = getparam('id');

			$enrollment = getdbo('CourseEnrollment', $id);
			if($enrollment) $enrollment->delete();
				
			$this->goback();
		}
		else
			throw new CHttpException(500, 'Invalid request. Please do not repeat this request again.');
	}
	
	
}


