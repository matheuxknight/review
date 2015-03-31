<?php

class MyController extends CommonController
{
	public $defaultAction = 'index';

	public function actionIndex()
	{
	//	updateAutoEnrollment(getUser());
		$this->render('index', array());
	}
	
	public function actionCourses()
	{
	//	updateAutoEnrollment(getUser());
	//	CheckCourseStatus(getUser()->id);
		$this->render('courses');
	}

	public function actionReports()
	{
		$this->render('reports');
	}

	public function actionLocations()
	{
		$this->render('locations');
	}

	public function actionFolders()
	{
		$user = getUser();
		$this->render('folders', array('user'=>$user));
	//	$this->redirect(array('object/show', 'id'=>$user->folderid));
	}
	
	public function actionFavorites()
	{
		$this->processAdminCommand();
		
		$user = getUser();
		$this->render('favorites', array('user'=>$user));
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && 
			$_POST['command']==='deletefavorite')
		{
			$objectid = $_POST['id'];
			$userid = getUser()->id;
			
			$fav = getdbosql('Favortie', "userid=$userid and id=$objectid");
			//Favorite::model()->find("userid=$userid and id=$objectid");
			if(!$fav) return;
				
			$fav->delete();
			$this->refresh();
		}
	}

	public function actionSettings()
	{
		$user = getUser();
		if(isset($_POST['User']))
		{
			if(isset($_POST['password']) && isset($_POST['confirm']))
			{
				$password = $_POST['password'];
				$confirm = $_POST['confirm'];
	
				if(!empty($password))
				{
					if($password != $confirm)
					{
						user()->setFlash('message', 'The password and the confirmation password are different.');
						$this->render('settings', array('user'=>$user));
						
						return;
					}
	
					$user->password = md5($password);
				}
			}
			
			$user2 = userUpdateData($user, $_POST['User']);
			if(!$user2)
			{
				$this->render('settings', array('user'=>$user));
				return;
			}
			
		//	user()->setFlash('message', 'Information saved.');
		//	controller()->refresh();
		}

		$snapname = SANSSPACE_TEMP."/webcamsnapshot-{$user->id}.png";
		$avatarname = SANSSPACE_CONTENT."/avatar-{$user->id}.png";
		
		// check for uploaded file
		$tempname = GetUploadedFilename();
		if($tempname)
		{
			@unlink($avatarname);
			@rename($tempname, $avatarname);
			$this->refresh();
		}
		
		// check for url
		else if(isset($_POST['icon_url']) && !empty($_POST['icon_url']))
		{
			$buffer = fetch_url($_POST['icon_url']);
			
			@unlink($avatarname);
			file_put_contents($avatarname, $buffer);
			$this->refresh();
		}
		
		// check for webcam snapshot
		else if(file_exists($snapname))
		{
			@unlink($avatarname);
			imageProcessAll($snapname, $avatarname);
			@unlink($snapname);
			$this->refresh();
		}
		
		$this->render('settings', array('user'=>$user));
	}
	
	public function actionAvatarSnapshot()
	{
		$user = getUser();
		if(isset($_POST['webcamsnapshot']))
		{
			$filename = SANSSPACE_TEMP."/webcamsnapshot-{$user->id}.png";
			@unlink($filename);
			
			$data = base64_decode($_POST['webcamsnapshot']);
			file_put_contents($filename, $data);
		}
	}
	
	public function actionResetPicture()
	{
		$user = isset($_GET['id'])? User::model()->findByPk($_GET['id']): getUser();
		$avatarname = SANSSPACE_CONTENT."/avatar-{$user->id}.png";
		
		if(file_exists($avatarname))
			@unlink($avatarname);

		echo "<script>history.go(-1)</script>";		
	}
	
//	public function actionPortfolio()
//	{
//		$user = getUser();
//		$this->render('portfolio', array('user'=>$user));
//	}
	
	public function actionResetPassword()
	{
		$user = getUser();
		$user->password = '';
		$user->save();
		
		user()->setFlash('message', 'Password reset.');
		$this->redirect(array('settings'));
	}

	
}






