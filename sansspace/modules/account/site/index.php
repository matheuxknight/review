<?php

if(param('theme') == 'wayside')
{
	controller()->redirect('/my');
	return;
}

$this->pageTitle = Yii::app()->name;

$server = getdbo('Server', 1);
if($server) echo "$server->description";

$objects = getdbolist('Object', "frontpage order by displayorder, updated desc");
//Object::model()->findAll("frontpage order by displayorder, updated desc");
foreach($objects as $object) showHomeItem($object);








