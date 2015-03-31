<?php

class DomainController extends CommonController
{
	public $defaultAction='admin';
	private $_domain;

	public function actionCreate()
	{
		$domain = new Domain;
		$domain->enable = true;
		$domain->ldapuid = "sAMAccountName";
		$domain->ldapdisplayname = "displayName";
		$domain->ldapemail = "mail";
		$domain->casport = 443;
		
		if(isset($_POST['Domain']))
		{
			$domain->attributes = $_POST['Domain'];
			
			if(isset($_POST['testconnection']))
			{
				$domain->ldapdn = SansLdapTestConnection($domain->ldapserver, $domain->ldapssl);
				if($domain->ldapdn)
					user()->setFlash('message', 'Connected successfully.');
				else
					user()->setFlash('error', 'Connection failed.');
			}

			else if($domain->save())
				$this->redirect(array('admin'));
		}
		
		$this->render('create', array('domain'=>$domain));
	}

	public function actionUpdate()
	{
		$domain = $this->loaddomain();
		if(isset($_POST['Domain']))
		{
			$domain->attributes = $_POST['Domain'];
			
			if(isset($_POST['testconnection']))
			{
				$domain->ldapdn = SansLdapTestConnection($domain->ldapserver, $domain->ldapssl);
				if($domain->ldapdn)
					user()->setFlash('message', 'Connected successfully.');
				else
					user()->setFlash('error', 'Connection failed.');
			}
			
			else if($domain->save())
			{
				$filename = GetUploadedFilename();
				if($filename)
				{
					$file = fopen($filename, 'r');
					if($file)
					{
						eval($domain->importscript);
					//	include "/sansspace/custom/test.php";
						fclose($file);
					}
											
					@unlink($filename);
				}
				
				$this->redirect(array('admin'));
			}
		}
		
		$this->render('update', array('domain'=>$domain));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loaddomain()->delete();
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();

		$domainList = getdbolist('Domain', "1 order by displayorder");
		$this->render('admin', array('domainList'=>$domainList));
	}

	public function actionProcessScript()
	{
		$domain = $this->loaddomain();

		$url = CHtml::normalizeUrl(array('domain/internalProcessScript', 'id'=>$domain->id));
		$b = sendHttpRequestAsync($url);

		if($b)
			user()->setFlash('message', 'Process script started.');
		else
			user()->setFlash('message', 'Process script did not start.');
			
		$this->redirect(array('update', 'id'=>$domain->id));
	}

	// this function runs asynchronously
	public function actionInternalProcessScript()
	{
		$domain = $this->loaddomain();

		if(!is_dir($domain->extractfolder))
			return;

		$dir = opendir($domain->extractfolder);
		if(!$dir) return;

		while(($filename = readdir($dir)) !== false)
		{
			$pathname = $domain->extractfolder.'/'.$filename;
			if(filetype($pathname) != 'file' || $filename == 'db-script.txt')
				continue;

			$file = fopen($pathname, 'r');
			if($file)
			{
				eval($domain->importscript);
				fclose($file);
			}
				
			if($domain->deleteextracts)
				@unlink($pathname);
        }

		closedir($dir);
	}

	public function loaddomain($id=null)
	{
		if($this->_domain===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_domain=getdbo('Domain', $id!==null ? $id : $_GET['id']);
			//Domain::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_domain===null)
				throw new CHttpException(500, 'The requested domain does not exist.');
		}
		return $this->_domain;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loaddomain($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}

	public function actionSetOrder()
	{
		if(!Yii::app()->request->isAjaxRequest || !isset($_GET['id'])) return;
		
		$domain = $this->loadDomain();
		$order = getparam('order');
		
		$oldorder = $domain->displayorder;

		$bros = getdbolist('Domain', "enable order by displayorder, name");
		foreach($bros as $n=>$o)
		{
			if($o->id == $domain->id)
				$o->displayorder = $order;
			
			else if($o->displayorder < $order && $o->displayorder < $oldorder)
				$o->displayorder = $n;
				
			else if($o->displayorder > $order && $o->displayorder > $oldorder)
				$o->displayorder = $n;
			
			else if($order < $oldorder)
				$o->displayorder = $n + 1;
			else
				$o->displayorder = $n - 1;
			
			$o->save();
		}
	}
	
}



