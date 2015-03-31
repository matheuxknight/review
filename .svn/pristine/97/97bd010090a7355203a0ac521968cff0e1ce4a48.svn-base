<?php

echo "<br>This is site/test.php<br><br>";

// $user = getUser();
// if(!$user) return;

// foreach($user->courseenrollments as $enrollment)
// {
// }

$enrollments = getdbolist('CourseEnrollment');
foreach($enrollments as $enrollment)
{
	if($enrollment->object->type != CMDB_OBJECTTYPE_COURSE)
		$enrollment->delete();
}


