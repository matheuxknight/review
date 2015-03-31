<?php

class StudentreportController extends CommonController
{
	public $defaultAction='show';

	public function actionShow()
	{
		$object = getdbo('Object', getparam('id'));
		$user = getdbo('User', getparam('userid'));
		
		if($user)
		{
			if(!controller()->rbac->objectAction($object, 'teacherreport/'))
				throw new CHttpException(500, 'Invalid request. Please do not repeat this request again.');

			$enrollment = isCourseEnrolled($user->id, $object->id);
			if($enrollment && isset($_POST['CourseEnrollment']))
			{
				$enrollment->attributes = $_POST['CourseEnrollment'];
				$enrollment->save();
								
				user()->setFlash('message', 'Attributes saved.');
				
//				$this->goback();
//				return;
			}
		}
		else
			 $user = getUser();
		
		if($object->type == CMDB_OBJECTTYPE_COURSE)
		{
			if(param('theme') == 'wayside')
				$this->render('show_course', array('object'=>$object, 'user'=>$user));
		
			else
				$this->render('show');
		}
			
		else if($object->type == CMDB_OBJECTTYPE_QUIZ)
			$this->render('show_quiz');
		
		else if($object->type == CMDB_OBJECTTYPE_SURVEY)
			$this->render('show_survey');
				
		else
			$this->render('show');
	}

	public function actionSummaryResults()
	{
		header('Pragma: no-cache');
		$this->renderPartial('summaryresults');
	}

	public function actionLogResults()
	{
		header('Pragma: no-cache');
		$this->renderPartial('logresults');
	}

	public function actionChartResults()
	{
		header('Pragma: no-cache');
		$this->renderPartial('chartresults');
	}

	public function actionSummarycsv()
	{
		include "summarycsv.php";
	}

	public function actionLogcsv()
	{
		include "logcsv.php";
	}
	
}

