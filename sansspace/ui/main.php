<?php

require_once('tab.php');
require_once('header.php');
require_once('misc.php');

include 'lib/pageheader.php';

///////////////////////////////////////////////////////////////

echo "</head>";

echo "<body class='page'>";
require_once('analyticstracking.php');
echo "<div class='wrap' style='min-height:100%; position:relative'>";

if(controller()->id == 'docview')
{
	showPageContent($content);
	echo "</div></body></html>";
	
	return;
}

if(!IsMobileEmbeded() && controller()->id != 'docview')
{
	showPageHeader();

	if(param('theme') != 'wayside' || !user()->isGuest)
		showMainTabMenu();
}

$server = getdbo('Server', 1);
echo "<div style='padding-left: 10px' id='netmessage'>$server->netmessage</div>";

showFlashMessage();
$user = getUser();
if(!user()->isGuest){
	showAnnouncement(explode(",",$user->announcement));}
showPageContent($content);

if(IsMobileDevice() && !user()->isGuest){

}

elseif(!IsMobileDevice() && !user()->isGuest) showPageFooter($server);

echo "</div>";

JavascriptReady("$('a', '.buttonwrapper').button();");
JavascriptReady("$(':input', '.buttonwrapper').button();");
JavascriptReady("$(':button', '.ctrlHolder').button();");

$extraScript = $_COOKIE['login_extrascript'];
if($extraScript)
{
	$extraScript = urldecode($extraScript);
	echo $extraScript;

	setcookie('login_extrascript', '', 0, '/');
}

echo "</body></html>";




