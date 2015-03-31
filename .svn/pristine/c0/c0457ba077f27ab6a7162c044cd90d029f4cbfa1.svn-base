<?php

class UsergenController extends CommonController
{
	public $defaultAction = 'show';
	
	public function actionShow()
	{
		$this->render('show');
	}
	
	function simulateSession($times, $user, $client, $semester, $course)
	{
		$platform_table = array(
			"Mac, Safari 6.0.1",
			"Mac, Safari 6.0.1",
			"Mac, Safari 6.0.1",
			"Mac, Safari 6.0.1",
			"Mac, Safari 6.0.1",
			"Mac, Firefox 11.0",
			"Mac, Chrome 23.0.1271.64",
			"Mac, Chrome 23.0.1271.64",
			"Mac, Chrome 23.0.1271.64",
			"Mac, Chrome 23.0.1271.64",
				
			"Windows, Firefox 12.0",
			"Windows, Firefox 12.0",
			"Windows, Firefox 12.0",
			"Windows, Firefox 12.0",
			"Windows, Internet Explorer 8.0",
			"Windows, Internet Explorer 9.0",
			"Windows, Internet Explorer 9.0",
			"Windows, Internet Explorer 9.0",
			"Windows, Chrome 23.0.1271.64",
			"Windows, Chrome 23.0.1271.64",
			"Windows, Chrome 23.0.1271.64",
			"Windows, Chrome 23.0.1271.64",
			"Windows, Chrome 23.0.1271.64",
			"Windows, Chrome 23.0.1271.64",

			"Linux, Chrome 22.0.1229.94",
			"Linux, Firefox 14.0.1",
			"Ipad, Safari 6.0",
			"Iphone, Safari 6.0",
			"Iphone, Safari 5.1",
			"Android, Safari 4.0",
			"Android, Chrome 18.0.1025.166"
		);
		
		$tabFile = getdbolist('VFile',"1");
		for ($i = 0; $i < $times; $i++)
		{
			$session = new Session();

			//Find viable date within the current semester.
			$min = strtotime($semester->starttime);
			$max = strtotime($semester->endtime);
			$temporary = rand($min, $max);
			$date = date("Y-m-d H:i:s",$temporary);

			//Generate random duration.
			$duration = rand(15,80000);

			//Put session informations and save.
			$session->userid = $user->id;
			$session->starttime = $date;
			$session->duration = $duration;
			$session->status = 2;
			$session->platform = $platform_table[rand(0, count($platform_table) -1)];
			$session->clientid = $client->id;
			$session->save();
			
			//Simulate a random number of file usage for the current user.
			for ($j = 0; $j < rand(0,5); $j++)
			{
				//Select a random file from files in the course
				$file = $tabFile[rand(0, count($tabFile) -1)];
				
				$link = getdbosql("Object", "linkid = $file->id");
				
				if(!$link)
				{
					$object = new Object();
					$object->name = $file->name;
					$object->type = 4;
					$object->linkid = $file->id;
					objectInit($object, $course->id);
				}
				
				//Find a viable start time within the current session.
				$minimum = strtotime($session->starttime);  //minimum is the most early moment when the user can start consulting the file.
				$upperbound = $duration - ($file->duration /1000); //upperbound is the max value that can be attributed to : file->starttime.
				//If a session has been created with a smaller 'duration' value than the file duration the user didn't stay long enough to 
				//view the selected file.
				if ($upperbound > 0)
				{
					$number = rand(30,$upperbound); //number is the number of seconds elapsed between
					// the session->starttime and the file->starttime which is capped by upperbound.
					$maximum = $minimum + $number;//adds number to session->starttime.			
				
					$filesession = new FileSession();
					$filesession->sessionid = $session->id;
					$filesession->fileid = $file->id;
					$filesession->userid = $user->id;
					$filesession->starttime = date("Y-m-d H:i:s",rand($minimum,$maximum));
					$filesession->duration = rand(15,($file->duration /1000));
					$filesession->status = CMDB_FILESESSIONSTATUS_COMPLETE;
					$filesession->save();
				}
			}
		}
	}

	public function actionSimulate()
	{
		$number = $_POST["numberField"];
		
		$languagecourses = safeCreateObject("Language Courses", CMDB_OBJECTROOT_ID);
		$semester = getdbo("Semester",$_POST["semester"]);
		$trickID = $languagecourses->id;
		$course = safeCreateCourse($_POST["courseField"], $trickID, $semester->id);
		
		$tabLvl = array(1=>10, 2=>20, 3=>40);
		$tabIP = array("45.63.10.19", "192.168.2.1", "10.32.15.3");

		for($i = 0; $i < $number; $i++)
		{
			$name = "{$_POST['nameField']}$i";
			$user = safeCreateUser($name, $name, "");
		//	safeEnrollUser($course, $user, "student");
			safeCourseEnrollment($user->id, SSPACE_ROLE_STUDENT, $course->id);

			//Create client for this user.
			$client = new Client();
			$client->remotename = "$name-PC";
			$client->remoteip = $tabIP[rand(0,2)];
			$client->save();
			
			//Simulates a random number of session for the current user.
			$this->simulateSession($tabLvl[$_POST['lvl']], $user,$client, $semester, $course);
		}

		$this->render('done');
	}
	
	
}




