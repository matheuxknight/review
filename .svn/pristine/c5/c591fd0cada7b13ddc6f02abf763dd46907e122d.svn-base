<?php

function fileCreateData($parentid, $data, $data2)
{
	$object = new Object;
	$object->attributes = $data;
	$object->type = CMDB_OBJECTTYPE_FILE;
	
	if(empty($object->name))
		$object->name = 'unknown';

	$object = objectInit($object, $parentid);
	if(!$object) return null;

	$object->ext->attributes = $data2;
	$object->ext->save();
	
	$rfile = new File;
	$rfile->attributes = $data;
	$rfile->objectid = $object->id;

//	$count = HandleUploadedFiles($object, $rfile, $parentid);
//	if($count) return getdbo('Object', $object->id);

	if(isset($_POST['youtube_url']) && !empty($_POST['youtube_url']))
	{
		$object->pathname = "{$object->id}.mp4";

		$filename = objectPathname($object);
		@unlink($filename);

		$name = downloadYoutube($_POST['youtube_url'], $filename);
		debuglog("youtube name $name");

		if(empty($object->name) && $name)
			$object->name = $name;
	}

//	debuglog($_POST);
	if(isset($_POST['temp_url']) && !empty($_POST['temp_url']))
	{
		$object->pathname = $_POST['temp_url'];
		if(!strstr($object->pathname, "http://"))
			$object->pathname = 'http://'.$object->pathname;

		$pathparts = pathinfo($object->pathname);
		
		// check for downloadable files
		if(isset($_POST['download']))
		{
			$object->name = $pathparts['basename'];
			$buffer = fetch_url($object->pathname);
			
			$parent = getdbo('Object', $parentid);
			if($parent->folderimportid)
			{
				$object->folderimportid = $parent->folderimportid;
				$object->folderimport = getdbo('FolderImport', $object->folderimportid);
				$object->pathname = "$parent->pathname/$object->name";
			}
			
			else
				$object->pathname = "{$object->id}.{$extension}";

			$filename = objectPathname($object);
			@unlink($filename);

			file_put_contents($filename, $buffer);
		}
		
		else
		{
			if($object->name == 'unknown')
			{
				$buffer = fetch_url($object->pathname);
			//	$object->size = strlen($buffer);
			//	debuglog($buffer);
				
				$b = preg_match('/<title>(.*?)<\/title>/si', $buffer, $match);
				if($b) $object->name = trim(decode_string($match[1]));
			}

			$urlparts = parse_url($object->pathname);
			if($urlparts)
			{
				if(empty($object->name))
					$object->name = $urlparts['host'];

				if(!isset($urlparts['port']) || empty($urlparts['port']))
					$urlparts['port'] = 80;

				$urlicon = $urlparts['scheme'].'://'.$urlparts['host'].':'.
					$urlparts['port'].'/favicon.ico';

			//	error_log("fetching 2: $urlicon");
				$buffer = @fetch_url($urlicon);
				if($buffer && !empty($buffer))
				{
					$iconame = gettempfile('.ico');
					file_put_contents($iconame, $buffer);

					$imagename = objectImageFilename($object);
					@unlink($imagename);

					extractFilenameIcon($iconame, $imagename);
				}
			}
		}
	}

	if(empty($object->name))
	{
		$user = getUser();
		$object->name = "$user->name, ".now();
	}

	if(empty($object->pathname))
	{
		$object->pathname = "$object->id" . getExtension($object->name);
		$filename = objectPathname($object);
		
		if(!file_exists($filename))
			file_put_contents($filename, '');
	}
	
	$object->save();
	$rfile->save();

	$object = scanFileObject($object);
//	$object = scanObjectBackground($object);

	if($count) sleep(3);
	return getdbo('VFile', $object->id);
}

function fileUpdateData($file, $data, $data2)
{
	$object = getdbo('Object', $file->id);
	$rfile = getdbo('File', $file->id);
	
	$object->attributes = $data;
	$object->updated = now();
	
	$parent = getdbo('Object', $object->parentid);
	if(!controller()->rbac->objectAction($parent, 'update'))
		return null;
	
	$object->ext->attributes = $data2;
	$object->ext->save();
	
	$rfile->attributes = $data;
	
	$ok = $object->validate() && $rfile->validate();
	if(!$ok) return null;
	
	$object->save(false);
	$rfile->save(false);
	
	$object = getdbo('Object', $object->id);
	$object->parentlist = objectParentList($object);
	
	return getdbo('VFile', $object->id);
}

function fileDelete($file)
{
	if(!$file) return;

	$thumbnailpath = objectPathnameThumbnail($file);
	delete_folder($thumbnailpath);
	
	$tos = getdbolist('TranscodeObject', "fileid=$file->id");
	foreach($tos as $to)
	{
		@unlink(SANSSPACE_CACHE."/$to->pathname");
		@unlink(SANSSPACE_CACHE."/$to->pathname".FLV_INDEX_EXTENSION2);

		$to->delete();
	}
	
	$bookmarks = getdbolist('Bookmark', "fileid=$file->id");
	foreach($bookmarks as $bookmark)
	{
		$record = getdbo('VFile', $bookmark->recordid);
		if($record) objectDelete($record->object);
		
		$bookmark->delete();
	}
	
	$rfile = getdbo('File', $file->id);
	if(!$rfile) return;

	$rfile->delete();
}

///////////////////////////////////////////////////////////////////

function fileUrl($file, $prefix='ws')
{
	$ext = getExtension($file->pathname);
	$name = $file->name;

	if(!strstr($name, $ext))
		$name .= $ext;

	return "/$prefix-{$file->id}/{$name}";
}

function fileUrl2($file)
{
	$ext = getExtension($file->pathname);
	return "/contents/{$file->id}{$ext}";
}

function filePlayableFilename($file)
{
	$to = getdbosql('TranscodeObject', "fileid=$file->id and status=".CMDB_OBJECTTRANSCODE_COMPLETE);
	if($to)
		return fileTranscodedFilename($file->id, $to->templateid);
	else
		return objectPathname($file);
}

function fileTranscodedFilename($fileid, $templateid=0)
{
	if(!$templateid)
	{
		$template = getdbo('TranscodeTemplate', "active");
		$templateid = $template->id;
	}

	$to = getdbosql('TranscodeObject', "fileid=$fileid and $templateid=$templateid");
	if(!$to)
		return SANSSPACE_CACHE."/$fileid-$templateid.flv";

	return SANSSPACE_CACHE."/$to->pathname";
}

// function resetCacheObject($object)
// {
// 	if($object->type == CMDB_OBJECTTYPE_FILE)
// 	{
// 		$filename = fileTranscodedFilename($object->id);

// 		@unlink($filename);
// 		@unlink($filename.FLV_INDEX_EXTENSION);

// 		return;
// 	}

// 	$children = Object::model()->findAll("parentid={$object->id} and not deleted");
// 	foreach($children as $o) resetCacheObject($o);
// }




