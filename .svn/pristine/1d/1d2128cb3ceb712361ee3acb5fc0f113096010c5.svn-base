<?php

class CertificateController extends CommonController
{
	public $defaultAction = 'admin';
	private $_certificate;
	private $_error;

	private function internalGenerateCsr($certificate)
	{
		$opensslexe = SANSSPACE_BIN."/openssl.exe";
		$opensslcnf = SANSSPACE_BIN."/openssl.cnf";
		
		$keyfile = SANSSPACE_TEMP."/ssl.key";
		$csrfile = SANSSPACE_TEMP."/ssl.csr";
		
		$subject = 
			"/CN={$certificate->commonname}".
			"/O={$certificate->organisation}".
			"/C={$certificate->country}".
			"/ST={$certificate->state}".
			"/L={$certificate->city}".
			"/OU={$certificate->organisationunit}";

		exec("$opensslexe genrsa -out {$keyfile} 2048", $e1);
		exec("$opensslexe req -config {$opensslcnf} -new -key {$keyfile} -subj \"$subject\" -out {$csrfile}", $e2);
		
		if(!file_exists($keyfile) || !file_exists($csrfile))
		{
			@unlink($keyfile);
			@unlink($csrfile);
		
			user()->setFlash('error', 'Error generating certificate files.');
			$this->_error = true;

			return $certificate;
		}
		
		$certificate->privatekey = file_get_contents($keyfile);
		$certificate->certrequest = file_get_contents($csrfile);

		@unlink($keyfile);
		@unlink($csrfile);
		
		user()->setFlash('message', 
			'Successfully generated certificate request and private key.');
		$this->_error = false;
		
		return $certificate;
	}

	public function actionCreate()
	{
		$certificate = new Certificate;
		$certificate->created = now();
		
		if(isset($_POST['Certificate']))
		{
			$certificate->attributes = $_POST['Certificate'];
			$certificate->country = substr($certificate->country, 0, 2);
			$certificate = $this->internalGenerateCsr($certificate);
						
			if(!$this->_error && $certificate->save())
				$this->redirect(array('update', 'id'=>$certificate->id));
		}

		$this->render('create', array('certificate'=>$certificate));
	}

	public function actionUpdate()
	{
		$certificate = $this->loadcertificate();
		if(isset($_POST['Certificate']))
		{
			$certificate->attributes = $_POST['Certificate'];
			$certificate->country = substr($certificate->country, 0, 2);

			$certificate->save();
			user()->setFlash('message', 'Successfully saved parameters.');
		}

		$this->render('update', array('certificate'=>$certificate));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadcertificate()->delete();
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500, 'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();

		$criteria=new CDbCriteria;
		$certificateList = getdbolist('Certificate', $criteria);
		//Certificate::model()->findAll($criteria);

		$this->render('admin', array('certificateList'=>$certificateList));
	}

	public function actionGenerateCsr()
	{
		$certificate = $this->loadcertificate($_POST['id']);
		$certificate = $this->internalGenerateCsr($certificate);

		if(!$this->_error)
			$certificate->save();

		$this->redirect(array('update', 'id'=>$certificate->id));
	}
	
	public function actionSelfsign()
	{
		$certificate = $this->loadcertificate($_POST['id']);
		
		$openssl = SANSSPACE_BIN."/openssl.exe";
		$keyfile = SANSSPACE_TEMP."/ssl.key";
		$csrfile = SANSSPACE_TEMP."/ssl.csr";
		$crtfile = SANSSPACE_TEMP."/ssl.crt";
		
		file_put_contents($keyfile, $certificate->privatekey);
		file_put_contents($csrfile, $certificate->certrequest);
		
		exec("$openssl x509 -req -days 365 -in {$csrfile} -signkey {$keyfile} -out {$crtfile}");
		if(!file_exists($crtfile))
			user()->setFlash('error', 'Error signing the certificate.');
		
		else
		{
			user()->setFlash('message', 'Successfully signed the certificate.');

			$certificate->certificate = file_get_contents($crtfile);
			$certificate->save();
		}
		
		@unlink($keyfile);
		@unlink($csrfile);
		@unlink($crtfile);
		
		$this->redirect(array('update', 'id'=>$certificate->id, '#'=>'tabs-4'));
	}
		
	public function actionUploadpfx()
	{
		$certificate = $this->loadcertificate();

		$tempname = GetUploadedFilename();
		if($tempname)
		{
			$openssl = SANSSPACE_BIN."/openssl.exe";
			$key1file = SANSSPACE_TEMP."/ssl1.key";
			$key2file = SANSSPACE_TEMP."/ssl2.key";
			$certfile = SANSSPACE_TEMP."/ssl.cert";

			exec("$openssl pkcs12 -in $tempname -passin pass:{$_POST['cert_password']} -clcerts -nokeys -out $certfile");
			exec("$openssl pkcs12 -in $tempname -passin pass:{$_POST['cert_password']} -nocerts -out $key1file -passout pass:toto");
			exec("$openssl rsa -in $key1file -passin pass:toto -out $key2file");
			
			$cert = @file_get_contents($certfile);
			if(!empty($cert)) $certificate->certificate = $cert;

			$key = @file_get_contents($key2file);
			if(!empty($key)) $certificate->privatekey = $key;

			$certificate->save();

			@unlink($key1file);
			@unlink($key2file);
			@unlink($certfile);
			@unlink($tempname);
					
			$this->redirect(array('update', 'id'=>$certificate->id));
		}

		$this->render('uploadpfx', array('certificate'=>$certificate));
	}
	
	public function loadcertificate($id=null)
	{
		if($this->_certificate===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_certificate = getdbo('Certificate', $id!==null ? $id : $_GET['id']);
			//Certificate::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_certificate===null)
				throw new CHttpException(500, 'The requested Certificate does not exist.');
		}
		return $this->_certificate;
	}

	protected function processAdminCommand()
	{
	//	mydump($_POST); die;
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadcertificate($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}

	}
}







