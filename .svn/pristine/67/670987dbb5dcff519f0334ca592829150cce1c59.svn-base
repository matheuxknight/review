<?php

define('SSPACE_ROLE_NETWORK', 1);
define('SSPACE_ROLE_ADMIN', 2);

define('SSPACE_ROLE_CONTENT', 10);
define('SSPACE_ROLE_TEACHER', 15);
define('SSPACE_ROLE_STUDENT', 20);
define('SSPACE_ROLE_OWNER', 25);
define('SSPACE_ROLE_FORUM', 30);

define('SSPACE_ROLE_USER', 50);
define('SSPACE_ROLE_ALL', 60);

//define('SSPACE_ROLE_PRESENTER', 8);

function RbacDefaultRoles()
{
	$roles = array(

		SSPACE_ROLE_NETWORK=>array(
			'id'=>SSPACE_ROLE_NETWORK,
			'name'=>'network',
			'description'=>'Network',
			'type'=>'',
		),

		SSPACE_ROLE_ADMIN=>array(
			'id'=>SSPACE_ROLE_ADMIN,
			'name'=>'admin',
			'description'=>'Admin',
			'type'=>'user',
		),

		SSPACE_ROLE_CONTENT=>array(
			'id'=>SSPACE_ROLE_CONTENT,
			'name'=>'content',
			'description'=>'Content',
			'type'=>'user, object, course',
		),

		SSPACE_ROLE_OWNER=>array(
			'id'=>SSPACE_ROLE_OWNER,
			'name'=>'owner',
			'description'=>'Owner',
			'type'=>'user, object',
		),

		SSPACE_ROLE_FORUM=>array(
			'id'=>SSPACE_ROLE_FORUM,
			'name'=>'forum',
			'description'=>'Forum',
			'type'=>'user, object',
		),

		SSPACE_ROLE_TEACHER=>array(
			'id'=>SSPACE_ROLE_TEACHER,
			'name'=>'teacher',
			'description'=>'Teacher',
			'type'=>'user, object, course',
		),

		SSPACE_ROLE_STUDENT=>array(
			'id'=>SSPACE_ROLE_STUDENT,
			'name'=>'student',
			'description'=>'Student',
			'type'=>'user, course',
		),

		SSPACE_ROLE_USER=>array(
			'id'=>SSPACE_ROLE_USER,
			'name'=>'user',
			'description'=>'Registered User',
			'type'=>'user, object',
		),

		SSPACE_ROLE_ALL=>array(
			'id'=>SSPACE_ROLE_ALL,
			'name'=>'all',
			'description'=>'Everyone',
			'type'=>'user, object',
		),

	);
	
	return $roles;
}




