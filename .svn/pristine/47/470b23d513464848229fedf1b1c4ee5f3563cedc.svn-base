<?php

function CustomTimeFormat($timeformat, $actualtime, $time)
{
	if(empty($timeformat)) $timeformat = 'Y-m-d H:i:s';
	$d = date($timeformat, $time);
	
	return $d;
}

function CustomGetValueTable($export, $user, $file, $course, $model)
{
	$a = array(
		'user'=>array(
			'id'=>$user->id,
			'name'=>$user->name,
			'logon'=>$user->logon,
			'email'=>$user->email,
			'custom'=>$user->custom1,
		),
	
		'file'=>array(
			'id'=>$file->id,
			'name'=>$file->name,
			'parentid'=>$file->parent->id,
			'parentname'=>$file->parent->name,
			'duration'=>$file->duration,
		),
	
		'course'=>array(
			'id'=>$course->id,
			'name'=>$course->name,
			'parentid'=>$course->parent->id,
			'parentname'=>$course->parent->name,
			'custom'=>$course->ext->custom,
		),
	
		'time'=>array(
			'start'=>CustomTimeFormat($export->timeformat, $model['starttime'], 
					strtotime($model['starttime'])),
				
			'end'=>CustomTimeFormat($export->timeformat, $model['starttime'], 
					strtotime($model['starttime'])+$model['duration']),
				
			'duration'=>sectoa($model['duration']),
		),
	);

	return $a;
}

