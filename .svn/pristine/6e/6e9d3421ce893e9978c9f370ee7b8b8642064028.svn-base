<?php

class ConnectController extends CommonController
{
	public $defaultAction='start';
	private $_course = null;
	
	public function loadcourse($id=null)
	{
		if($this->_course) return $this->_course;
		if(!$id) $id = getparam('id');
			
		$this->_course = getdbo('VCourse', $id);
		return $this->_course;
	}
	
	public function actionStart()
	{
		if(user()->isGuest) return;
	
		if(IsMobileEmbeded())
		{
			$this->actionShow();
			return;
		}
		
		$course = $this->loadcourse();
		$this->render('start', array('course'=>$course));
	}

	public function actionShow()
	{
		if(user()->isGuest) return;
		$course = $this->loadcourse();
		
		include "show.php";
	}

	public function actionShowScreen()
	{
		if(user()->isGuest) return;
		include "showscreen.php";
	}

	//////////////////////////////////////////////////////////////////
	
	public function actionShareScreen()
	{
		$user = getUser();
		$phpsessid = session_id();
		$servername = getFullServerName();
	
		$rtmpname = getServerName();
		$rtmpport = SANSSPACE_RTMPPORT;
		$rtmpsite = SANSSPACE_SITENAME;
	
		header("Content-Type: application/x-java-jnlp-file");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Content-Disposition: filename=\"screenshare.jnlp\"");
	
		echo <<<END
<?xml version='1.0' encoding='utf-8'?>
<jnlp spec='1.0+' codebase='$servername/extensions/screenshare'>
	<information>
		<title>ScreenShare</title>
		<vendor>sans</vendor>
		<offline-allowed/>
	</information>
	<security>
		<all-permissions/>
	</security>
	<resources>
		<j2se version='1.6+'/>
		<jar href='screenshare.jar'/>
	</resources>
	<application-desc main-class='org.redfire.screen.ScreenShare'>
		<argument>$rtmpname</argument>
		<argument>$rtmpsite</argument>
		<argument>$rtmpport</argument>
		<argument>phpsessid=$phpsessid&channel=1</argument>
		<argument>flashsv2</argument>
		<argument>1</argument>
		<argument>1024</argument>
		<argument>768</argument>
	</application-desc>
</jnlp>
	
END;
	}
	
	public function actionInternalCollect()
	{
		$phpsessid = getparam('usersessid');
		$inname = SANSSPACE_TEMP."/phpsessid=$phpsessid.flv";
		
		if(!file_exists($inname)) return;

		$session = getdbosql('Session', "phpsessid='$phpsessid'");
		if(!$session) return;

		$user = $session->user;
		if(!$user) return;
		
		$courseid = getparam('id');
		$parentid = getparam('parentid');
		$name = getparam('name');
		
		$object = safeCreateObject($name, $parentid);
		if(!$object) return;
		
		$d = date('Y-m-d h:i');
		$file = safeCreateFile("$user->name - $d.flv", $object->id, '.flv');
		if(!$file) return;
		
		$filename = objectPathname($file);
		$fileindex = objectPathnameIndex($file);
		
		@unlink($filename);
		@unlink($fileindex);
		
		debuglog("copy $inname, $filename");
		@copy($inname, $filename);

		$file = scanFile($file);
		
		dborun("update RecordSession set fileid=$file->id 
			where sessionid=$session->id and fileid=0 and userid=$user->id");

		header("Content-Type: text/xml");
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');

		echo "<?xml version='1.0' encoding='utf-8' ?>";
		echo "<objects>";
		echo File2Xml($file);
		echo "</objects>";
	}
	
}





