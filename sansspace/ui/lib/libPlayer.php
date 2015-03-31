<?php

///////////////////////////////////////////

function showMediaContent($file)
{
	$name = addslashes(removeExtension($file->name));
	
	$autostart = getparam('autoplay');
	if(!$autostart) $autostart = param('autoplay');
	
	$parentid = preg_replace('/\/.*$/', '', getparam('parentid'));
	$startpos = preg_replace('/\/.*$/', '', getparam('startpos'));
	$playnext = preg_replace('/\/.*$/', '', getparam('playnext'));
	$templateid = preg_replace('/\/.*$/', '', getparam('templateid'));
	$recordid = preg_replace('/\/.*$/', '', getparam('recordid'));
	$subtitlesid = preg_replace('/\/.*$/', '', getparam('subtitlesid'));
	$bookmarksid = preg_replace('/\/.*$/', '', getparam('bookmarksid'));
	$masterid = $file->id;
	
	if($file->filetype == CMDB_FILETYPE_SRT)
	{
		$subtitlesid = $file->id;
		$masterid = 0;
	}
	
	else if($file->filetype == CMDB_FILETYPE_BOOKMARKS)
	{
		$bookmarksid = $file->id;
		$masterid = 0;
	}
	
	if($file->original && $file->original->filetype == CMDB_FILETYPE_MEDIA)
	{
		$masterid = $file->original->id;
		
		if($file->filetype == CMDB_FILETYPE_MEDIA)
			$recordid = $file->id;
	}
	
	if(!$masterid)
	{
		$f = getdbosql('VFile', "id != $recordid and name like '%$name%' and parentid=$file->parentid and filetype=".CMDB_FILETYPE_MEDIA);
		if($f) $masterid = $f->id;
	}
	
	if(!$recordid)
	{
		$f = getdbosql('VFile', "originalid=$file->id and parentid=$file->parentid and filetype=".CMDB_FILETYPE_MEDIA);
		if($f) $recordid = $f->id;
	}
	
	if(!$subtitlesid)
	{
		$f = getdbosql('VFile', "name like '%$name%' and parentid=$file->parentid and filetype=".CMDB_FILETYPE_SRT);
		if($f) $subtitlesid = $f->id;
	}
	
	if(!$bookmarksid)
	{
		$f = getdbosql('VFile', "name like '%$name%' and parentid=$file->parentid and filetype=".CMDB_FILETYPE_BOOKMARKS);
		if($f) $bookmarksid = $f->id;
		
		else
		{
			$f = getdbosql('VFile', "name like 'Bookmark - $name%' and parentid=$file->parentid and filetype=".CMDB_FILETYPE_BOOKMARKS);
			if($f) $bookmarksid = $f->id;
		}
	}
	
	if(!$parentid) $parentid = $file->parentid;
	if($playnext) $autostart = 1;
	
	$flashvars = 
		"masterid=$masterid&recordid=$recordid".
		"&autostart=$autostart&startpos=$startpos".
		"&playnext=$playnext&parentid=$parentid".
		"&templateid=$templateid&subtitlesid=$subtitlesid".
		"&bookmarksid=$bookmarksid";

	debuglog($flashvars);
	ShowApplication($flashvars, 'recorder', 'sansmediad', 320);
	JavascriptReady("RightClick.init('$name');");
	
	$f = getdbosql('VFile', "name like '$name%' and parentid=$file->parentid and filetype=".CMDB_FILETYPE_TEXT);
	if($f)
	{
		$text = file_get_contents(objectPathname($f));
		showObjectHeader($f);
		echo "<div>$text</div>";
	}
	
	$f = getdbosql('VFile', "name like '$name%' and parentid=$file->parentid and filetype=".CMDB_FILETYPE_IMAGE);
	if($f)
	{
		showObjectHeader($f);
		echo "<div>".img(fileUrl($f))."</div>";
	}

	$f = getdbosql('VFile', "name like '$name%' and parentid=$file->parentid and filetype=".CMDB_FILETYPE_PDF);
	if($f)
	{
		$url = "/file?id=$f->id";
		if(param('usetrackdoc')) $url = "/file/trackdoc?id=$f->id";
		
		JavascriptReady("window.open('$url', 'sansspace_tracking_$f->id');");
	}

	$f = getdbosql('VFile', "name like '$name%' and parentid=$file->parentid and filetype=".CMDB_FILETYPE_URL);
	if($f)
	{
		$url = "/file?id=$f->id";
		if(param('usetrackdoc')) $url = "/file/trackdoc?id=$f->id";
		
		JavascriptReady("window.open('$url', 'sansspace_tracking_$f->id');");
	}

	JavascriptReady("window.focus();");
}

function showLiveContent($file)
{
	JavascriptReady("window.open('/recorder/showlive?id=$file->id', '_blank',
		'width=1024,height=600,location=no,menubar=no,resizable=yes,status=yes,toolbar=no');");
}

//////////////////////////////////////////////////////////////////

function getMiniPlayer($file, $width=480)
{
	$autostart = getparam('autoplay');
	$startpos = preg_replace('/\/.*$/', '', getparam('startpos'));
	$templateid = preg_replace('/\/.*$/', '', getparam('templateid'));
	$subtitlesid = getparam('subtitlesid');
	$bookmarksid = getparam('bookmarksid');
	$masterid = $file->id;
	
	$flashvars = 
		"masterid=$masterid&autostart=$autostart&startpos=$startpos".
		"&templateid=$templateid&subtitlesid=$subtitlesid&bookmarksid=$bookmarksid";

	$flashvars .= 
		"&headercolor=".preg_replace('/#/', '0x', param('appheadercolor')).
		"&headerback=".preg_replace('/#/', '0x', param('appheaderback')).
		"&maincolor=".preg_replace('/#/', '0x', param('appmaincolor')).
		"&mainback=".preg_replace('/#/', '0x', param('appmainback')).
		"&mainalpha=".preg_replace('/#/', '0x', param('appmainalpha')).
		"&slidercolor=".preg_replace('/#/', '0x', param('appslidercolor')).
		"&phpsessid=".session_id().
		"&autosave=".param('appautosave').
		"&servername=".$_SERVER['HTTP_HOST'].
		"&connect=".getPlayerConnect().
		"&connectrtmpt=".getPlayerConnectRtmpt().
		"&connecthttp=".getFullServerName();

//	debuglog($flashvars);
	$getflash = mainimg('install-flash.jpg');
	
	$result .= <<<END
	<div id='flashcontent_{$file->id}' style='width: 100%; height: 100%'>
<br><br><a href='http://get.adobe.com/flashplayer/' target=_blank>$getflash</a><br><br>
</div><br>
	
<script>
var params = {};
params.allowscriptaccess = "sameDomain";
params.allowfullscreen = "true";
params.wmode = "opaque";
var attributes = {};
attributes.id = "sansmediads_{$file->id}";
attributes.name = "sansmediads_{$file->id}";
attributes.align = "middle";

swfobject.embedSWF(
	"/extensions/players/sansmediads.swf", "flashcontent_{$file->id}",
	"$width", "34", "11.1.0", "playerProductInstall.swf",
	"$flashvars", params, attributes);

function setFlashMovieHeight_{$file->id}(height){
//	alert(height);
	$('#sansmediads_{$file->id}').css('height', height);
}

</script>
END;

	return $result;
}

// function showQuickPlayer($file, $height)
// {
// 	$connect = getPlayerConnect();
// 	$connecthttp = getFullServerName();
	
// 	$flashvars = "connect=$connect&fileid=$file->id&minimode=1&autostart=1&connecthttp=$connecthttp";
// 	echo getPlayerObject($file, $flashvars, '100%');
	
// 	Javascript("function setFlashMovieHeight_{$file->id}(height){
// 		$('#sansmediad_{$file->id}').css('height', '$height');}");
// }



/// html5 test

function showPlayer_notused($file)
{
//	$filename = 'http://localhost:8080/ws-755/IC-7-MX-20060703.mp4';
	$filename = fileUrl($file);
	
	echo <<<END
<video width="480" height="320" controls autoplay>
	<source src="$filename" />
	Your browser does not support the video tag.
</video>
END;
}





