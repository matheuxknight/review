<?php

function GenerateFullDocumentation($object, $level=1)
{
	switch($level)
	{
		case 1:
			echo "<h1>$object->name</h1>";
			break;
		
		case 2:
			echo "<h2>$object->name</h2>";
			break;
		
		case 3:
			echo "<h3>$object->name</h3>";
			break;
		
		default:
			echo "<h4>$object->name</h4>";
			break;
	}

	echo processDoctext($object, $object->ext->doctext);
		
	$children = getdbolist('Object', "parentid={$object->id} and not deleted and not hidden order by displayorder, name");
	//Object::model()->findAll(
	//	"parentid={$object->id} and not deleted and not hidden order by displayorder, name");

	foreach($children as $object1)
		GenerateFullDocumentation($object1, $level+1);
		
}


