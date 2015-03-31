<?php

class UserController extends CommonController
{
	const PAGE_SIZE = 25;

	public $defaultAction='admin';
	private $_user;

	public function actionCreate()
	{
		$user = new User;
		if(isset($_POST['User']))
		{
			if($_POST['password'] != $_POST['confirm'])
			{
				user()->setFlash('message', 'You need to enter a password and a valid confirmation.');
				$this->render('create', array('user'=>$user));

				return;
			}

			$user->password = md5($_POST['password']);

			$user2 = userCreateData($user, $_POST['User']);
			if(!$user2)
			{
				$this->render('create', array('user'=>$user));
				return;
			}

		//	emailUserCreated($user2);
			$this->redirect(array('admin'));
		}

		$this->render('create', array('user'=>$user));
	}

	public function actionUpdate()
	{
		if(isset($_GET['userid']))
			$user = getdbo('User', $_GET['userid']);
		else
			$user = $this->loaduser();

		if(isset($_POST['allroles']))
		{
			foreach($_POST['allroles'] as $n=>$role)
			{
				if(isset($_POST['setrole']) && array_key_exists($n, $_POST['setrole']))
					safeUserEnrollment($user->id, $n);

				else
				{
					$e = isUserEnrolled($user->id, $n);
					if($e) $e->delete();
				}
			}

			user()->setFlash('message', 'Saved.');
		}
		
		if(isset($_POST['User']))
		{
			$password = $_POST['password'];
			$confirm = $_POST['confirm'];

			if(!empty($password))
			{
				if($password != $confirm)
				{
					user()->setFlash('message', 'The password and the confirmation password are different.');
					$this->render('update', array('user'=>$user));

					return;
				}

				$user->password = md5($password);
			}

			$user2 = userUpdateData($user, $_POST['User']);
			if(!$user2)
			{
				$this->render('update', array('user'=>$user));
				return;
			}

			$this->redirect(array('update', 'id'=>$user->id));
		}

		$this->render('update', array('user'=>$user));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$user = $this->loaduser();
			userDelete($user);

			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$this->processAdminCommand();

		$criteria = new CDbCriteria;
		if(isset($_GET['search']))
		{
			$search = $_GET["search"];
			$criteria->condition = "name like :sterm or logon like :sterm or custom1 like :sterm";
			$criteria->params = array(":sterm"=>"%$search%");
		}

		$pages = new CPagination(getdbocount('User', $criteria));
		$pages->pageSize = self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$users = getdbolist('User', $criteria);
		//User::model()->findAll($criteria);
		$this->render('admin', array('users'=>$users, 'pages'=>$pages));
	}

	public function loaduser($id=null)
	{
		if($this->_user===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_user = getdbo('User', $id!==null ? $id : $_GET['id']);
			//User::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_user===null)
				throw new CHttpException(500, 'The requested user does not exist.');
		}
		return $this->_user;
	}

	//////////////////////////////////////////////////////////////////

	public function actionEnroll()
	{
		$user = $this->loaduser();
		$this->render('enroll',array('user'=>$user));
	}

	public function actionResetPassword()
	{
		$user = $this->loaduser();
		$user->password = '';

		if(!empty($user->email))
		{
			$user->guid = base64_encode(uniqid('5tr8').uniqid('fr6e'));

			$title = param('title');
			$servername = getFullServerName();

			mailex('', SANSSPACE_SMTP_EMAIL, $user->email,
	"$title account for {$user->name}",
	"Hello $user->name,<br><br>The password for your SANSSpace account on the
	<b>{$_SERVER['SERVER_NAME']}</b> server has been reset.<br><br>
	Click the following link to choose your new password.<br><br>
	Username: {$user->logon}<br><br>
	{$servername}/site/password&guid=$user->guid
	<br><br>");
		}

		$user->save();

		user()->setFlash('message', 'Password reset.');
		$this->redirect(array('update', 'id'=>$user->id));
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$user = $this->loaduser($_POST['id']);
			userDelete($user);

			$this->refresh();
		}
	}

	////////////////////////////////////////////////////////////////

	public function actionDeleteUnenrolled()
	{
		set_time_limit(0);
		
		$users = getdbolist('User');
		foreach($users as $user)
		{
			if($user->logon == 'admin') continue;
			if($user->logon == 'guest') continue;
			if(stristr($user->logon, 'student')) continue;
			if(stristr($user->logon, 'teacher')) continue;

			$roles = $user->roles;
			
			if(isset($roles[SSPACE_ROLE_NETWORK])) continue;
			if(isset($roles[SSPACE_ROLE_ADMIN])) continue;
			if(isset($roles[SSPACE_ROLE_CONTENT])) continue;
			if(isset($roles[SSPACE_ROLE_TEACHER])) continue;
				
			$count = dboscalar("select count(*) from ObjectEnrollment where userid=$user->id");
			$count += dboscalar("select count(*) from CourseEnrollment where userid=$user->id");
			
			if($count) continue;
			userDelete($user);
		}
		
		$this->redirect(array('user/admin'));
	}
	
	////////////////////////////////////////////////////////////////

	public function actionOnline()
	{
		$this->render('online');
	}

	public function actionOnline_results()
	{
		$this->renderPartial('online_results');
	}

	//////////////////////////////////////////////////////////////////////

	public function actionRecover()
	{
		$user = getUser();

		$data = array();
		$res = opendir(SANSSPACE_TEMP);

		while(($file = readdir($res)) !== false)
		{
			$data1 = array();

			$data1['file'] = $file;
			$data1['filename'] = SANSSPACE_TEMP.'/'.$file;
			$data1['date'] = filemtime($data1['filename']);
			$data1['size'] = dos_filesize($data1['filename']);

			if(isset($_GET['file']))
			{
				$param = base64_decode($_GET['file']);
				if($param == $file)
				{
					$name = 'Recovered: '.date("F d Y H:i:s", $data1['date']);
					$parentid = $user->folderid;
					$fileid = 0;

					$object = getdbosql('Object', "name='$name' and parentid=$parentid");
					//Object::model()->find("name='$name' and parentid=$parentid");
					if(!$object)
					{
						$object = new Object;
						$object->type = CMDB_OBJECTTYPE_FILE;
						$object->name = $name;

						$object = objectInit($object, $parentid);
						if(!$object) return;

						$object->pathname = "{$object->id}.flv";
						$object->save();

						$rfile = new File;
						$rfile->objectid = $object->id;
						$rfile->originalid = $fileid;
						$rfile->save();
					}

					$filename = objectPathname($object);

					@unlink($filename);
					@unlink($filename.FLV_INDEX_EXTENSION2);

					$inname = $data1['filename'];
					@copy($inname, $filename);

					$object = scanFileObject($object);
				//	$object = scanObjectBackground($object);
				//	objectUpdateParent($object, now());

					$this->redirect(array('object/show', 'id'=>$object->id));
				}
			}

			if(preg_match('/phpsessid=(.*?)\.flv$/', $data1['filename'], $matches))
			{
				$data1['session'] = getdbosql('Session', "phpsessid='{$matches[1]}'");
				//Session::model()->find("phpsessid='{$matches[1]}'");
				if($data1['session'])
				{
					$data1['user'] = $data1['session']->user;

					if(	$this->rbac->globalAdmin() ||
						($data1['user'] && $data1['user']->id == getUser()->id))
						$data[$file] = $data1;
				}
			}
		}

		$this->render('recover', array('user'=>$user, 'data'=>$data));
	}

	public function actionLogas()
	{
		$user = $this->loaduser();
		if(!$user)
		{
			$this->goback();
			return;
		}
		
		user()->setState('shadowid', user()->getId());
		
		$this->identity->authorize($user);
		$this->redirect(array('my/'));
	}

	////////////////////////////////////////////////////////////////

	public function actionLoadResults()
	{
		$criteria = new CDbCriteria;

		if(isset($_GET['search']))
		{
			$search = $_GET["search"];
			$criteria->condition = "(name like :sterm or logon like :sterm or custom1 like :sterm or email like :sterm or phone1 like :sterm or organisation like :sterm or city like :sterm or state like :sterm)";
			$criteria->params = array(":sterm"=>"%$search%");
		}

		$roletab = getparam('roletab');
		if($roletab)
		{
			switch($roletab)
			{
				case 1:
					$roleid = SSPACE_ROLE_STUDENT;
					break;
				case 2:
					$roleid = SSPACE_ROLE_TEACHER;
					break;
				case 3:
					$roleid = SSPACE_ROLE_CONTENT;
					break;
				case 4:
					$roleid = SSPACE_ROLE_ADMIN;
					break;
				case 5:
					$roleid = SSPACE_ROLE_NETWORK;
					break;
			}
			
			$criteria->condition .= " and id in (select userid from UserEnrollment where roleid=$roleid)";
		}
		
		$pages = new CPagination(getdbocount('User', $criteria));
		$pages->pageSize = self::PAGE_SIZE;
		$pages->applyLimit($criteria);

		$users = getdbolist('User', $criteria);
		//User::model()->findAll($criteria);
		$this->renderPartial('results', array('users'=>$users, 'pages'=>$pages));
	}

	public function actionMenuUser()
	{
		if(!Yii::app()->request->isAjaxRequest || !isset($_GET['id'])) return;
		$user = getUser();

		$target = getdbo('User', $_GET['id']);
		if(!$target) return;
	}

	public function actionAutoCompleteLookup()
	{
		if(!Yii::app()->request->isAjaxRequest || !isset($_GET['q'])) return;

		$name = $_GET['q'];
		$limit = min($_GET['limit'], 50);

		$criteria = new CDbCriteria;
		$criteria->condition = "name like :sterm or logon like :sterm or custom1 like :sterm";
		$criteria->sort = 'name';
		$criteria->params = array(":sterm"=>"%$name%");
		$criteria->limit = $limit;

		$users = getdbolist('User', $criteria);
		//User::model()->findAll($criteria);
		foreach($users as $user)
			echo "{$user->name} ({$user->logon})|{$user->id}\n";
	}

	public function actionAutoCompleteLookup2()
	{
		if(!Yii::app()->request->isAjaxRequest || !isset($_GET['q'])) return;

		$name = $_GET['q'];
		$limit = min($_GET['limit'], 50);

		$criteria = new CDbCriteria;
		$criteria->condition = 'name like :sterm or logon like :sterm or custom1 like :sterm';
		$criteria->sort = 'name';
		$criteria->params = array(':sterm'=>"%$name%");
		$criteria->limit = $limit;

		$users = getdbolist('User', $criteria);
		$returnVal = '';

		foreach($users as $user)
			echo "{$user->name}|{$user->id}\n";
	}
	
	public function actionUsercsv()
	{
		// TODOPAC: use filter parameters + \r\n
		
		header('Content-type: text/csv');
		header('Content-disposition: attachment;filename=usercsv.csv');
		
		echo "Name,Username,Role,Email,Enrollment Status,\r\n";
		
		$users = getdbolist('user');
		foreach($users as $user)
		{
		//	$created = substr(datetoa($user->created), 34, (strrpos(datetoa($user->created),"o")) - 33); 
		//	$last = substr(datetoa($user->accessed), 34, (strrpos(datetoa($user->accessed),"o")) - 33);
			 
			echo "$user->name,$user->logon,$user->roleText,$user->email,$user->enrolled\r\n";
		}
	}


}







