<?php

return array(
	'name'=>'SANSSpace',

	'defaultController'=>'site',
	'layout'=>'main',

	'basePath'=>SANSSPACE_HTDOCS."/sansspace",
	'runtimePath'=>SANSSPACE_SITEPATH."/runtime",

	'controllerPath'=>'sansspace/modules',
	'viewPath'=>'sansspace/modules',
	'layoutPath'=>'sansspace/ui',

	'preload'=>array('log'),
	'import'=>array('application.components.*'),
	'params'=>require(SANSSPACE_SITEPATH."/siteconfig.php"),
	
	'components'=>array(

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'appendParams'=>false,
		),

		'assetManager'=>array(
			'basePath'=>SANSSPACE_SITEPATH."/assets"),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				//	'levels'=>'trace, error, warning',
				),
//				array(
//					'class'=>'CProfileLogRoute',
//					'report'=>'summary',
//				),
			),
		),

		'user'=>array(
			'allowAutoLogin'=>true,
			'loginUrl'=>array('site/login'),
		),

		'cache'=>array(
			'class'=>'CFileCache',
			'cachePath'=>SANSSPACE_SITEPATH."/runtime",
		),

		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString'=>
				"mysql:host=".SANSSPACE_DBHOST.";dbname=".SANSSPACE_DBNAME,
		
			'username'=>SANSSPACE_DBUSER,
			'password'=>SANSSPACE_DBPASSWORD,
		
			'enableProfiling'=>false,
			'charset'=>'utf8',
			'schemaCachingDuration'=>3600,
		),
	),
	

);





