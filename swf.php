<?php

require_once('sansspace/ui/app.php');
$app->setBasePath('sansspace');

array_walk(glob($app->getBasePath().'/lib/libutil/*.php'), create_function('$v, $i', 'return require_once($v);'));
array_walk(glob($app->getBasePath().'/lib/libview/*.php'), create_function('$v, $i', 'return require_once($v);'));

require_once($app->getBasePath().'/views/layouts/swf.php');

