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
END;

echo CHtml::cssFile('/sansspace/ui/css/main.css');
echo CHtml::scriptFile('/extensions/players/AC_OETags.js');

echo "<title>SANSSpace</title>";
echo "<style>body { margin: 0px; overflow:hidden }</style>";

echo "</head>";
echo "<body scroll='no'>";

if(!isset($_GET['id'])) die;

$file = getdbo('VFile', $_GET['id']); 
//VFile::model()->findByPk($_GET['id']);
if(!$file) die;

$url = fileUrl($file);
//mydump($url); die;

$height = 400;

echo "<script type='text/javascript'>
	AC_FL_RunContent(
		'src', '$url',
		'width', '1025',
		'height', '610',
		'align', 'middle',
		'id', '$file->id',
		'quality', 'high',
		'bgcolor', '#FFFFFF',
		'name', '$file->id',
		'allowfullscreen','true',
		'flashvars','',
		'allowScriptAccess','sameDomain',
		'type', 'application/x-shockwave-flash',
		'pluginspage', 'http://www.adobe.com/go/getflashplayer');</script>";

echo "</body></html>";







