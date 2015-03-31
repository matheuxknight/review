<?php

require_once('framework-1.0.8/yii.php');
require_once('sansspace/include.php');

if(SANSSPACE_DEBUG) define('YII_DEBUG', true);
$sitepath = SANSSPACE_SITEPATH;

$siteconfig = "$sitepath/siteconfig.php";
if(!is_file($siteconfig))
{
	debuglog("Creating $siteconfig config file");
	
	$fp = fopen("$sitepath/siteconfig.php", 'w');
	if(!$fp) die("");

	fwrite($fp, "<?php\nreturn array(\n");
	fwrite($fp, ");\n\n");
		
	fclose($fp);
}

$app = Yii::createWebApplication('sansspace/config.php');
$app->name = param('title');
	

