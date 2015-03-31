<?php

function canQuickContent($object)
{
	if(!$object) return false;
	if(!empty($object->ext->doctext)) return true;
	if($object->type != CMDB_OBJECTTYPE_FILE) return false;
	
	$file = $object->file;
	
	if($file->filetype == CMDB_FILETYPE_URL) return true;
	if($file->filetype == CMDB_FILETYPE_PDF) return true;
	if($file->filetype == CMDB_FILETYPE_MEDIA) return true;
	
	if(	strstr($file->mimetype, 'image/') ||
		strstr($file->mimetype, 'text/')) return true;
				
	return false;
}

function heightQuickContent($object)
{
	if(!$object) return 0;
	if($object->type == CMDB_OBJECTTYPE_FILE)
	{
		$file = $object->file;
		if($file->filetype == CMDB_FILETYPE_MEDIA)
			if(!$file->hasvideo) return 150;
	}
	
	return 520;
}

function showQuickContent($object, $height='99%')
{
	if($object->type != CMDB_OBJECTTYPE_FILE)
	{
		echo processDoctext($object, $object->ext->doctext);
		return;
	}

	$file = $object->file;
	if(strstr($file->mimetype, 'image/'))
	{
		echo img(fileUrl($file));
		return;
	}
	
	else if(strstr($file->mimetype, 'text/'))
	{
		echo "<pre style='word-wrap: break-word'>";
		readfile(objectPathname($file));
		echo "</pre>";

		return;
	}
	
	switch($file->filetype)
	{
		case CMDB_FILETYPE_URL:
			showQuickContentFrame($file->pathname);
			break;

		case CMDB_FILETYPE_PDF:
			showQuickContentFrame(fileUrl($file));
			break;
			
		case CMDB_FILETYPE_MEDIA:
			showQuickPlayer($file, $height);
			break;
			
		default:
			echo processDoctext($object, $object->ext->doctext);
	}
}

function showQuickContentFrame($url)
{
	echo <<<END
<iframe id="linkframe" frameborder=0 src="{$url}" width="100%" height="99%">
<p>Your browser does not support iframes.</p></iframe>
END;
}





