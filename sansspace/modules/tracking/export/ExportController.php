<?php

class ExportController extends CommonController
{
	public $defaultAction = 'admin';
	private $_export;

	public function actionCreate()
	{
		$export = new Export;
		
		$export->type = CMDB_EXPORTTYPE_FILESESSION;
		$export->titleformat = 'File Name,User Name,Start Time,Duration';
		$export->dataformat = '$file.name,$user.name,$time.start,$time.duration';
		$export->timeformat = 'Y/m/d H:i:s';
		
		$export->autotype = CMDB_EXPORTAUTOTYPE_24H;
		$export->targetfile = 'c:\\temp\\report-$date.csv';
		
		if(isset($_POST['Export']))
		{
			$export->attributes = $_POST['Export'];
			if($export->save())
				$this->redirect(array('admin'));
		}
		
		$this->render('create', array('export'=>$export));
	}

	public function actionUpdate()
	{
		$export = $this->loadexport();
		if(isset($_POST['Export']))
		{
			$export->attributes = $_POST['Export'];
			$export->save();
		}

		$this->render('update', array('export'=>$export));
	}
	
	public function actionBrowse()
	{
		$export = $this->loadexport();
		$this->render('browse', array('export'=>$export));
	}
	
	public function actionLogResults()
	{
		$export = $this->loadexport();
		header('Pragma: no-cache');
		$this->renderPartial('logresults', array('export'=>$export));
	}

	public function actionLogcsv()
	{
		$export = $this->loadexport();
		include "logcsv.php";
	}
	
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$export = $this->loadexport();
			
			$cronjob = getdbo('Cronjob', $export->cronjobid);
			if ($cronjob)$cronjob->delete();
			
			$export->delete();
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();
		
		$exports = getdbolist('Export');
		$this->render('admin', array('exports'=>$exports));
	}

	public function loadexport($id=null)
	{
		if($this->_export===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_export=getdbo('Export', $id!==null ? $id : $_GET['id']);

			if($this->_export===null)
				throw new CHttpException(500,'The requested export does not exist.');
		}
		return $this->_export;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$export = $this->loadexport($_POST['id']);
			
			$cronjob = getdbo('Cronjob', $export->cronjobid);
			if ($cronjob)$cronjob->delete();
			
			$export->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
	
	///////////////////////////////////////////////////////////////
	
	public function actionCreateCronJob()
	{
		$export = $this->loadexport();
	
		$cronjob = new Cronjob;
		$cronjob->name = "Export $export->name";
		$cronjob->enable = true;
		$cronjob->url = "/export/autoprocess&id=$export->id";
		$cronjob->crontime = "30 3 * * *";
		$cronjob->save();
		
		$export->cronjobid = $cronjob->id;
		$export->save();
	
		$this->redirect(array('cronjob/update', 'id'=>$cronjob->id));
	}
	
	public function actionAutoProcess()
	{
		include "variables.php";
		
		$semester = getCurrentSemester();
		$export = $this->loadexport();
		
		switch($export->autotype)
		{
			case CMDB_EXPORTAUTOTYPE_24H:
				$startreport = time()-24*60*60;
				break;
				
			case CMDB_EXPORTAUTOTYPE_MONTH:
				$year = date("Y", time());
				$month = date("m", time());
				$startreport = mktime(0, 0, 0, $month, 1, $year);
				break;
				
			case CMDB_EXPORTAUTOTYPE_SEMESTER:
				$startreport = strtotime($semester->starttime);
				break;
		}
				
		$after = date('Y-m-d H:i', $startreport);
		$today = date('Y-m-d');
		
		$filename = preg_replace('/\$date/', $today, $export->targetfile);

		debuglog("export-session started since $after to $filename");
		@unlink($filename);
		
		$fout = fopen($filename, 'w');
		if(!$fout) return;

		$table_names = array(
			CMDB_EXPORTTYPE_SESSION=>'session',
			CMDB_EXPORTTYPE_FILESESSION=>'filesession',
			CMDB_EXPORTTYPE_RECORDSESSION=>'recordsession',
		);
		
		$table_name = $table_names[$export->type];

		$params = "from $table_name, user, vfile where ".
			"$table_name.starttime + interval $table_name.duration second >= '$after' and ".
			"$table_name.userid != 1 and $table_name.userid=user.id and $table_name.fileid=vfile.id";
	
		$sessions = dbolist("select $table_name.* $params order by $table_name.id");
		if(!empty($export->titleformat))
			fwrite($fout, "$export->titleformat\r\n");
		
		foreach($sessions as $model)
		{
			$user = getdbo('User', $model['userid']);
			$file = getdbo('VFile', $model['fileid']);
			$course = getRelatedCourse($file, $user, $semester);
			
			$count = preg_match_all('/\$([a-z]+)\.([a-z]+)/', $export->dataformat, $matches);
			$a = CustomGetValueTable($export, $user, $file, $course, $model);

			for($i = 0; $i < $count; $i++)
				for($i = 0; $i < $count; $i++)
				{
					$value = $a[$matches[1][$i]][$matches[2][$i]];
					fwrite($fout, "$value,");
				}
			
			fwrite($fout, "\r\n");
		}
		
		fclose($fout);
		debuglog("export-session completed");
	}
	
}


