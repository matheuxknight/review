<?php

function sortObjects($objects, $field, $reverse=false)
{
	$tmp = array();
	foreach($objects as $n=>$object)
	{
		if($object->file)
			$tmp[$n] = $object->file;
		else
			$tmp[$n] = $object;
	}
		
	$objects = my_array_sort($tmp, $field, $reverse);

	$tmp = array();
	if ($objects) foreach($objects as $n=>$object)
	{
		//if(!$object) mydump($object); die;
		if(isset($object->object))
			$tmp[$n] = $object->object;
		else
			$tmp[$n] = $object;
	}
	
	return $tmp;
}

function copyFile2Temp($file)
{
	$filename = filePlayableFilename($file);
	$tempname = SANSSPACE_TEMP.'/phpsessid='.session_id().'.flv';
	
	@unlink($tempname);
	@unlink($tempname.FLV_INDEX_EXTENSION2);
	
	debuglog("copyfile $filename, $tempname");
	@copy($filename, $tempname);
	
	// copy the samples file too
	
	$filename = objectPathnameSoundSamples($file);
	$tempname = SANSSPACE_TEMP.'/phpsessid='.session_id().'.samples';
	
	@unlink($tempname);
	
	debuglog("copyfile $filename, $tempname");
	@copy($filename, $tempname);
	
}

function isMediaFormatSupported($file)
{
	if(!$file) return false;
	
	$ext = strrchr($file->pathname, '.');
	if(strcasecmp($ext, '.flv')) return false;
	
	return true;
}



