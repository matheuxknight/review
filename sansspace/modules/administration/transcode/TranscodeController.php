<?php

class TranscodeController extends CommonController
{
	public $defaultAction = 'admin';
	private $_transcodeTemplate;

	public function actionCreate()
	{
		$template = new TranscodeTemplate;
		$template->audiocodec = 'mp3';
		$template->videocodec = 'h263';
		$template->audiofreq = '44100';
		
		if(isset($_POST['TranscodeTemplate']))
		{
			$template->attributes = $_POST['TranscodeTemplate'];
			if($template->save())
				$this->redirect(array('admin'));
		}
		$this->render('create', array('template'=>$template));
	}

	public function actionUpdate()
	{
		$template = $this->loadTranscodeTemplate();
		if(isset($_POST['TranscodeTemplate']))
		{
			$template->attributes = $_POST['TranscodeTemplate'];
			if($template->save())
			{
				if($template->active)
					dborun("update TranscodeTemplate set active=false where id!=$template->id");

				$this->goback();
			//	$this->redirect(array('admin'));
			}
		}
		$this->render('update', array('template'=>$template));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadTranscodeTemplate()->delete();
			$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function actionDeleteTranscoded()
	{
		if(!Yii::app()->request->isPostRequest) throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
		
		$template = $this->loadTranscodeTemplate($_POST['id']);
		$tos = getdbolist('TranscodeObject', "templateid=$template->id");
		
		foreach($tos as $to)
		{
			@unlink(SANSSPACE_CACHE."/$to->pathname");
			@unlink(SANSSPACE_CACHE."/$to->pathname".FLV_INDEX_EXTENSION2);

			$to->delete();
		}

		$this->redirect(array('admin'));
	}
		
	public function actionAdmin()
	{
		$this->processAdminCommand();
		$this->render('admin');
	}

	public function actionCancelAll()
	{
		dborun("delete from TranscodeObject where status=".CMDB_OBJECTTRANSCODE_QUEUED);
		dborun("delete from TranscodeObject where status=".CMDB_OBJECTTRANSCODE_QUEUED2);
		dborun("delete from TranscodeObject where status=".CMDB_OBJECTTRANSCODE_QUEUED3);
		
		$this->goback();
	}
	
	public function actionCleanErrors()
	{
		dborun("delete from TranscodeObject where status=".CMDB_OBJECTTRANSCODE_ERROR);
		dborun("delete from TranscodeObject where size=0");
		
		$this->goback();
	}
	
	public function loadTranscodeTemplate($id=null)
	{
		if($this->_transcodeTemplate===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_transcodeTemplate=getdbo('TranscodeTemplate', $id!==null ? $id : $_GET['id']);
			//TranscodeTemplate::model()->findbyPk($id!==null ? $id : $_GET['id']);
				
			if($this->_transcodeTemplate===null)
				throw new CHttpException(500,'The requested TranscodeTemplate does not exist.');
		}
		return $this->_transcodeTemplate;
	}

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$template = $this->loadTranscodeTemplate($_POST['id']);
			
			// delete all file transcodes from that template
			$tos = getdbolist('TranscodeObject', "templateid=$template->id");
			foreach($tos as $to)
			{
				$filename = fileTranscodedFilename($to->fileid, $template->id);
				
				@unlink($filename);
				@unlink($filename.FLV_INDEX_EXTENSION2);
				
				$to->delete();
			}
			
			$template->delete();
			$this->refresh();
		}

		else if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='deletetranscoded')
		{
			$template = $this->loadTranscodeTemplate($_POST['id']);
			
			$tos = getdbolist('TranscodeObject', "templateid=$template->id");
			foreach($tos as $to)
			{
				@unlink(SANSSPACE_CACHE."/$to->pathname");
				@unlink(SANSSPACE_CACHE."/$to->pathname".FLV_INDEX_EXTENSION2);
	
				$to->delete();
			}
			
			$this->refresh();
		}

		if(isset($_POST['TranscodeParams']))
		{
			$transcodeparams = getdbosql('TranscodeParams', "1");
			$transcodeparams->attributes = $_POST['TranscodeParams'];
			
			$transcodeparams->save();
			user()->setFlash('message', 'Successfully saved parameters.');
			
			$this->refresh();
		}		
	}

	//////////////////////////////////////////////////////////////////////////
	
	public function actionQueueAudio()
	{
		$template = $this->loadTranscodeTemplate();
		$objectid = getparam('objectid');
		
		$count = 0;
		
		$list = getdbolist('VFile', "type = ".CMDB_OBJECTTYPE_FILE.
			" and parentlist like '%, {$objectid}, %'");
		foreach($list as $file)
		{
			if(isMediaFormatSupported($file)) continue;
			if($file->filetype != CMDB_FILETYPE_MEDIA) continue;
			if($file->hasvideo) continue;
			
			$to = getdbosql('TranscodeObject', 
				"fileid=$file->id and templateid=$template->id");
			if(!$to)
			{
				$to = new TranscodeObject;
				$to->fileid = $file->id;
				$to->templateid = $template->id;
				$to->pathname = "$file->id-{$template->id}.flv";
				$to->views = 0;
				$to->size = 0;
				$to->bitrate = 0;
				$to->message = 'Scheduled for processing.';
				$to->status = CMDB_OBJECTTRANSCODE_QUEUED;
				$to->save();
			}
			
			else if($to->status != CMDB_OBJECTTRANSCODE_COMPLETE &&
				$to->status != CMDB_OBJECTTRANSCODE_CURRENT)
			{
				$to->status = CMDB_OBJECTTRANSCODE_QUEUED;
				$to->save();
			}
			
			$count++;
		}
		
		user()->setFlash('message', "$count queued for transcode.");
		$this->goback();
	}

	public function actionQueueVideo()
	{
		$template = $this->loadTranscodeTemplate();
		$objectid = getparam('objectid');
		
		$count = 0;
		
		$list = getdbolist('VFile', "type = ".CMDB_OBJECTTYPE_FILE.
			" and parentlist like '%, {$objectid}, %'");
		foreach($list as $file)
		{
			if(isMediaFormatSupported($file)) continue;
			if($file->filetype != CMDB_FILETYPE_MEDIA) continue;
			if(!$file->hasvideo) continue;
			
			$to = getdbosql('TranscodeObject', 
				"fileid=$file->id and templateid=$template->id");
			if(!$to)
			{
				$to = new TranscodeObject;
				$to->fileid = $file->id;
				$to->templateid = $template->id;
				$to->pathname = "$file->id-{$template->id}.flv";
				$to->views = 0;
				$to->size = 0;
				$to->bitrate = 0;
				$to->message = 'Scheduled for processing.';
				$to->status = CMDB_OBJECTTRANSCODE_QUEUED;
				$to->save();
			}
			
			else if($to->status != CMDB_OBJECTTRANSCODE_COMPLETE &&
				$to->status != CMDB_OBJECTTRANSCODE_CURRENT)
			{
				$to->status = CMDB_OBJECTTRANSCODE_QUEUED;
				$to->save();
			}
			
			$count++;
		}
		
		user()->setFlash('message', "$count queued for transcode.");
		$this->goback();
	}

	//////////////////////////////////////////////////////////////////////
	
	public function actionDeleteAudio()
	{
		$template = $this->loadTranscodeTemplate();
		$objectid = getparam('objectid');
		
		$count = 0;
		
		$list = getdbolist('VFile', "type = ".CMDB_OBJECTTYPE_FILE.
			" and parentlist like '%, {$objectid}, %'");
		foreach($list as $file)
		{
			if($file->hasvideo) continue;
			
			$to = getdbosql('TranscodeObject', 
				"fileid=$file->id and templateid=$template->id");
			if(!$to) continue;
			
			@unlink(SANSSPACE_CACHE."/$to->pathname");
			@unlink(SANSSPACE_CACHE."/$to->pathname".FLV_INDEX_EXTENSION2);
			
			$to->delete();
			$count++;
		}
		
		user()->setFlash('message', "$count deleted.");
		$this->goback();
	}

	public function actionDeleteVideo()
	{
		$template = $this->loadTranscodeTemplate();
		$objectid = getparam('objectid');
		
		$count = 0;
		
		$list = getdbolist('VFile', "type = ".CMDB_OBJECTTYPE_FILE.
			" and parentlist like '%, {$objectid}, %'");
		foreach($list as $file)
		{
			if(!$file->hasvideo) continue;
			
			$to = getdbosql('TranscodeObject', 
				"fileid=$file->id and templateid=$template->id");
			if(!$to) continue;
			
			@unlink(SANSSPACE_CACHE."/$to->pathname");
			@unlink(SANSSPACE_CACHE."/$to->pathname".FLV_INDEX_EXTENSION2);
			
			$to->delete();
			$count++;
		}
		
		user()->setFlash('message', "$count deleted.");
		$this->goback();
	}

	//////////////////////////////////////////////////////////////////////
	
	public function actionCancelAllObject()
	{
		$objectid = getparam('objectid');
		$count = 0;

	//	debuglog("actionCancelAllObject() $objectid");
		
		$list = getdbolist('VFile', "type = ".CMDB_OBJECTTYPE_FILE.
			" and parentlist like '%, {$objectid}, %'");
		foreach($list as $file)
		{
			$tos = getdbolist('TranscodeObject', "fileid=$file->id");
			foreach($tos as $to)
			{
				if($to->status == CMDB_OBJECTTRANSCODE_COMPLETE) continue;
				if($to->status == CMDB_OBJECTTRANSCODE_CURRENT) continue;
				
				@unlink(SANSSPACE_CACHE."/$to->pathname");
				@unlink(SANSSPACE_CACHE."/$to->pathname".FLV_INDEX_EXTENSION2);

				$to->delete();
				$count++;
			}
		}
		
		user()->setFlash('message', "$count cancelled.");
		$this->goback();
	}

	//////////////////////////////////////////////////////////////////////
	
	public function actionDeleteAllObject()
	{
		$objectid = getparam('objectid');
		$count = 0;
		
		$list = getdbolist('VFile', "type = ".CMDB_OBJECTTYPE_FILE.
			" and parentlist like '%, {$objectid}, %'");
		foreach($list as $file)
		{
			$tos = getdbolist('TranscodeObject', "fileid=$file->id");
			foreach($tos as $to)
			{
				if($to->status == CMDB_OBJECTTRANSCODE_CURRENT) continue;
				
				@unlink(SANSSPACE_CACHE."/$to->pathname");
				@unlink(SANSSPACE_CACHE."/$to->pathname".FLV_INDEX_EXTENSION2);

				$to->delete();
				$count++;
			}
		}
		
		user()->setFlash('message', "$count deleted.");
		$this->goback();
	}

	//////////////////////////////////////////////////////////////////////
	
	public function actionDeleteAllNative()
	{
		$objectid = getparam('objectid');
		$count = 0;
		
		$list = getdbolist('VFile', "type = ".CMDB_OBJECTTYPE_FILE.
			" and parentlist like '%, {$objectid}, %'");
		foreach($list as $file)
		{
			if(!isMediaFormatSupported($file)) continue;
				
			$tos = getdbolist('TranscodeObject', "fileid=$file->id");
			foreach($tos as $to)
			{
				if($to->status == CMDB_OBJECTTRANSCODE_CURRENT) continue;
				
				@unlink(SANSSPACE_CACHE."/$to->pathname");
				@unlink(SANSSPACE_CACHE."/$to->pathname".FLV_INDEX_EXTENSION2);

				$to->delete();
				$count++;
			}
		}
		
		user()->setFlash('message', "$count deleted.");
		$this->goback();
	}

	///////////////////////////////////////////////////////////////////////////////

	public function actionSetorder()
	{
		if(!Yii::app()->request->isAjaxRequest || !isset($_GET['id'])) return;
		
		$template = $this->loadTranscodeTemplate();
		$order = $_GET['order'];
		
		$oldorder = $template->displayorder;

		$bros = getdbolist('TranscodeTemplate', "1 order by displayorder, name");
		foreach($bros as $n=>$o)
		{
			if($o->id == $template->id)
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


