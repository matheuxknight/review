<?php
$this->pageTitle = app()->name ." - ". $object->name;
$user = getUser();

showRoleBar($object);
showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

echo processDoctext($object, $object->ext->doctext);

$course = getContextCourse();
$list = getdbolist('Object', "parentList like '%, {$course->recording->id}, %' and name='$object->name'");

foreach($list as $o)
{
	$u = $o->author;
	if($u) $o->name = $u->name;
}

showListResult($object->id, $list);

showObjectFooter($object);
showPreviousNext($object);
showObjectComments($object);

user()->setState('currentobject', $object->id);
user()->setState('currentversion', $object->version);

JavascriptReady("window.onbeforeunload = function(){
	$.ajax({url: '/object/leavepage?id=$object->id', async: false});}");







