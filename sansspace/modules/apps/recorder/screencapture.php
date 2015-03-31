<?php

$parent = getdbo('Object', getparam('id'));
if(!getparam('start'))
{
	$this->pageTitle = app()->name .' - '. $parent->name;
	$name = "Screen Capture - ".date('Y-m-d h:i').'.flv';
	
	showRoleBar($parent);
	showNavigationBar($parent->parent);
	showObjectHeader($parent);
	showObjectMenu($parent);
	
	echo "<h2>New Screen Capture</h2>";
	echo "<p class='formHint2'>You need to have Java installed and enabled to use this function.</p>";
	
	$this->widget('UniForm');
	echo CUFHtml::beginForm();
	
	echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));
	
	echo CUFHtml::openCtrlHolder();
	echo CUFHtml::label('Name', 'capturename');
	echo CUFHtml::textField('capturename', $name, array('class'=>'textInput'));
	echo "<p class='formHint2'></p>";
	echo CUFHtml::closeCtrlHolder();

	echo CUFHtml::closeTag('fieldset');
	echo CUFHtml::endForm();
	
	echo "<p class='formHint2'>Click the button below to start downloading 
			the .jnlp file that contains parameters to properly start the 
			Java Applet. Download it and run it if it does not start 
			automatically.";
	
	echo "<div id='startmessage'>Starting Screen Capture Java Applet, Please Wait...<br><br></div>";
	
	echo "<a href='#' id='buttonstart'>Start the Screen Capture Java Applet</a>";
	JavascriptReady("
		$('#startmessage').hide();
		$('#buttonstart').button().click(function (e){
			$('#startmessage').show();
			$('#buttonstart').hide();
			var name = encodeURIComponent($('#capturename').val());
			window.location.href='/recorder/screencapture?id=$parent->id&start=1&name='+name;
		});");
	
	return;
}

$name = urldecode(getparam('name'));
$file = safeCreateFile($name, $parent->id, '.flv', 0, CMDB_FILETYPE_LIVE);

$phpsessid = session_id();
$servername = getFullServerName();

$rtmpname = getServerName();
$rtmpport = SANSSPACE_RTMPPORT;
$rtmpsite = SANSSPACE_SITENAME;

header("Content-Type: application/x-java-jnlp-file");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Disposition: filename=\"$name.jnlp\"");

ob_clean();
flush();

echo <<<END
<?xml version='1.0' encoding='utf-8'?>
<jnlp spec='1.0+' codebase='$servername/extensions/screenshare'> 
	<information> 
		<title>ScreenShare</title>
		<vendor>sans</vendor>
		<offline-allowed/> 
	</information>
	<security>
		<all-permissions/>
	</security>	
	<resources> 
		<j2se version='1.6+'/> 
		<jar href='screenshare.jar'/> 
	</resources> 
	<application-desc main-class='org.redfire.screen.ScreenShare'>
		<argument>$rtmpname</argument> 
		<argument>$rtmpsite</argument> 
		<argument>$rtmpport</argument> 
		<argument>phpsessid=$phpsessid&fileid=$file->id&channel=1</argument>   
		<argument>flashsv1</argument>
		<argument>1</argument>
		<argument>1024</argument>
		<argument>768</argument>
	</application-desc> 
</jnlp>

END;
exit;



