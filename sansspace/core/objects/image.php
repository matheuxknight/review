<?php

/////////////////////////////////////////////////////////////////

function objectImageFilename($object)
{
	return SANSSPACE_CONTENT."\\object-$object->id.png";
}

function objectImage($object, $size = 48, $text='')
{
// 	switch($object->type)
// 	{
// 		case CMDB_OBJECTTYPE_OBJECT:
// 			return "<i style='font-size: {$size}px;' class='fa fa-folder-o'></i>";
// 	}
	
	if(!$object) return '';
//	return img(objectImageUrl($object), $text, array('width'=>$size));
	return img(objectImageUrl($object), $text, array('style'=>"max-width:{$size}px;max-height:{$size}px;"));
}

function objectImageUrl($object)
{
	$filename = SANSSPACE_CONTENT."/stamped-$object->id.png";
	if(file_exists($filename)) return "/contents/stamped-$object->id.png";

	$filename = SANSSPACE_CONTENT."/object-$object->id.png";
	$urlname = "/contents/object-$object->id.png";

	if(!file_exists($filename))
	{
		if($object->type == CMDB_OBJECTTYPE_LINK)
		{
			$filename = SANSSPACE_CONTENT."/object-{$object->link->id}.png";
			$urlname = "/contents/object-{$object->link->id}.png";

			if(!file_exists($filename))
			{
				$name = objectImageNameInternal($object->link);
				$iconset = param('iconset');

				$filename = SANSSPACE_HTDOCS."/images/iconset/$iconset/$name";
				$urlname = iconurl($name);
			}
		}
		else
		{
			$name = objectImageNameInternal($object);
			$iconset = param('iconset');

			$filename = SANSSPACE_HTDOCS."/images/iconset/$iconset/$name";
			$urlname = iconurl($name);
		}
	}

	if($object->deleted)
		return objectStampImage($object, $filename, $urlname, '/images/ui/16x16_delete.png');

	if($object->hidden)
		return objectStampImage($object, $filename, $urlname, '/images/ui/16x16_fileclose.png');

	if($object->type == CMDB_OBJECTTYPE_LINK)
		return objectStampImage($object, $filename, $urlname, '/images/ui/16x16_link.png');

	return $urlname;
}

////////////////////////////////////////////////////////////////

function objectImageNameInternal($object)
{
	if($object->id == CMDB_OBJECTROOT_ID) return 'home.png';

	switch($object->type)
	{
		case CMDB_OBJECTTYPE_OBJECT:
		case CMDB_OBJECTTYPE_TEXTBOOK:
			$iconset = param('iconset');
			$filename = SANSSPACE_HTDOCS."/images/iconset/$iconset/$object->name.png";

			if(file_exists($filename))
				return "$object->name.png";

			if($object->post)
				return 'post.png';

			else if($object->name == CMDB_PERSONALFOLDERNAME)
				return 'system.png';

			else
				return 'folder.png';

		case CMDB_OBJECTTYPE_COURSE:
			return 'course.png';
		case CMDB_OBJECTTYPE_LESSON:
			return 'lesson.png';
		case CMDB_OBJECTTYPE_QUIZ:
			return 'quiz.png';
		case CMDB_OBJECTTYPE_QUESTIONBANK:
			return 'questions.png';
		case CMDB_OBJECTTYPE_FLASHCARD:
			return 'flashcard.png';
		case CMDB_OBJECTTYPE_SURVEY:
			return 'survey.png';

		case CMDB_OBJECTTYPE_FILE:
			$file = $object->file;
			if(!$file) return 'text.png';

			else switch($file->filetype)
			{
				case CMDB_FILETYPE_MEDIA:
					if($file->hasvideo)
						return 'video.png';
					else
						return 'audio.png';

				case CMDB_FILETYPE_LIVE:
					return 'video.png';
					
				case CMDB_FILETYPE_URL:
					return 'url.png';

				case CMDB_FILETYPE_BOOKMARKS:
					return 'bookmarks.png';

// 				case CMDB_FILETYPE_APPLICATION:
// 					return 'app.png';

				case CMDB_FILETYPE_PDF:
					return 'pdf.png';

				case CMDB_FILETYPE_SWF:
					return 'swf.png';

				default:
					return 'text.png';
			}
	}

	return '';
}

///////////////////////////////////////////////////////////////////////////

function objectStampImage($object, $sourcefile, $urlname, $stampname)
{
//	debuglog($sourcefile);
	$targeturl = "/contents/stamped-$object->id.png";

	$targetfile = SANSSPACE_CONTENT."/stamped-$object->id.png";
	if(file_exists($targetfile)) return $targeturl;

	list($source_width, $source_height, $source_type) = @getimagesize($sourcefile);
	if($source_type === null) return $targeturl;

	switch($source_type)
	{
		case IMAGETYPE_GIF:
			$source_image = @imagecreatefromgif($sourcefile);
			break;
		case IMAGETYPE_JPEG:
			$source_image = @imagecreatefromjpeg($sourcefile);
			break;
		case IMAGETYPE_PNG:
			$source_image = @imagecreatefrompng($sourcefile);
			break;
		default:
			return $targeturl;
	}

	if(!$source_image) return null;

	imagealphablending($source_image, true);
	imagesavealpha($source_image, true);

    $overlay_image = imagecreatefrompng(SANSSPACE_HTDOCS."/{$stampname}");

	imagealphablending($overlay_image, true);
	imagesavealpha($overlay_image, true);

	$overlay_width = imagesx($overlay_image);
    $overlay_height = imagesy($overlay_image);

	imagecopy(
		$source_image, $overlay_image,
		$source_width - $overlay_width,
		$source_height - $overlay_height-3,
		0, 0, $overlay_width, $overlay_height);

	imagepng($source_image, $targetfile);

	imagedestroy($source_image);
	imagedestroy($overlay_image);

	return $targeturl;
}



