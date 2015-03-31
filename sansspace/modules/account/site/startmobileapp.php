<?php

$agent = $_SERVER['HTTP_USER_AGENT'];
$returnurl = preg_replace('/&.*$/', '', $_SERVER['REQUEST_URI']);

$appheadcolor = param('appheadercolor');
$appheadback = param('appheaderback');
$customcolor2 = currentPageColor2();

if(!empty($customcolor2))
	$appheadback = $customcolor2;
	
$flashvars =
	"&headercolor=".preg_replace('/#/', '0x', $appheadcolor).
	"&headerback=".preg_replace('/#/', '0x', $appheadback).
	"&maincolor=".preg_replace('/#/', '0x', param('appmaincolor')).
	"&mainback=".preg_replace('/#/', '0x', param('appmainback')).
	"&mainalpha=".preg_replace('/#/', '0x', param('appmainalpha')).
	"&slidercolor=".preg_replace('/#/', '0x', param('appslidercolor')).
	"&phpsessid=".session_id().
	"&returnurl=".getFullServerName().$returnurl.
	"&servername=".$_SERVER['HTTP_HOST'].
	"&connect=".getPlayerConnect().
	"&connectrtmpt=".getPlayerConnectRtmpt().
	"&connecthttp=".getFullServerName().
	"&autosave=".param('appautosave').
	"&bookmarkprefix=".param('bookmarkprefix');

$mode = 'browser';

if(preg_match('/ipad/i', $agent) || preg_match('/iphone/i', $agent))
{
	echo '<p>The SANSSpace iOS application is available on the Apple App Store.</p><p>Click the link below to install the app.</p>';
	echo "<a href='https://itunes.apple.com/app/sansspace/id630654357'>";
	echo mainimg('install-ipad.jpg').'<br>';
	echo "Install iOS App</a><br>";

	JavascriptReady("window.location='sansspace:mode=$mode&$flashvars'");
}

else if(preg_match('/android/i', $agent))
{
	echo '<br>';
	echo "<a href='javascript:window.location=\"sansspace:mode=$mode&$flashvars\"'>I already have the Android Application - Launch App<br>";

	echo l(mainimg('install-android.jpg', '', array('width'=>64)).
		"<br>Install Android Application", array('/site/installandroid')).'<br>';

	echo "<p>Before installing the sansspace android application from the link above, you need to allow ".
		"installation of apps from sources other than the Play Store.</p>".
		"<p>You will find this Android Settings under Security as \"Unknown Sources\".</p>";
}




