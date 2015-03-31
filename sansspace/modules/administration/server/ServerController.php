<?php

class ServerController extends CommonController
{
	const PAGE_SIZE=20;

	public $defaultAction = 'show';
	private $_server;

	public function actionHome()	// should move these fields somewhere else than in the server table
	{
		$server = $this->loadserver(1);
		if(isset($_POST['Server']))
		{
			$server->attributes = $_POST['Server'];
			
			if(empty($server->lastaccess))
				$server->lastaccess = now();
				
			if($server->save())
				$this->redirect(array('home'));
		}

		$this->render('home', array('server'=>$server));
	}

	public function actionUpdate()
	{
		$server = $this->loadserver();
		if(isset($_POST['Server']))
		{
			$server->attributes = $_POST['Server'];
			
			if(empty($server->lastaccess))
				$server->lastaccess = now();
				
			if($server->save())
				$this->redirect(array('admin'));
		}

		$this->render('update', array('server'=>$server));
	}

	public function actionInfo()
	{
		$server = $this->loadserver(1);
		
		if(isset($_POST['settings']))
		{
		//	mydump($_POST); die;
// 			sendMessageSansspace("SET Identification", 
// 				"ServerSetting=set'\r\n".
// 				'SsdRole='.$_POST['settings']['ssdrole']."\r\n".
// 				'SsdMasterName='.$_POST['settings']['ssdmastername']."\r\n".
// 				'TranscodeThreads='.$_POST['settings']['transcodethreads']."\r\n".
// 				'LogAccess='.$_POST['settings']['logaccess']."\r\n".
// 				'UseBlackList='.$_POST['settings']['useblacklist']
// 			);
		}

		$result = getSansspaceIdentification();
		$this->render('info', array('server'=>$server, 'data'=>$result));
	}

	public function actionLicense()
	{
		if(isset($_POST['data']))
		{
			sendMessageSansspace("SET Identification", 'SerialNumber='.$_POST['data']['serialnumber']);
			$this->goback();
		}

		$this->render('license');
	}

	public function actionTimezone()
	{
		if(isset($_POST['data']))
		{
			sendMessageSansspace("SET Identification", 'TimeZone='.$_POST['data']['timezone']);
			$this->goback();
		}

		$this->render('timezone');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();
		$criteria = new CDbCriteria;

		$pages = new CPagination(getdbocount('Server', $criteria));
		$pages->pageSize = self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$sort=new CSort('Server');
		$sort->applyOrder($criteria);

		$serverList = getdbolist('Server', $criteria);
		//Server::model()->findAll($criteria);

		$this->render('admin',array(
			'serverList'=>$serverList,
			'pages'=>$pages,
			'sort'=>$sort,
		));
	}

	public function loadserver($id=null)
	{
		if($this->_server===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_server= getdbo('Server', $id!==null ? $id : $_GET['id']);
			//Server::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_server===null)
				throw new CHttpException(500, 'The requested server does not exist.');
		}
		return $this->_server;
	}

	protected function processAdminCommand()
	{
	}
	
	public function actionConfig()
	{
		$server = getdbo('Server', 1);
		if(isset($_POST['site']) && isset($_POST['Server']))
		{
			// update 	if(!isset(Yii::app()->params[$name]))
		
			
			$fp = fopen(SANSSPACE_SITEPATH.'/siteconfig.php', 'w');
			if($fp)
			{
				fwrite($fp, "<?php\nreturn array(\n");
	
				foreach($_POST['site'] as $key=>$value)
					fwrite($fp, "'$key'=>'$value',\n");
	
				fwrite($fp, ");\n\n");
			}
			
			fclose($fp);
			
			$server->attributes = $_POST['Server'];
				
			if(empty($server->lastaccess))
				$server->lastaccess = now();
	
			$server->save();
	
			user()->setFlash('message', 'Site configuration saved.');
		//	$this->redirect(array('server/config'));
		//	$this->goback(-2);
			$this->refresh();
		}
	
		$this->render('config', array('server'=>$server));
	}
	
	////////////////////////////////////////////////////////////////////////////
	
// 	public function actionRelay()
// 	{
// 		if(isset($_POST['relay']))
// 		{
// 			//mydump($_POST); die;
// 			sendMessageSansspace("SET Identification",
// 			'RelayName='.$_POST['relay']['title']."\r\n".
// 			'RelayServer='.$_POST['relay']['server']."\r\n".
// 			'RelayEnable='.$_POST['relay']['enable']
// 			);
	
// 			$this->redirect(array('server/relay'));
// 		}
	
// 		$result = getSansspaceIdentification();
// 		$this->render('relay', array('data'=>$result));
// 	}
	
	public function actionSmtp()
	{
		if(isset($_POST['smtp']))
		{
			//mydump($_POST); die;
			sendMessageSansspace("SET Identification",
				'SmtpHost='.$_POST['smtp']['host']."\r\n".
				'SmtpEmail='.$_POST['smtp']['email']."\r\n".
				'SmtpUser='.$_POST['smtp']['user']."\r\n".
				'SmtpPassword='.$_POST['smtp']['password']
			);
		}
	
		$result = getSansspaceIdentification();
		$this->render('smtp', array('data'=>$result));
	}
	
	public function actionBindings()
	{
		if(isset($_POST['bindings']))
		{
			if(!empty($_POST['bindings']['httpforward']) && !empty($_POST['bindings']['httpsforward']))
			{
				user()->setFlash('error', 'You cant have both HTTP and HTTPS forwarded.');
			}
				
			else
			{
				sendMessageSansspace("SET Identification",
				'HttpEnable='.$_POST['bindings']['httpenabled']."\r\n".
				'HttpPort='.$_POST['bindings']['httpport']."\r\n".
				'HttpForward='.$_POST['bindings']['httpforward']."\r\n".
				'HttpsEnable='.$_POST['bindings']['httpsenabled']."\r\n".
				'HttpsPort='.$_POST['bindings']['httpsport']."\r\n".
				'HttpsForward='.$_POST['bindings']['httpsforward']."\r\n".
				'HttpsCertificateId='.$_POST['bindings']['certificateid']."\r\n".
				'RtmpEnable='.$_POST['bindings']['rtmpenabled']."\r\n".
				'RtmpPort='.$_POST['bindings']['rtmpport']."\r\n".
				'HttpThreadCount='.$_POST['bindings']['threadcount']."\r\n".
				'');
	
				user()->setFlash('message',
				'Successfully saved parameters. You need to restart the service');
				$this->redirect(array('server/bindings'));
			}
		}
	
		$result = getSansspaceIdentification();
		$this->render('bindings', array('data'=>$result));
	}
	
// 	public function actionWebdav()
// 	{
// 		if(isset($_POST['webdav']))
// 		{
// 			//mydump($_POST); die;
// 			sendMessageSansspace("SET Identification",
// 			'WebdavEnable='.$_POST['webdav']['enable']."\r\n".
// 			'WebdavName='.$_POST['webdav']['name']
// 			);
// 		}
	
// 		$result = getSansspaceIdentification();
// 		$this->render('webdav', array('data'=>$result));
// 	}
	
	
}
