<?php

class RecordSessionController extends CommonController
{
	public $defaultAction = 'show';

	public function actionShow()
	{
		$this->render('show');
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

	public function actionLogcsv()
	{
		include "logcsv.php";
	}
	

}




