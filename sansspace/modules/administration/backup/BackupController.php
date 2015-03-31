<?php

class BackupController extends CommonController
{
	public $defaultAction='admin';
	private $_alias;

	public function actionAdmin()
	{
		$this->render('admin');
	}

	public function actionBackupnow()
	{
		$backupname = getparam('backupname');
		$filename = SANSSPACE_BACKUP."\\$backupname.sql";

		$cmd = "\"".SANSSPACE_INSTALL."\\mysql\\bin\\mysqldump.exe\"".
			" --host ".SANSSPACE_DBHOST.
			" -u ".SANSSPACE_DBUSER.
			" -p\"".SANSSPACE_DBPASSWORD.
			"\" --skip-extended-insert ".
			SANSSPACE_DBNAME." > $filename";
		
		system($cmd);
		$this->goback();
	}
	
	public function actionRestore()
	{
		$backupname = getparam('backupname');
		$filename = SANSSPACE_BACKUP."\\$backupname";
		
		$cmd = "\"".SANSSPACE_INSTALL."\\mysql\\bin\\mysql.exe\"".
			" --host ".SANSSPACE_DBHOST.
			" -u ".SANSSPACE_DBUSER.
			" -p\"".SANSSPACE_DBPASSWORD.
			"\" ".SANSSPACE_DBNAME." < $filename";
	
		system($cmd);
		header('Location: /admin/restart');
	}

	public function actionDownload()
	{
		$backupname = getparam('backupname');
		$filename = SANSSPACE_BACKUP."\\$backupname";
		
		header('Content-Type: application/octet-stream');
		header("Content-Disposition: attachment; filename=$backupname");
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filename));
		ob_clean();
		flush();
		readfile($filename);

		die;
	}

	public function actionDelete()
	{
		$backupname = getparam('backupname');
		$filename = SANSSPACE_BACKUP."\\$backupname";

		@unlink($filename);
		$this->goback();
	}
}




