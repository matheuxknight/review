<?php

require_once('tab.php');
require_once('header.php');
require_once('misc.php');

echo <<<END
<!doctype html>
<!--[if IE 7 ]>		 <html class="no-js ie ie7 lte7 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 8 ]>		 <html class="no-js ie ie8 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 9 ]>		 <html class="no-js ie ie9 lte9>" lang="en-US"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" lang="en-US"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>ERROR</title>
</head>
END;

echo CHtml::cssFile('/extensions/jquery/themes/'.param('theme').'/jquery-ui.css');
echo CHtml::cssFile('/framework-1.0.8/web/widgets/pagers/pager.css');
echo CHtml::cssFile('/sansspace/ui/css/jquery-ui-fixes.css');
echo CHtml::cssFile('/sansspace/ui/css/main.css');

echo CHtml::scriptFile('/extensions/jquery/js/jquery-1.6.2.min.js');
echo CHtml::scriptFile('/extensions/jquery/js/jquery-ui-1.8.17.custom.min.js');
echo CHtml::scriptFile('/sansspace/ui/js/jquery.dialogextend.js');

//echo CHtml::scriptFile('/sansspace/ui/js/callsession.js');
echo CHtml::scriptFile('/sansspace/ui/js/jquery.yii.js');
echo CHtml::scriptFile('/sansspace/ui/js/jquery.tablesorter.js');
echo CHtml::scriptFile('/sansspace/ui/js/datetime.js');

echo CHtml::cssFile('/sansspace/ui/css/objectmenu.css');
echo CHtml::cssFile('/sansspace/ui/css/sansspacemenu.css');
echo CHtml::cssFile('/sansspace/ui/css/navigationmenu.css');
//echo CHtml::cssFile('/sansspace/ui/css/jquerycssmenu.css');

echo CHtml::scriptFile('/sansspace/ui/js/objectmenu.js');
echo CHtml::scriptFile('/sansspace/ui/js/usermenu.js');
echo CHtml::scriptFile('/sansspace/ui/js/sansspacemenu.js');
echo CHtml::scriptFile('/sansspace/ui/js/navigationmenu.js');
//echo CHtml::scriptFile('/sansspace/ui/js/jquerycssmenu.js');
echo CHtml::scriptFile('/sansspace/ui/js/objectlisting.js');

echo "<body class='page'>";

showPageHeader();
showMainTabMenu();

//...

showPageFooter();
echo "</body></html>";

echo "<script>$(function(){ $('a', '.buttonwrapper').button();});</script>";
echo "<script>$(function(){ $(':button', '.ctrlHolder').button();});</script>";




