<?php 

function weekdaySet($x,$user){
	$user->phone1 = $x;
	$user->save();	
	}
	
function daySet($a,$user){
	$user->address = $a;
	$user->save();
	}
	
function weekdayStringSet($y,$user){
	$user->organisation = $y;
	$user->save();
	}
	
function yesterdayCourseSet($z,$user){
	$user->city = $z;
	$user->save();
	}
	
function yesterdaySessionSet($y,$user){
	$user->postal = $y;
	$user->save();
	}
	
function yesterdayStudentSet($s,$user){
	$user->state = $s;
	$user->save();
	}

function yesterdayTeacherSet($t,$user){
	$user->country = $t;
	$user->save();
	}	
	
function getWeekdaystring($user){
		$x = $user->phone1;
		$a = $user->nowdayint;
		$weekdaystring = $user->organisation;
		if ($user->address != $a){
			if ($x == 7){
				$x = 0;
				$weekdaystring = "Sun";}
			elseif ($x == 1){
				$weekdaystring = "Mon";}
			elseif ($x == 2){
				$weekdaystring = "Tues";}
			elseif ($x == 3){
				$weekdaystring = "Wed";}
			elseif ($x == 4){
				$weekdaystring = "Thurs";}
			elseif ($x == 5){
				$weekdaystring = "Fri";}
			elseif ($x == 6){
				$weekdaystring = "Sat";}	
			weekdayStringSet($weekdaystring,$user);
			$x++;
		}
		weekdaySet($x,$user);
		return $weekdaystring;
	}