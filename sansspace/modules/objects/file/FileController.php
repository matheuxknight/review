<?php

class FileController extends CommonController
{
	public $defaultAction='show';
	private $_file;

	public function actionShow()
	{
		$file = $this->loadfile();
		$object = $file->object;

		if(isset($_POST['dropdown_command']) && isset($_POST['all_objects']))
		{
			objectHandleDropdownCommand();
			$this->redirect(array('show', 'id'=>$object->id));
		}

		$objectext = getdbo('ObjectExt', $object->id);
		$objectext->views++;
		$objectext->save();

		$this->render('show', array('file'=>$file));
	}

	public function actionUpload()
	{
		$parentid = getparam('id');
		
		$fileid = HandleUploadedFiles($parentid);
		if($fileid)
		{
			$this->redirect(array('object/', 'id'=>$parentid));
			return;
		}
		
		debuglog("actionUpload 2");
		$this->render('upload', array('parentid'=>$parentid));
	}
	
// 	public function actionCreate()
// 	{
// 		$file = new VFile;
// 		$file->type = CMDB_OBJECTTYPE_FILE;
// 		$file->parentid = getparam('id');
// 		$file->name = '';

// 		if(isset($_POST['VFile']))
// 		{
// 			$object2 = fileCreateData(getparam('id'), $_POST['VFile'], $_POST['ObjectExt']);
// 			if(!$object2)
// 			{
// 				$this->render('create', array('file'=>$file));
// 				return;
// 			}

// 			objectHandleCategory($object2);
// 			objectUpdateParent($object2, now());

// 			$this->redirect(array('object/show', 'id'=>$_GET['id']));
// 		}

// 		$this->render('create', array('file'=>$file));
// 	}

	public function actionCreateInternet()
	{
		$object = new Object;
		$object->ext = new ObjectExt;
		$object->type = CMDB_OBJECTTYPE_LINK;
		$object->parentid = $_GET['id'];

		if(isset($_POST['temp_url']) && !empty($_POST['temp_url']))
		{
			$object2 = fileCreateData(getparam('id'), $_POST['Object'], $_POST['ObjectExt']);
			if(!$object2)
			{
				$this->render('createinternet', array('object'=>$object));
				return;
			}

			objectHandleCategory($object2);
			objectUpdateParent($object2, now());

			$this->redirect(array('show', 'id'=>$_GET['id']));
		}
		
		$this->render('createinternet', array('object'=>$object));
	}

	public function actionCreateYoutube()
	{
		$object = new Object;
		$object->ext = new ObjectExt;
		$object->type = CMDB_OBJECTTYPE_FILE;
		$object->parentid = $_GET['id'];

		$this->render('createyoutube', array('object'=>$object));
	}

	public function actionDownloadYoutube()
	{
		$parentid = getparam('id');
		$youtubeid = getparam('youtubeid');
		$itag = getparam('itag');
		
		parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=".$youtubeid), $info);
		
		$streams = $info['url_encoded_fmt_stream_map'];
		if(!$streams)
		{
			user()->setFlash('error', "Error {$info['errorcode']} - ".stripslashes($info['reason']));
			controller()->goback();
		
			return;
		}
		
		$streams = explode(',', $streams);
		foreach($streams as $stream)
		{
			parse_str($stream, $data);
			if($data[itag] == $itag)
			{
				$ext = '.mp4';
				if($data['type'] == 'video/x-flv')
					$ext = '.flv';
					
				$tempfile = gettempfile($ext);
				debuglog("tempfile $tempfile");
				
				$file = fopen($tempfile, 'w');
				$video = fopen($data['url'].'&signature='.$data['sig'], 'r');
				
				stream_copy_to_stream($video, $file);
				
				fclose($video);
				fclose($file);
				
				safeCreateFile(stripslashes($info['title']), $parentid, $tempfile);
				break;
			}
		}
		
		$this->redirect(array('show', 'id'=>$parentid));
	}
	
	public function actionCreateText()
	{
		$file = new VFile;
		$file->ext = new ObjectExt;
		$file->type = CMDB_OBJECTTYPE_FILE;
		$file->parentid = $_GET['id'];
		$file->filetype = CMDB_FILETYPE_TEXT;

		if(isset($_POST['VFile']))
		{
			$_POST['VFile']['name'] = str_replace('.html', '', $_POST['VFile']['name']).'.html';
			
			$file2 = fileCreateData($file->parentid, $_POST['VFile'], $_POST['ObjectExt']);
			if(!$file2)
			{
				$this->render('createtext', array('file'=>$file));
				return;
			}

			objectUpdateParent($file2, now());

		//	debuglog("new fileid $file2->id");
			$rfile = getdbo('File', $file2->id);
			$rfile->mimetype = 'text/plain';
			$rfile->save();
			
			$this->redirect(array('edit', 'id'=>$file2->id));
			return;
		}
		
		$this->render('createtext', array('file'=>$file));
	}
	
	public function actionCreateHtml()
	{
		$parent = getdbo('Object', getparam('id'));
		if(!$this->rbac->objectAction($parent, 'create'))
		{
			user()->setFlash('error', "Access denied");
			$this->goback();
			
			return;
		}
		
		$_POST['VFile']['name'] = str_replace('.html', '', $_POST['VFile']['name']).'.html';
		
		$object = fileCreateData($parent->id, $_POST['VFile'], array());
		if(!$object) return;
		
		$filename = objectPathname($object);
		file_put_contents($filename, $_POST['htmlcontents']);

		$object = scanFileObject($object);
	//	$object = scanObjectBackground($object);
	//	objectUpdateParent($object, now());
		
		$this->redirect(array('object/show', 'id'=>$parent->id));
	}

	public function actionUpdate()
	{
		$file = $this->loadfile();
		if(isset($_POST['VFile']))
		{
			$oldtype = $file->type;
			
			$file2 = fileUpdateData($file, $_POST['VFile'], $_POST['ObjectExt']);
			if(!$file2)
			{
				$this->render('update', array('file'=>$file));
				return;
			}

			objectUpdateParent($file2, now());
			objectHandleCategory($file2);
			objectUpdateType($file2, $oldtype);

			user()->setFlash('message', 'File attributes saved.');
			$this->redirect(array('update', 'id'=>$file2->id));
		}

		$this->render('update', array('file'=>$file));
	}

	public function actionEdit()
	{
		$file = $this->loadfile();
		
		if($file->filetype == CMDB_FILETYPE_MEDIA)
			$this->redirect(array('recorder/openfile', 'id'=>$file->id));
		
		else if($file->filetype == CMDB_FILETYPE_BOOKMARKS)
			$this->redirect(objectUrl($file));
		
		else if(strstr($file->mimetype, 'x-empty') ||
				strstr($file->mimetype, 'text') || 
				strstr($file->mimetype, 'html'))
		{
			if(isset($_POST['htmlcontents']))
			{
				$filename = objectPathname($file);
				file_put_contents($filename, $_POST['htmlcontents']);
				
				$file = scanFile($file);
			//	scanObjectBackground($file);
				user()->setFlash('message', 'File saved.');
			}

			$this->render('edit', array('file'=>$file));
		}
		
		else
			$this->goback();
	}
	
	public function actionHardDelete()
	{
		$object = getdbo('Object', $_REQUEST['id']);
		$parentid = $object->parentid;

		// delete the actual file
		$filename = objectPathname($object);
		@unlink($filename);

		objectDelete($object);
		$this->redirect(array('object/show', 'id'=>$parentid));
	}

	public function actionSoftDelete()
	{
		$object = getdbo('Object', $_REQUEST['id']);
		$parentid = $object->parentid;

		objectDelete($object);
		$this->redirect(array('object/show', 'id'=>$parentid));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$object = getdbo('Object', $_REQUEST['id']);
			if(controller()->rbac->globalAdmin() && $object->folderimportid)
			{
				$this->render('delete', array('object'=>$object));
				return;
			}

			$parentid = $object->parentid;

			objectDelete($object);
			$this->redirect(array('object/show', 'id'=>$parentid));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	public function loadfile($id=null)
	{
		if($this->_file) return $this->_file;
		$id = getparam('id');

		$this->_file = getdbo('VFile', $id);
		if($this->_file) return $this->_file;

		$object = getdbo('Object', $id);
		if($object)
			$this->redirect(array('object/'.$this->action->id, 'id'=>$id));

		throw new CHttpException(500, 'The requested file does not exist.');
	}

	////////////////////////////////////////////////////////////////////////////

	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadfile($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}

	function actionUnzip()
	{
		$fileparent = $this->loadfile();

		$zip = zip_open(objectPathname($fileparent));
		if(!is_resource($zip)) $this->redirect(array('file/', 'id'=>$fileparent->id));

		while($zip_entry = zip_read($zip))
		{
			$size = zip_entry_filesize($zip_entry);
			if(!$size) continue;

			$pathname = basename(zip_entry_name($zip_entry));

			$object = new Object;
			$object->type = CMDB_OBJECTTYPE_FILE;

			$object = objectInit($object, $fileparent->id);
			if(!$object) break;

			$rfile = new File;
			$rfile->objectid = $object->id;

			$object->name = $pathname;
			$object->pathname = "$object->id" . getExtension($pathname);

			$object->save();
			$rfile->save();

			zip_entry_open($zip, $zip_entry, 'r');
			$buffer = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

			$filename = objectPathname($object);
			file_put_contents($filename, $buffer);

			zip_entry_close($zip_entry);
			$object = scanFileObject($object);
		//	scanObjectBackground($object);
		}

		zip_close($zip);
		$this->redirect(array('file/', 'id'=>$fileparent->id));
	}

	function actionUnrar()
	{
		$fileparent = $this->loadfile();

		$zip = rar_open(objectPathname($fileparent));
		if(!$zip) $this->redirect(array('file/', 'id'=>$fileparent->id));

		$entries = rar_list($zip);
		foreach($entries as $entry)
		{
			if($entry->getAttr() == 16) continue;
			$pathname = basename($entry->getName());

			$object = new Object;
			$object->type = CMDB_OBJECTTYPE_FILE;

			$object = objectInit($object, $fileparent->id);
			if(!$object) break;

			$rfile = new File;
			$rfile->objectid = $object->id;

			$object->name = $pathname;
			$object->pathname = "$object->id" . getExtension($pathname);

			$object->save();
			$rfile->save();

			$entry->extract('', objectPathname($object));
			$object = scanFileObject($object);
		//	scanObjectBackground($object);
		}

		rar_close($zip);
		$this->redirect(array('file/', 'id'=>$fileparent->id));
	}

	///////////////////////////////////////////////////////////////////////

	function actionDownload()
	{
		$file = $this->loadfile();

		$objectext = getdbo('ObjectExt', $file->id);
		$objectext->views++;
		$objectext->save();
		
		$filename = fileUrl($file, 'download');
		header("Location: $filename");
	}

	///////////////////////////////////////////////////////////////////////////

	function actionTranscodeCreate()
	{
		$to = getdbosql('TranscodeObject',
			"fileid={$_GET['id']} and templateid={$_GET['templateid']}");

		if(!$to)
		{
			$to = new TranscodeObject;
			$to->fileid = $_GET['id'];
			$to->templateid = $_GET['templateid'];
			$to->pathname = "{$_GET['id']}-{$_GET['templateid']}.flv";
			$to->views = 0;
			$to->size = 0;
			$to->bitrate = 0;
			$to->message = 'Scheduled for processing.';
		}

		$to->status = CMDB_OBJECTTRANSCODE_QUEUED;
		$to->save();

		$this->goback();
	}

	function actionTranscodeDelete()
	{
		$id = getparam('id');
		$templateid = getparam('templateid');

		$to = getdbosql('TranscodeObject', "fileid=$id and templateid=$templateid");

		@unlink(SANSSPACE_CACHE."/$to->pathname");
		@unlink(SANSSPACE_CACHE."/$to->pathname".FLV_INDEX_EXTENSION2);

		$to->delete();
		$this->goback();
	}

	//////////////////////////////////////////////////////////////////////

	function actionTranscodeReplace()
	{
		$file = $this->loadfile();
		$templateid = getparam('templateid');

		$to = getdbosql('TranscodeObject', "fileid=$file->id and templateid=$templateid");
		if($to && $to->status == CMDB_OBJECTTRANSCODE_COMPLETE)
		{
			$transcodefilename = fileTranscodedFilename($file->id, $templateid);

			$actualfilename = objectPathname($file);
			$actualfilenameindex = objectPathnameIndex($file);

			if(file_exists($transcodefilename))
			{
				@unlink($actualfilename);
				@unlink($actualfilenameindex);

				$file->name = removeExtension($file->name).".flv";
				$file->pathname = removeExtension($file->pathname).".flv";

				$file->save();
				$actualfilename = objectPathname($file);

				@rename($transcodefilename, $actualfilename);
				@rename($transcodefilename.FLV_INDEX_EXTENSION2, $actualfilenameindex);

				$to->delete();
			//	scanObjectBackground($file->object);
				$object = scanFileObject($object);
			}
		}

		$this->goback();
	}
	
	public function actionResetMaster()
	{
		$file = $this->loadfile();
		$file->originalid = 0;
		$file->save();
		$this->goback();
	}
	
	public function actionTrackdoc()
	{
		include "trackdoc.php";
		exit;
	}

	public function actionEmbed()
	{
		$file = $this->loadfile();
		$this->renderPartial('embed', array('file'=>$file));
	}
	
	
}






