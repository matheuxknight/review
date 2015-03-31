<?php

require_once('extensions/ffmpeg/phpvideotoolkit.php5.php');

function scanObjectBackground($object, $all=false)
{
	if(!$object) return null;
	debuglog("scanobject $object->name");
	
	$object->name = sanitizeObjectname($object->name);
	$object->scanstatus = CMDB_OBJECTSCAN_PENDING;
	$object->parentlist = objectParentList($object);
	$object->save();
	
	if($all)
		objectChangeAllFields($object, 'scanstatus', CMDB_OBJECTSCAN_PENDING);
			
	return getdbo('Object', $object->id);
}

function scanObject($object)
{
	$object->name = sanitizeObjectname($object->name);
	$object->parentlist = objectParentList($object);

	$object->scanstatus = CMDB_OBJECTSCAN_READY;
	$object->save();
	
	objectUpdateParent($object->parent);
	return $object;
}

function scanFileObject($object)
{
	$file = getdbo('VFile', $object->id);
	$file = scanFile($file);
	
	return $file->object;
}

function scanFile($file)
{
	$file->name = sanitizeObjectname($file->name);
	$file->parentlist = objectParentList($file);

	$file = scanFileInternal($file);

	$file->scanstatus = CMDB_OBJECTSCAN_READY;
	$file->update();
	
	$file = getdbo('VFile', $file->id);
	objectUpdateParent($file->parent);
	
	return $file;
}

function scanFileInternal($file)
{
	if(!$file) return null;

	if(preg_match("!^http://!", $file->pathname) || preg_match("!^https://!", $file->pathname))
	{
		$file->filetype = CMDB_FILETYPE_URL;
		return $file;
	}
	
	$filename = objectPathname($file);
	debuglog("scanfile $filename");
	
	$file->size = dos_filesize($filename);
//	debuglog("filesize $file->size");
	if(!$file->size && !file_exists($filename))
	{
	//	$file->filetype = CMDB_FILETYPE_UNKNOWN;
		debuglog("file does not exist $filename");
		return $file;
	}

	$file->deleted = false;
	
	$stampfilename = SANSSPACE_CONTENT."/stamped-$file->id.png";
	@unlink($stampfilename);
	
	$finfo = finfo_open(FILEINFO_MIME);
	$file->mimetype = preg_replace('/;[^;]+$/', '', @finfo_file($finfo, $filename));
	finfo_close($finfo);
	
	$extension = getExtension($file->pathname);
	if(empty($extension))
	{
		$file->filetype = CMDB_FILETYPE_DOCUMENT;
		return extractFileIcon($file);
	}
	
	switch($extension)
	{
		case '.flv': 
// 			$filename = objectPathname($file);
// 			$cmd = "\"" . SANSSPACE_BIN . "\\fixflv.exe\" \"$filename\"";

// 			debuglog("running $cmd");
// 			system($cmd);

		case '.mp4': case '.m4a': case '.m4v': case '.mov': case '.mpe':
		case '.avi': case '.wav': case '.mpg': case '.mpeg': case '.vob':
		case '.asx': case '.asf': case '.wmv': case '.wma': case '.mp3':
		case '.mts': case '.aif': case '.aiff': case '.aac': case '.rm':
			$file->filetype = CMDB_FILETYPE_MEDIA;
			$file = scanMediafile($file);
			
			if($file->hasvideo)
				mediaThumbnail($file);
			
			return $file;
			
		case '.swf':
			$file->filetype = CMDB_FILETYPE_SWF;
			return $file;

		case '.pdf':
			$file->filetype = CMDB_FILETYPE_PDF;
			return $file;
			
// 		case '.html':
// 		case '.htm':
// 		case '.js':
// 		case '.css':
// 			$file->filetype = CMDB_FILETYPE_TEXT;
// 			return $file;
			
		case '.srt':
			$filename = objectPathname($file);
			$data = file_get_contents($filename);
			
			$data = preg_replace('/<(.)+>/', '', $data);
			$data = preg_replace('/’/', "'", $data);

			file_put_contents($filename, $data);
			$file->filetype = CMDB_FILETYPE_SRT;
			
			return $file;
			
		default:
			$file->filetype = CMDB_FILETYPE_DOCUMENT;
	}
	
	if(strstr($file->mimetype, "image/"))
	{
		$file->filetype = CMDB_FILETYPE_IMAGE;
		return scanImage($file);
	}

	if(	strstr($file->mimetype, "text/") || 
		strstr($file->mimetype, "/x-empty") ||
		strstr($file->mimetype, "/xml"))
	{
		$file->filetype = CMDB_FILETYPE_TEXT;
		return $file;
	}
	
//	debuglog("$file->mimetype");
	return extractFileIcon($file);
}

//////////////////////////////////////////////////////////////////////////

function scanTranscodedFile($to)
{
	$filename = SANSSPACE_CACHE."/$to->pathname";
	if(!file_exists($filename) || dos_filesize($filename) == 0)
	{
		$to->status = CMDB_OBJECTTRANSCODE_ERROR;
		$to->save();
		
		debuglog("file not found $filename");
		return;
	}

//	$to->size = sprintf("%u", @filesize($filename));
	$to->size = dos_filesize($filename);

	$_toolkit = new PHPVideoToolkit();
//	$_toolkit->on_error_die = false;
	$data = $_toolkit->getFileInfo($filename);
	
	$to->bitrate = $data['bitrate']*1000;
	$to->save();
}

////////////////////////////////////////////////////////////////////////////

function scanImage($file)
{
	$filename = objectPathname($file);
	list($source_width, $source_height, $source_type) = @getimagesize($filename);
	
	$file->width = $source_width;
	$file->height = $source_height;
	
	if($source_type == NULL) return $file;
	$tmpname = '';
	
	switch($source_type)
	{
		case IMAGETYPE_GIF:
			$source_image = imagecreatefromgif($filename);
			break;
		case IMAGETYPE_JPEG:
			$source_image = imagecreatefromjpeg($filename);
			break;
		case IMAGETYPE_PNG:
			$source_image = imagecreatefrompng($filename);
			break;
		default:
			if(strstr($filename, '.bmp'))
			{
				$tmpname = gettempfile('.gd');
		
				ConvertBMP2GD($filename, $tmpname);
				$source_image = imagecreatefromgd($tmpname);
			}
			
			else
			{
				copy($filename, objectImageFilename($file));
				return $file;
			}
	}
	
	imageThumbnail($source_image, objectImageFilename($file));
	if(!empty($tmpname)) @unlink($tmpname);
	
	return $file;
}

function scanMediafile($file)
{
	$filename = objectPathname($file);
	debuglog("scanmediafile $filename");
	
	$_toolkit = new PHPVideoToolkit();
	$_toolkit->on_error_die = false;
	
	// need duration, audio/video codec, channels, dimensions, bitrate, mp3tag
	$data = $_toolkit->getFileInfo($filename);
	
	if(preg_match('/Metadata:(.*?)Duration:/s', $data['_raw_info'], $metadata))
	{
		$file->ext->mp3tags = '';
		$text = explode("\n", $metadata[1]);
		
		foreach($text as $item)
		{
			$item = trim($item);
			if(!empty($item))
			{
				$item = explode(':', $item);
				
				$item[0] = trim($item[0]);
				$item[1] = trim($item[1]);
				
				if(isset($mp3taglist[$item[0]]))
					$item[0] = $mp3taglist[$item[0]];
					
				$file->ext->mp3tags .= "{$item[0]}={$item[1]},";
				$file->ext->save();
			}
		}
	}
	
	$file->duration = $data['duration']['seconds']*1000 + 
		$data['duration']['timecode']['seconds']['excess']*10;
		
	$file->bitrate = $data['bitrate']*1000;
	if(!$file->bitrate && $file->duration)
		$file->bitrate = $file->size * 8 / ($file->duration / 1000);
	
	$file->hasaudio = isset($data['audio']);
	if($file->hasaudio)
	{
		$tempaudiocodec = $data['audio']['codec'];
		if($tempaudiocodec[1] == '[')
			$tempaudiocodec = substr($tempaudiocodec, strpos($tempaudiocodec, '/')+1);

		$tempaudiocodec = explode(' ', $tempaudiocodec);
		$file->audiocodec = $tempaudiocodec[0];
	}		
	
	$file->hasvideo = isset($data['video']);
	if($file->hasvideo)
	{
		$tempvideocodec = $data['video']['codec'];
		$tempvideocodec = explode(' ', $tempvideocodec);
		$file->videocodec = $tempvideocodec[0];
		
		$file->width = $data['video']['dimensions']['width'];
		$file->height = $data['video']['dimensions']['height'];

		$file->framerate = $data['video']['frame_rate'];
		$file->pixelratio = $data['video']['pixel_aspect_ratio'];
		$file->displayratio = $data['video']['display_aspect_ratio'];
	}
	
	//////////////////////////////////////////////////////////////////////
	
	if(!isMediaFormatSupported($file))	// && $file->folderimport && $file->folderimport->autotranscode)
	{
		$to = getdbosql('TranscodeObject', "fileid=$file->id and status=".CMDB_OBJECTTRANSCODE_COMPLETE);
		if(!$to)
		{
			$template = getdbosql('TranscodeTemplate', 'active');
			if($template)
			{
				$to = new TranscodeObject;
				$to->status = CMDB_OBJECTTRANSCODE_QUEUED;
				$to->fileid = $file->id;
				$to->templateid = $template->id;
				$to->pathname = "$file->id-$template->id.flv";
				$to->views = 0;
				$to->size = 0;
				$to->bitrate = 0;
				$to->message = 'Scheduled for processing.';
				$to->save();
			}
		}
	}
	
	mediaSoundSamples($file);
//	mediaThumbnailForPlayer($file);
	
	return $file;
}




