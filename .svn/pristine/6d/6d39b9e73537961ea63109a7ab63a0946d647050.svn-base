<?php

debuglog("running fixdoublon");
$root = safeCreateObject("Language Courses", CMDB_OBJECTROOT_ID);

$languages = getdbolist('Object', "parentid=$root->id");
foreach($languages as $language)
{
	debuglog("language $language->name");

	$folders = getdbolist('Object', "parentid=$language->id");
	foreach($folders as $folder)
	{
		$pos = strpos($folder->name, ' - ');
		if($pos)
		{
			$foldername = substr($folder->name, 0, $pos);
			debuglog("  folder $folder->name");

			$realfolder = getdbosql('Object', "name='$foldername' and parentid=$language->id");
			if($realfolder)
			{
				$courses = getdbolist('VCourse', "parentid=$folder->id");
				foreach($courses as $course)
				{
					debuglog("  course $course->name");

					$b = preg_match('/([A-Z0-9]*)(.*)\(([0-9]*)\)/', $course->name, $matches);
					$coursename = "{$matches[1]} ({$matches[3]})";

					$realcourse = getdbosql('VCourse', "name='$coursename' and parentid=$realfolder->id");
					if(!$realcourse)
					{
						$object = $course->object;
						$object->name = $coursename;
						$object->save();

						objectMove($object, $realfolder->id);
					}
					else
						mergecourse($realcourse, $course);
				}

				$courses = getdbolist('VCourse', "parentid=$folder->id");
				if(!count($courses))
					objectDelete($folder);
			}
		}
	}

}

echo "<br>fix completed";
return;

function mergecourse($course1, $course2)
{
	debuglog("mergecourse $course1->name <<= $course2->name");

	$recordings2 = getdbolist('Object', "parentid=$course2->id and recordings");
	debuglog("  recordings count ".count($recordings2));

	foreach($recordings2 as $recording2)
	{
		debuglog("  recording $recording2->name");

		$userfolders2 = getdbolist('Object', "parentid=$recording2->id");
		foreach($userfolders2 as $userfolder2)
		{
			debuglog("    looking at folder $userfolder2->name");

			$userfiles2 = getdbolist('Object', "parentid=$userfolder2->id");
			foreach($userfiles2 as $userfile2)
			{
				debuglog("    ->> moving file $userfile2->name <<-");

				$b = preg_match('/\((.*)\)/', $userfolder2->name, $matches);
				$user = getdbosql('User', "logon='{$matches[1]}'");

				$recordinguser = userRecordingFolder($course1, $user);
				objectMove($userfile2, $recordinguser->id);
			}

			$userfiles2 = getdbolist('Object', "parentid=$userfolder2->id");
			if(!count($userfiles2))
				objectDelete($userfolder2);
		}

		$userfolders2 = getdbolist('Object', "parentid=$recording2->id");
		if(!count($userfolders2))
			objectDelete($recording2);
	}

	// other child objects
	$objects = getdbolist('Object', "parentid=$course2->id");
	foreach($objects as $object)
		objectMove($object, $course1->id);

	// enrollments
// 	$enrollments = getdbolist('Enrollment', "id=$course2->id");
// 	foreach($enrollments as $enrollment)
// 	{
// 		$enrollment2 = getdbolist('Enrollment',
// 			"id=$course1->id and userid=$enrollment->userid and objectid=$enrollment->objectid");
// 		if($enrollment2)
// 			$enrollment->delete();

// 		else
// 		{
// 			$enrollment->id = $course1->id;
// 			$enrollment->save();
// 		}
// 	}

	objectDelete($course2->object);
}







