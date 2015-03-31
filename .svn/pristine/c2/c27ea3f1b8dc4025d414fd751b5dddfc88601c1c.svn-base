<?php

class ReportController extends CommonController
{
	public $defaultAction = 'show';

	public function actionShow()
	{
		$id = getparam('id');
		
		$course = getdbo('VCourse', $id);
		if(!$course) return;
		
		if(controller()->rbac->objectAction($course, 'update'))
			$this->redirect(array('teacherreport/', 'id'=>$id));
		else
			$this->redirect(array('studentreport/', 'id'=>$id));
	}

	

}




