<?php

include '/sansspace/ui/lib/pageheader.php';
echo "</head><body>";

$getflash = mainimg('getflash.jpg');

$flashvars .=
	"&masterid=$file->id".
	"&headercolor=".preg_replace('/#/', '0x', param('appheadercolor')).
	"&headerback=".preg_replace('/#/', '0x', param('appheaderback')).
	"&maincolor=".preg_replace('/#/', '0x', param('appmaincolor')).
	"&mainback=".preg_replace('/#/', '0x', param('appmainback')).
	"&mainalpha=".preg_replace('/#/', '0x', param('appmainalpha')).
	"&slidercolor=".preg_replace('/#/', '0x', param('appslidercolor')).
	"&phpsessid=".session_id().
	"&autosave=".param('appautosave').
	"&connect=".getPlayerConnect().
	"&servername=".$_SERVER['HTTP_HOST'].
	"&connectrtmpt=".getPlayerConnectRtmpt().
	"&connecthttp=".getFullServerName();

echo "<div id='flashcontent' style='width: 100%; height: 100%'>
	<br><br>&nbsp;&nbsp;<a href='http://get.adobe.com/flashplayer/' target=_blank>$getflash</a><br><br></div>";

echo <<<END
<style>
html
{
	height: 100%;
	overflow: hidden;
}

body
{
	height: 100%;
	margin: 0;
	padding: 0;
}

#sansmediads
{
	height: 100%;
}

#htmlcontainer
{
	position: absolute;
	top: 34px;
	left: 0px;
	right: 0px;
	height: auto;
	padding: 10px;
	display: block;
	z-index: 100;
	overflow-y: auto;
/*	background-color: yellow;*/
}

</style>
		
<script>
var params = {};
params.allowscriptaccess = "sameDomain";
params.allowfullscreen = "true";
params.wmode = "opaque";
var attributes = {};
attributes.id = "sansmediads";
attributes.name = "sansmediads";
attributes.align = "middle";

swfobject.embedSWF("/extensions/players/sansmediads.swf", "flashcontent", "100%", "100%", 
	"11.1.0", "playerProductInstall.swf", "$flashvars", params, attributes);

</script>
		
</body>


END;




