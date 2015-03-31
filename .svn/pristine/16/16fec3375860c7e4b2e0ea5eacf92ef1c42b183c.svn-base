<?php

$list = getdbolist('Object', "parentid=15853");
foreach($list as $object)
{
	if($object->size > 0) continue;
	debuglog("would delete $object->name");
	
	$object->delete();
}



