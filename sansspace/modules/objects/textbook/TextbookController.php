<?php

class TextbookController extends CommonController
{
	public $defaultAction = 'show';
	private $_object;
	
	public function loadobject($id=null)
	{
		if($this->_object===null)
		{
			if($id === null)
				$id = getparam('id');
	
			$this->_object = getdbo('Object', $id);
	
			if($this->_object===null)
				throw new CHttpException(500, "The requested Object $id does not exist.");
		}
	
		return $this->_object;
	}
	
	///////////////////////////////////////////////////////////////////////////
	
	public function actionShow()
	{
		$object = $this->loadobject();
		$this->render('show', array('object'=>$object));
	}
	
	public function actionShow_results()
	{
		$object = $this->loadobject();
		$this->renderPartial('show_results', array('object'=>$object));
	}

	public function actionUpdateCode()
	{
		$code = getdbo('UserCode', getparam('id'));
		$object = getdbo('Object', $code->objectid);
		
		if(isset($_POST['UserCode']))
		{
			$code->attributes = $_POST['UserCode'];
			$code->save();
			
			user()->setFlash('message', "User code saved");
		}
		
		$this->render('update', array('object'=>$object, 'code'=>$code));
	}
	
	public function actionUpload()
	{
		$object = $this->loadobject();
		
		$filename = GetUploadedFilename();
		if($filename)
		{
			$total_added = 0;
			$total_duplicate = 0;
			$total_error = 0;
				
			$lines = file($filename);
			foreach($lines as $line)
			{
				$line = trim($line);
				if(empty($line)) continue;
				
				$b = preg_match('/\d{4}-\d{4}-\d{4}-\d{4}/', $line);
				if(!$b)
				{
					$total_error++;
					continue;
				}

				$code = getdbosql('UserCode', "code='$line'");
				if($code)
				{
					$total_duplicate++;
					continue;
				}
				
				$code = new UserCode;
				$code->objectid = $object->id;
				$code->code = $line;
				$code->status = CMDB_USERCODE_UNUSED;
				$code->save();
				
				$total_added++;
			}
			
			@unlink($filename);
			$total = $total_added + $total_duplicate + $total_error;
				
			user()->setFlash('message', "$total codes, $total_added added, $total_duplicate duplicates, $total_error errors.");
			$this->redirect(array('textbook/', 'id'=>$object->id));
		}
		
		$this->render('upload', array('object'=>$object));
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////
	
	public function actionDeleteCode()
	{
		$code = getdbo('UserCode', getparam('id'));
		if(!$code) $this->goback();
		
		$object = $code->object;
		$code->delete();
		
		$this->redirect(array('textbook/', 'id'=>$object->id));
	}
	
	public function actionDeleteAllCode()
	{
		$object = $this->loadobject();
		dborun("delete from UserCode where objectid=$object->id");
		
		$this->goback();
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////
	
	public function actionAddStudentCode()
	{
//		$code = new UserCode;
//		debuglog($_POST['UserCode']);
//		if(!isset($_POST['UserCode']))
//		{
//			$this->render('addstudentcode', array('code'=>$code));
//			return;
//		}
//		
//		$codestring = $_POST['UserCode']['code'];
//
//		$b = preg_match('/\d{4}-\d{4}-\d{4}-\d{4}/', $codestring);
//		if(!$b)
//		{
//			user()->setFlash('error', "Code invalid");
//			$this->render('addstudentcode', array('code'=>$code));
//			
//			return;
//		}
//		
//		$code2 = getdbosql('UserCode', "code='$codestring'");
//		if(!$code2)
//		{
//			user()->setFlash('error', "Code does not exist in database, or entered incorrectly.");
//			$this->render('addstudentcode', array('code'=>$code));
//			
//			return;
//		}
//
//		$code = $code2;
//		if($code->status == CMDB_USERCODE_UNUSED)	// && !controller()->rbac->globalAdmin())
//		{
//			$this->render('choosecourse', array('code'=>$code));
//			return;
//		}
//	
//		$this->render('addstudentcode', array('code'=>$code));
		$id = getparam('id');
		if($id){
			$textbook = getdbosql('Object', "id='$id'");
			$this->render('choosecourse', array('textbook'=>$textbook));
			return;
		}
		else
			$this->render('addstudentcode');
	}
	
	public function actionChooseCourse_results()
	{
		//$line = getparam('code');
		//$code = getdbosql('UserCode', "code='$line'");
		$id = getparam('id');
		$textbook = getdbosql('Object', "id='$id'");
		$this->renderPartial('choosecourse_results', array('textbook'=>$textbook));
	}
	
	public function actionStudentEnroll()
	{
		//$line = getparam('code');
		//$code = getdbosql('UserCode', "code='$line'");
		
		$course = getparam('courseid');
		$user = userid();
		//if(!$code || !$course)
		//	$this->redirect(array('my/'));
		
		//if($code->status != CMDB_USERCODE_UNUSED)
		//	$this->redirect(array('my/'));

		//$code->status = CMDB_USERCODE_USED;
		//$code->userid = userid();
		//$code->courseid = $course->id;
		//$code->started = now();
		//$code->save();
		
		safeCourseEnrollment($user, SSPACE_ROLE_STUDENT, $course);
		$this->redirect(array('course/', 'id'=>$course));
	}

	public function actionAddTeacherCourse()
	{
// 		$id = getparam('id');
// 		if($id)
// 		{
// 			$object = getdbo('Object', $id);
// 			if(!$object) return;
// 			if($object->type != CMDB_OBJECTTYPE_TEXTBOOK) return;
			
// 			$this->redirect(array('course/createteacher', 'id'=>$object->id));
// 		}
		
		$this->render('addteachercourse');
	}
	
	
}








