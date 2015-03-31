<?php

function extractFileIcon($file)
{
//	debuglog("extractFileIcon($file->name)");
	
	$filename = objectPathname($file);
	$imagename = objectImageFilename($file);
	
	extractFilenameIcon($filename, $imagename);
	return $file;
}

function extractFilenameIcon($sourcefile, $targetfile)
{
	$exticonexe = SANSSPACE_BIN."\\extracticon.exe";
	$bmpname = gettempfile('.bmp');
	
	$backcolor = '#ffffff';
	
//	debuglog("\"$exticonexe\" \"$sourcefile\" \"$bmpname\" $backcolor");
	exec("\"$exticonexe\" \"$sourcefile\" \"$bmpname\" $backcolor");
	if(!file_exists($bmpname)) return false;
	
	$tmpname = gettempfile('.gd');

	ConvertBMP2GD($bmpname, $tmpname);
	$image = imagecreatefromgd($tmpname);

 	$transparent = imagecolorallocate($image, 0xff, 0xff, 0xff);
	imagecolortransparent($image, $transparent);

	@unlink($targetfile);
	@imagepng($image, $targetfile);

	imagedestroy($image);
	
	@unlink($bmpname);
	@unlink($tmpname);
	
	return true;
}

///////////////////////////////////////////////////////////////////

function mediaThumbnail($file)
{
	require_once('extensions/ffmpeg/phpvideotoolkit.php5.php');
	$tumbnailsize = '50x46';
	
	$filename = objectPathname($file);
	$iconname = gettempfile('.png');

	if($file->filetype == CMDB_FILETYPE_MEDIA)
	{
		$ssframe = max(0, min(10, round($file->duration/1000)-1));
		$args = "-i \"$filename\" -an -ss $ssframe -r 1 -vframes 1 -s $tumbnailsize -y \"$iconname\"";
	}
	
	else
		$args = "-i \"$filename\" -an -r 1 -vframes 1 -s $tumbnailsize -y \"$iconname\"";
		
	exec('cmd /c ('.PHPVIDEOTOOLKIT_FFMPEG_BINARY.' '.$args.')');
	
	if(!file_exists($iconname) && $file->filetype == CMDB_FILETYPE_MEDIA)
	{
		$args = "-i \"$filename\" -an -r 1 -vframes 1 -s $tumbnailsize -y \"$iconname\"";
		exec('cmd /c ('.PHPVIDEOTOOLKIT_FFMPEG_BINARY.' '.$args.')');
	}
	
	if(file_exists($iconname))
	{
		$imagename = objectImageFilename($file);
		@unlink($imagename);

		imageCreateCorners($iconname, $imagename);
		@unlink($iconname);
	}
	
	return $file;
}

function mediaSoundSamples($file)
{
	debuglog("mediaSoundSamples($file->name)");
	
	require_once('extensions/ffmpeg/phpvideotoolkit.php5.php');

	$filename = objectPathname($file);
	$thumbnailpath = objectPathnameSoundSamples($file);
	
//	$args = "-i \"$filename\" -f s16be -ar 32 -y \"$thumbnailpath\"";

	$args = "-i \"$filename\" -f s8 -ac 1 -ar 48 -y \"$thumbnailpath\"";
	debuglog("ffmpeg $args");
	
	exec('cmd /c ('.PHPVIDEOTOOLKIT_FFMPEG_BINARY.' '.$args.')');
}

function mediaThumbnailForPlayer($file)
{
	debuglog("mediaThumbnailForPlayer($file->name)");
	
	require_once('extensions/ffmpeg/phpvideotoolkit.php5.php');
	$tumbnailsize = '120x90';

	$filename = objectPathname($file);
	$thumbnailpath = objectPathnameThumbnail($file);
	
	if(is_dir($thumbnailpath))
	{
		$t1 = filemtime($thumbnailpath);
		$t2 = strtotime($file->updated);
		
		if($t1 >= $t2) return;
		delete_folder($thumbnailpath);
	}
	
	@mkdir($thumbnailpath);
	
	$d = floor($file->duration/250000)+1;
	$step = "1/$d";
	
	// -ss startpos
	// -bt bitrate tolerance
	//
	
	$args = "-i \"$filename\" -ss 00:00:02.7 -f image2 -bt 20M -r $step -s $tumbnailsize -y \"$thumbnailpath\\%d.jpg\"";
	debuglog("ffmpeg $args");
	exec('cmd /c ('.PHPVIDEOTOOLKIT_FFMPEG_BINARY.' '.$args.')');
}

// not used
function imageSmooth($sourcefile, $targetfile)
{
//	debuglog("imageSmooth($sourcefile, $targetfile)");
	$image = @imagecreatefrompng($sourcefile);
	$color2 = imagecolorallocatealpha($image, 127, 127, 127, 40);
	
	imagecolortransparent($image, $color2);
	imagerectangle($image, 10, 10, 49, 45, $color2);

	imagepng($image, $targetfile);
	imagedestroy($image);
}

function imageCreateCorners($sourcefile, $targetfile, $radius=5)
{
	$q = 10; # change this if you want
	$radius *= $q;

	$src = @imagecreatefrompng($sourcefile);
	$w = imagesx($src);
    $h = imagesy($src);
	
	# find unique color
	do
	{
		$r = rand(0, 255);
		$g = rand(0, 255);
		$b = rand(0, 255);
	}
	while(imagecolorexact($src, $r, $g, $b) < 0);

	$nw = $w*$q;
	$nh = $h*$q;
	
	$img = imagecreatetruecolor($nw, $nh);
	$alphacolor = imagecolorallocatealpha($img, $r, $g, $b, 127);
	imagealphablending($img, false);
	imagesavealpha($img, true);
	imagefilledrectangle($img, 0, 0, $nw, $nh, $alphacolor);

	imagefill($img, 0, 0, $alphacolor);
	imagecopyresampled($img, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

	imagearc($img, $radius-1, $radius-1, $radius*2, $radius*2, 180, 270, $alphacolor);
	imagefilltoborder($img, 0, 0, $alphacolor, $alphacolor);
	imagearc($img, $nw-$radius, $radius-1, $radius*2, $radius*2, 270, 0, $alphacolor);
	imagefilltoborder($img, $nw-1, 0, $alphacolor, $alphacolor);
	imagearc($img, $radius-1, $nh-$radius, $radius*2, $radius*2, 90, 180, $alphacolor);
	imagefilltoborder($img, 0, $nh-1, $alphacolor, $alphacolor);
	imagearc($img, $nw-$radius, $nh-$radius, $radius*2, $radius*2, 0, 90, $alphacolor);
	imagefilltoborder($img, $nw-1, $nh-1, $alphacolor, $alphacolor);
	imagealphablending($img, true);
	imagecolortransparent($img, $alphacolor);

	# resize image down
	$dest = imagecreatetruecolor($w, $h);
	imagealphablending($dest, false);
	imagesavealpha($dest, true);
	imagefilledrectangle($dest, 0, 0, $w, $h, $alphacolor);
	imagecopyresampled($dest, $img, 0, 0, 0, 0, $w, $h, $nw, $nh);

	# output image
	imagepng($dest, $targetfile);
	
	imagedestroy($src);
	imagedestroy($img);
	imagedestroy($dest);
}

///////////////////////////////////////////////////////////////////

function imageThumbnail($source_image, $filename)
{
	$mw = 48;
	$mh = 48;
	
	$ow = imagesx($source_image);
	$oh = imagesy($source_image);
	
	if($ow < $mw) $mw = $ow;
	if($oh < $mh) $mh = $oh;
	
	$target_image = imagecreatetruecolor($mw, $mh);
	$source_index = imagecolortransparent($source_image);
	
	if($source_index >= 0 && $source_index < 255) 
		$transparent_color = imagecolorsforindex($source_image, $source_index);
	else
		$transparent_color = array('red' => 255, 'green' => 255, 'blue' => 255);
		
	$target_index = imagecolorallocate($target_image, 
		$transparent_color['red'], 
		$transparent_color['green'], 
		$transparent_color['blue']);
	
	imagefill($target_image, 0, 0, $target_index); 
	imagecolortransparent($target_image, $target_index); 
		
	imagecopyresampled($target_image, $source_image, 0, 0, 0, 0, $mw, $mh, $ow, $oh);
	imagepng($target_image, $filename);
	
	imagedestroy($source_image);
	imagedestroy($target_image);
}

function imageResample($sourcefile, $targetfile, $tw, $th)
{
//	debuglog("imageresample $sourcefile, $targetfile");
	$sourceimage = @imagecreatefrompng($sourcefile);
	if(!$sourceimage) return;
	
	$sw = imagesx($sourceimage);
    $sh = imagesy($sourceimage);

	$targetimage = imagecreatetruecolor($tw, $th);
	imagecopyresampled($targetimage, $sourceimage, 0, 0, 0, 0, $tw, $th, $sw, $sh);

	imagepng($targetimage, $targetfile);
}

function imageProcessAll($sourcefile, $targetfile)
{
	$tempname = gettempfile('.png');
	imageResample($sourcefile, $tempname, 50, 48);
	
	imageCreateCorners($tempname, $targetfile);
	@unlink($tempname);
}



