<?php

class CFile
{
//	public $filename;
	public $filepath;
	public $size;
	public $date;
	public $mimetype;
	
	function __construct($filepath) 
	{
		$this->filepath = $filepath;
		
//		$path = rtrim($filepath, '/');
//		$a = explode('/', $path);
//		$this->filename = $a[count($a)-1];
		
		$this->size = dos_filesize($filepath);
		$this->date = @filemtime($filepath);
	
		$finfo = finfo_open(FILEINFO_MIME);
		$this->mimetype = @finfo_file($finfo, $filepath);
		
		finfo_close($finfo);
	}
}

