<?php

echo announcementRemove(trim($_REQUEST['num']));

function announcementRemove($num){
	$user = getUser();
    $a = explode(",",$user->announcement);
    array_push($a, $num);
	$a = implode(",", $a);
	$user->announcement = $a;
	$user->save();
}