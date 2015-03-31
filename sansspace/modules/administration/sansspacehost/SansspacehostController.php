<?php

class SansspacehostController extends CommonController
{
	public $defaultAction = 'admin';

	public function actionAdmin()
	{
		$this->processAdminCommand();
		$this->render('admin');
	}
	
	public function actionLicenses_results()
	{
		$this->renderPartial('licenses_results');
	}
	
	public function actionDemo_results()
	{
		$this->renderPartial('demo_results');
	}
	
	public function actionSans_results()
	{
		$this->renderPartial('sans_results');
	}
	
	public function actionUpdate()
	{
		$host = getdbo('Sansspacehost', getparam('id'));
		
		if(isset($_POST['Sansspacehost']))
		{
			$host->attributes=$_POST['Sansspacehost'];
			$host->save();
			
			user()->setFlash('message', 'Host saved.');
		}
		
		$this->render('update', array('host'=>$host, ));
	}

	public function actionFlag()
	{
		$host = getdbo('Sansspacehost', getparam('id'));

		$host->requestupdate = true;
		$host->save();
		
		$this->goback();
	}
	
	public function actionDelete()
	{
		$host = getdbo('Sansspacehost', getparam('id'));
		$host->delete();

		$this->goback();
	}
	
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$host = getdbo('Sansspacehost', $_POST['id']);
			if($host) $host->delete();
			$this->refresh();
		}

		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='flag')
		{
			$host = getdbo('Sansspacehost', $_POST['id']);
			if($host)
			{
				$host->requestupdate = !$host->requestupdate;
				$host->save();
			}
			
			$this->refresh();
		}
	}
	
	/////////////////////////////////////////////////////////////////////
	
	public function actionVersion()
	{
		echo SANSSPACE_VERSION;
	}
	
	public function actionDownload()
	{
		$exename = 'sansspace-'.SANSSPACE_VERSION.'.exe';
		$filename = SANSSPACE_INSTALL."\\release\\$exename";
		
		if(!file_exists($filename))
		{
			header('HTTP/1.1 404 Not found');
			return;
		}
		
		header('Content-Type: application/octet-stream');
		header("Content-Disposition: attachment; filename=$exename");
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
	
	////////////////////////////////////////////////////////////////////
	// old function for compatibility until 6.6+
	public function actionPing()
	{
	//	debuglog("Sansspacehost::ping");
		
		$signature = getparam('signature');
		$sitename = getparam('sitename');
		
		$host = getdbosql('Sansspacehost', "signature='$signature' and sitename='$sitename'");
		if(!$host)
		{
			$host = new Sansspacehost;
			$host->signature = $signature;
			$host->sitename = $sitename;
			$host->requestupdate = 0;
		}
		
		echo $host->requestupdate;
		
		if($host->requestupdate == 1)
			$host->requestupdate = 2;
			
		else if($host->requestupdate == 2)
			$host->requestupdate = 0;
			
		$host->remoteip = $_SERVER['REMOTE_ADDR'];
		$host->remotename = gethostbyaddr($host->remoteip);
		$host->lastaccess = now();
		$host->name = getparam('name');
		$host->title = getparam('title');
		$host->localname = getparam('localname');
		$host->localip = getparam('localip');
		$host->version = getparam('version');
		$host->serialnumber = getparam('serialnumber');
		$host->licenses = getparam('licenses');
		$host->message = getparam('message');

		if(empty($host->customername)) $host->customername = $host->name;
		$host->save();
	}

	////////////////////////////////////////////////////////////////
	
	public function actionPing2()
	{
	//	debuglog("Sansspacehost::ping2");
		
		$signature = getparam('signature');
		$sitename = getparam('sitename');
		
		$host = getdbosql('Sansspacehost', "signature='$signature' and sitename='$sitename'");
		if(!$host)
		{
			$host = new Sansspacehost;
			$host->signature = $signature;
			$host->sitename = $sitename;
			
			$host->requestupdate = 0;
			$host->license_active = false;
			$host->allow_mobile = true;
			$host->allow_chat = true;
		}
		
		$host->remoteip = $_SERVER['REMOTE_ADDR'];
		$host->remotename = gethostbyaddr($host->remoteip);
		$host->lastaccess = now();
		$host->name = getparam('name');
		$host->title = getparam('title');
		$host->localname = getparam('localname');
		$host->localip = getparam('localip');
		$host->version = getparam('version');
		$host->serialnumber = getparam('serialnumber');
		$host->licenses = getparam('licenses');
		$host->message = getparam('message');
		$host->license_used = getparam('license_used');
		
		if(empty($host->customername)) $host->customername = $host->name;
		if($host->localname == 'SANS-VDS1' || $host->localname == 'SANS-VDS2')
			$host->sans = true;
		
		$requestupdate = $host->requestupdate;
		if($host->requestupdate == 1)
			$host->requestupdate = 2;
			
		else if($host->requestupdate == 2)
			$host->requestupdate = 0;
			
		if(strtotime($host->license_endtime) < time())
			$host->license_active = false;
		
		$host->save();
		if(!$host->license_active)
		{
			$host->license_concurrent = 0;
			$host->license_total = 0;
		}
		
		echo "requestupdate: $requestupdate\r\n";
		echo "license_concurrent: $host->license_concurrent\r\n";
		echo "license_total: $host->license_total\r\n";
		echo "license_endtime: $host->license_endtime\r\n";
		echo "allow_mobile: $host->allow_mobile\r\n";
		echo "allow_chat: $host->allow_chat\r\n";
	}
	
	//////////////////////////////////////////////////////////////////////////
	
	public function actionPingMaster()
	{
	//	debuglog("Sansspacehost::pingmaster");
		
		// patch here
		$guest = getdbosql('User', "logon='guest'");
		if($guest) dborun("delete from session where userid=$guest->id");
		
		sleep(1);
		$cpuload = GetCpuLoad();
	//	$netload = Itoa2(GetNetworkLoad());
	
		$data = getSansspaceIdentification();
		$server = getdbo('Server', 1);
		
		$ago1 = date('Y-m-d H:i:s', time()-60*60);
		$online1 = dboscalar("select count(*) from user where accessed>'$ago1'");

		$ago4 = date('Y-m-d H:i:s', time()-4*60*60);
		$online4 = dboscalar("select count(*) from user where accessed>'$ago4'");

		$ago24 = date('Y-m-d H:i:s', time()-24*60*60);
		$online24 = dboscalar("select count(*) from user where accessed>'$ago24'");

		$ago7 = date('Y-m-d H:i:s', time()-7*24*60*60);
		$online7 = dboscalar("select count(*) from user where accessed>'$ago7'");

		$semester = getCurrentSemester();
		$license_used = dboscalar("select count(*) from user where used>'$semester->starttime'");
		
		$queued = getdbocount('TranscodeObject',
			'status='.CMDB_OBJECTTRANSCODE_CURRENT.
			' or status='.CMDB_OBJECTTRANSCODE_QUEUED.
			' or status='.CMDB_OBJECTTRANSCODE_QUEUED2.
			' or status='.CMDB_OBJECTTRANSCODE_QUEUED3);
	
		$message = "$online1/$online4/$online24/$online7 users, $queued trans., CPU $cpuload%";
		
		$postbuffer =
			"name=".SANSSPACE_COMPUTERNAME."&".
			"sitename=".SANSSPACE_SITENAME."&".
			"title=".param('title')."&".
			"localname=$server->localname&".
			"localip=$server->localip&".
			"version=".SANSSPACE_VERSION."&".
			"serialnumber=".$data['SerialNumber']."&".
			"licenses=".$data['LicenseTotal']."&".
			"signature=".$data['Signature']."&".
			"license_used=$license_used&".
			"message=$message";
	
		$postbuffersize = strlen($postbuffer);
		$masterarray = explode(':', SANSSPACE_MASTERNAME);
	
		$fp = @fsockopen($masterarray[0], isset($masterarray[1])? $masterarray[1]: 80, $errno, $errstr, 10);
		if(!$fp) return false;
	
		$outbuffer  = "POST /sansspacehost/ping2 HTTP/1.1\r\n";
		$outbuffer .= "Host: ".SANSSPACE_MASTERNAME."\r\n";
		$outbuffer .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$outbuffer .= "Content-Length: $postbuffersize\r\n\r\n";
		$outbuffer .= $postbuffer;
	
		$outbuffer .= "\r\n\r\n";
		fwrite($fp, $outbuffer);
	
		$readbuffer = fread($fp, 2048);
		fclose($fp);
		
		/////////////////////////////////////////////////////
		
		$databuf = textToArray($readbuffer, ': ');
		
		$server->license_concurrent = $databuf['license_concurrent'];
		$server->license_total = $databuf['license_total'];
		$server->license_endtime = $databuf['license_endtime'];
		$server->allow_mobile = $databuf['allow_mobile'];
		$server->allow_chat = $databuf['allow_chat'];
		$server->save();
		
		if($databuf['requestupdate'])
			SansspaceUpdate();
	}
	
	
}





