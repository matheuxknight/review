<?php

class InternalController extends CommonController
{
	public function actionScanObject()
	{
		$id = getparam('id');
		$object = getdbo('Object', $id);
		
		scanObject($object);
	}
	
	public function actionScanFile()
	{
		$id = getparam('id');
		$file = getdbo('VFile', $id);
		
		scanFile($file);
	}
	
	public function actionScanTranscodedFile()
	{
		$fileid = getparam('id');
		$templateid = getparam('templateid');
		
		$to = getdbosql('TranscodeObject', "fileid=$fileid and templateid=$templateid");
		scanTranscodedFile($to);
	}

	//////////////////////////////////////////////////////////////
	
	public function actionUpdateDatabase()
	{
		debuglog(__METHOD__);
		include('/sansspace/core/functions/updatedatabase.php');
		$this->goback();
	}

	//////////////////////////////////////////////////////////////
	
	private function importObject($simplexml, $remoteid, $localid)
	{
	//	debuglog("importObject($remoteid, $localid)");
		$xml = callSimpleXml($simplexml, 'get_object_list', array('id'=>$remoteid));
		
		foreach($xml->object as $ro)
		{
			$rid = (int)$ro->id;
			$rname = (string)$ro->name;
		//	debuglog("object $rname");
				
			$lo = getdbosql('Object', "parentid=$localid and remoteid=$rid");
			if(!$lo)
			{
				$lo = objectCreate($rname, $localid);
				$lo->remoteid = $rid;
				$lo->authorid = 0;
			}
			
			$lo->displayorder = (int)$ro->displayorder;
			$lo->post = (int)$ro->post;
			$lo->save();
			
			$lo->ext->doctext = base64_decode((string)$ro->doctext);
			$lo->ext->save();
			
			$this->importObject($simplexml, $rid, $lo->id);
		}
		
		foreach($xml->file as $ro)
		{
			$rid = (int)$ro->id;
			$rname = (string)$ro->name;
		//	debuglog("file $rname");
				
			$lo = getdbosql('Object', "parentid=$localid and remoteid=$rid");
			if(!$lo)
			{
				$remotefile = "{$simplexml['url']}/ws-$rid";
				$filename = SANSSPACE_TEMP."\\".(string)$ro->pathname;
				
				$data = file_get_contents($remotefile);
				if($data)
				{
					file_put_contents($filename, $data);
					$lo = safeCreateFile($rname, $localid, $filename);
				}
				else
				{
					$lo = safeCreateFile($rname, $localid);
					$lo->pathname = (string)$ro->pathname;
				}

				$lo->remoteid = $rid;
				$lo->authorid = 0;
			}
			
			else if(strtotime($lo->updated) < strtotime((string)$ro->updated))
			{
				$remotefile = "{$simplexml['url']}/ws-$rid";
				$filename = objectPathname($object);
				
				$data = file_get_contents($remotefile);
				if($data) file_put_contents($filename, $data);
			}
			
			$lo->displayorder = (int)$ro->displayorder;
			$lo->save();

			$lo->ext->doctext = base64_decode((string)$ro->doctext);
			$lo->ext->save();

			scanObjectBackground($lo);
		}
		
		// then look for courses
	}
	
	public function actionRemoteImport()
	{
		$id = getparam('id');
		
		$import = getdbo('FolderImport', $id);
		if(!$import) return;

		// http://docs.sansspace.com/object?id=3817/5-post-installation-process
		$url = substr($import->pathname, 0, strpos($import->pathname, '/', 8));
		debuglog($url);

		$simplexml = initSimpleXml($url, $import->username, $import->password);
		if(!$simplexml) return;

		$id = intval(substr($import->pathname, strpos($import->pathname, 'id=')+3));
		$this->importObject($simplexml, $id, $import->objectid);
	}

	public function actionGenerateThumbnails()
	{
		$file = getdbo('VFile', getparam('id'));
		mediaThumbnailForPlayer($file);
	
	//	$file->scanstatus = CMDB_OBJECTSCAN_READY;
	//	$file->update();
	}
	
	
}



