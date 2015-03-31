<?php

class TeacherreportController extends CommonController
{
	public $defaultAction='show';

	public function actionShow()
	{
		$object = getdbo('Object', getparam('id'));
		
		if($object->type == CMDB_OBJECTTYPE_COURSE)
		{
			if(param('theme') == 'wayside')
				$this->render('show_course', array('object'=>$object));
				
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

