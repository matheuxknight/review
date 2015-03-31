<?php

function ShowUploadHeader($multifiles=false)
{
	$filelimit = $multifiles? '0': '1';
	$sessionid = session_id();
	
	echo <<<END
	<link type="text/css" href="/extensions/upload/swfupload.css" rel="stylesheet" />
	<script type="text/javascript" src="/extensions/upload/swfupload.js"></script>
	<script type="text/javascript" src="/extensions/upload/swfupload.queue.js"></script>
	<script type="text/javascript" src="/extensions/upload/fileprogress.js"></script>
	<script type="text/javascript" src="/extensions/upload/handlers.js"></script>
	<script type="text/javascript">
		var swfu;

		window.onload = function () {
			swfu = new SWFUpload({
				// Backend settings
				flash_url: "/extensions/upload/swfupload.swf",
				upload_url: "/extensions/upload/upload.php?phpsessid=$sessionid",
				button_window_mode: "opaque",

				// Flash file settings
				file_types : "*.*",
				file_types_description : "All Files",
				file_size_limit : "0",
				file_upload_limit : "$filelimit",
				file_queue_limit : "$filelimit",

				// Button Settings
				button_image_url : "/extensions/upload/XPButtonUploadText_61x22.png",
				button_placeholder_id : "spanButtonPlaceholder",
				button_width: 68,
				button_height: 22,
				button_cursor : SWFUpload.CURSOR.HAND,
					
				// Custom Settings
				custom_settings : {
					progress_target : "fsUploadProgress",
					upload_successful : false
				},
				
				prevent_swf_caching: false,
				debug: false,
				
				// Event handler settings
				swfupload_loaded_handler : swfUploadLoaded,
				
				file_dialog_start_handler: fileDialogStart,
				file_dialog_complete_handler : fileDialogComplete,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				
				//upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				upload_error_handler : uploadError
			});
		};
	</script>
END;
}

function GetUploadedFilename()
{
	$phpsessid = session_id();
	$res = @opendir(SANSSPACE_TEMP);
	
	while(($filein = readdir($res)) !== false)
	{
		if(!preg_match("/^upload-$phpsessid-(.*?)$/", $filein, $match))
			continue;
			
		return SANSSPACE_TEMP."/$filein";
	}
	
	return null;
}

function HandleUploadedFiles($parentid)
{
//	debuglog("HandleUploadedFiles");
	$phpsessid = session_id();
	$fileid = 0;
//	$objects = array();

	$res = @opendir(SANSSPACE_TEMP);
	while(($filein = readdir($res)) !== false)
	{
		if(!preg_match("/^upload-$phpsessid-(.*?)$/", $filein, $match))
			continue;
			
		$pathname = $match[1];
	//	debuglog("file: $filein, path: $pathname");
		
		$object = new Object;
		$object->type = CMDB_OBJECTTYPE_FILE;
		
		$object = objectInit($object, $parentid);
		if(!$object) return 0;

	//	debuglog("object created ");
		
		$rfile = new File;
		$rfile->objectid = $object->id;
		
		$parent = getdbo('Object', $parentid);
		if($parent->folderimportid)
		{
			$object->folderimportid = $parent->folderimportid;
			$object->folderimport = getdbo('FolderImport', $object->folderimportid);
			$object->pathname = "$parent->pathname/$pathname";
		}
	
		else
			$object->pathname = "$object->id" . getExtension($pathname);

		$filename = objectPathname($object);
		@unlink($filename);

		$tempname = SANSSPACE_TEMP."/$filein";
		@rename($tempname, $filename);

		if(param('keepfileextension'))
			$object->name = $pathname;
		else
			$object->name = removeExtension($pathname);
		
		$object->save();
		$rfile->save();
		
		$object = scanFileObject($object);
	//	$object = scanObjectBackground($object);

		$fileid = $object->id;
	//	$objects[$count] = $object;
	//	$count++;
		debuglog("uploadfile done");
	}
	
	return $fileid;
}
	




