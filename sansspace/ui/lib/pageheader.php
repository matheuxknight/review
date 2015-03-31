<?php

echo <<<END
<!doctype html>
<!--[if IE 7 ]>		 <html class="no-js ie ie7 lte7 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 8 ]>		 <html class="no-js ie ie8 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 9 ]>		 <html class="no-js ie ie9 lte9>" lang="en-US"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" lang="en-US"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>$this->pageTitle</title>
END;

$theme = param('theme');
$iconset = currentPageTheme();

if(param('htmleditor') == 'elrte')
	echo CHtml::cssFile('/extensions/elrte/css/elrte.full.css');

echo CHtml::cssFile("/extensions/jquery/themes/$theme/jquery-ui.css");
echo CHtml::cssFile('/sansspace/ui/css/jquery-ui-fixes.css');

echo CHtml::cssFile('/framework-1.0.8/web/widgets/pagers/pager.css');
echo CHtml::cssFile('/sansspace/ui/css/main.css');
echo CHtml::cssFile('/sansspace/ui/css/objectmenu.css');
echo CHtml::cssFile('/sansspace/ui/css/sansspacemenu.css');
echo CHtml::cssFile('/sansspace/ui/css/navigationmenu.css');

if(param('theme') == 'wayside')
	echo CHtml::cssFile('/sansspace/ui/css/gravityswitch.css');

echo CHtml::scriptFile('/extensions/jquery/js/jquery-1.10.2.js');
echo CHtml::scriptFile('/sansspace/ui/js/jquery.migrate-1.2.1.js');

echo CHtml::scriptFile('/extensions/jquery/js/jquery-ui-1.10.4.js');
echo CHtml::scriptFile('/sansspace/ui/js/jquery.dialogextend.js');
echo CHtml::scriptFile('/sansspace/ui/js/jquery.yii.js');
echo CHtml::scriptFile('/sansspace/ui/js/jquery.tablesorter.js');
echo CHtml::scriptFile('/sansspace/ui/js/datetime.js');
echo CHtml::scriptFile('/sansspace/ui/js/util.js');
echo CHtml::scriptFile('/sansspace/ui/js/cookies.js');
echo CHtml::scriptFile('/extensions/players/swfobject.js');
echo CHtml::scriptFile('/extensions/players/rightClick.js');

echo CHtml::scriptFile('/sansspace/ui/js/objectmenu.js');
echo CHtml::scriptFile('/sansspace/ui/js/usermenu.js');
echo CHtml::scriptFile('/sansspace/ui/js/sansspacemenu.js');
echo CHtml::scriptFile('/sansspace/ui/js/navigationmenu.js');
echo CHtml::scriptFile('/sansspace/ui/js/objectlisting.js');
//echo CHtml::scriptFile('/sansspace/ui/js/bootstrap.min.js');

if(param('htmleditor') == 'elrte')
{
	echo CHtml::scriptFile('/extensions/elrte/js/elrte.full.js');
	echo CHtml::scriptFile('/extensions/elrte/js/i18n/elrte.en.js');
}

else if(param('htmleditor') == 'ck-editor')
	echo CHtml::scriptFile('/extensions/ckeditor/ckeditor.js');
else
	echo CHtml::scriptFile('/extensions/tiny_mce/tiny_mce_src.js');

echo CHtml::scriptFile('/sansspace/ui/js/objecteditor.js');
echo "<script>var param_editor='".param('htmleditor')."'</script>";

echo CHtml::scriptFile('/sansspace/ui/js/texteditor.js');
echo CHtml::scriptFile('/sansspace/ui/js/objectbrowser.js');

if(!user()->isGuest)
	echo CHtml::scriptFile('/sansspace/modules/account/connection/connection.js');

///////////////////////////////////////////////////////////////

function sendcssconfig($ui, $attr, $param, $extra='')
{
	$value = param($param);
	if(!empty($value))
	{
	//	debuglog("sendcssconfig $ui $attr $param $value");
		echo "<style>$ui { $attr: $value $extra;}</style>\n";
	}
}

sendcssconfig('.ui-widget-header, .ui-widget-header a', 'color', 'headercolor');
sendcssconfig('.ui-widget-header', 'background', 'headerback');
sendcssconfig('.ui-widget-header', 'border', 'headerborder');
sendcssconfig('.ui-widget-header', 'border-bottom', 'headerborderbot');

sendcssconfig('.fileinfo', 'color', 'headercolor', '!important');
sendcssconfig('.fileinfo', 'background-color', 'headerback', '!important');

sendcssconfig('.ui-state-default, .ui-state-default a', 'color', 'buttoncolor', '!important');
sendcssconfig('.ui-state-default', 'background', 'buttonback', '!important');
sendcssconfig('.ui-state-default', 'border', 'buttonborder', '!important');

sendcssconfig('.ui-state-hover, .ui-state-hover a', 'color', 'hovercolor', '!important');
sendcssconfig('.ui-state-hover', 'background', 'hoverback', '!important');
sendcssconfig('.ui-state-hover', 'border', 'hoverborder', '!important');

sendcssconfig('.ui-state-active, .ui-state-active a', 'color', 'activecolor', '!important');
sendcssconfig('.ui-state-active', 'background', 'activeback', '!important');
sendcssconfig('.ui-state-active', 'border', 'activeborder', '!important');

$filename = "/images/iconset/$iconset/default.css";
if(file_exists(SANSSPACE_HTDOCS.$filename))
	echo CHtml::cssFile($filename);

if(param('theme') != 'wayside')
	echo "<style>.page #headermenu { right: 80px;}</style>\n";






