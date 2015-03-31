<?php

require_once('sansspace/ui/app.php');

$r = getparam('r');
$id = getparam('id');

$mimetype = "image/png";
switch($r)
{
	case 'ws':
		$file = getdbo('VFile', intval($id));
		$mimetype = $file->mimetype;
		
		$filename = objectPathname($file);
		if(strstr($filename, '.htm')) $mimetype = 'text/html';
		
		break;
		
	case 'download':
		$file = getdbo('VFile', intval($id));
		$mimetype = "application/binary";
		
		$filename = objectPathname($file);
		
		$ext = getExtension($file->pathname);
		$name = $file->name;
		
		if(!strstr($name, $ext))
			$name .= $ext;
		
		$disposition = "filename=\"$name\"";
		break;
		
	case 'plugin':
		$file = null;
		$name = utf8_decode(urldecode(getparam('id')));
		debuglog($name);
		
		$b = preg_match('/id=([0-9]*)/', $_SERVER['HTTP_REFERER'], $match);
		if($b && isset($match[0][1]))
		{
			$id = $match[0][1];
			$file = getdbosql('VFile', "name='$name' and parentlist like '%, $id, %'");
		}
		
		if(!$file)
			$file = getdbosql('VFile', "name='$name'");

		if(!$file)
			exit;	// 404
		
		$mimetype = $file->mimetype;
		
		$filename = objectPathname($file);
		if(strstr($filename, '.htm')) $mimetype = 'text/html';
		
		break;
		
	default:
		exit;
}

if(!file_exists($filename)) exit;
$filesize = dos_filesize($filename);

//$filedate = gmdate('D, d M Y H:i:s', filemtime($filename));

header("Content-Type: $mimetype");
header("Content-Length: $filesize");
header("Cache-Control: no-store, no-cache, must-revalidate");

if(isset($disposition))
	header("Content-Disposition: $disposition");

ob_clean();
flush();
readfile($filename);

exit;
	    
	    
