<?php

function showObjectBrowserButton($object, $allowfolder, $allowfile, $variableid, $updateid, $callback=null)
{
//	debuglog($object->id);
	if(!$object) $object = getdbo('Object', CMDB_OBJECTROOT_ID);
	
	if($callback) $callback = "$callback";
	else $callback = 'null';
	
	echo <<<END
<a id='browserbutton_$updateid'>Browse</a>
<script>$(function(){ $('#browserbutton_$updateid').button({
	icons:{primary: 'ui-icon-folder-open'}, text: false
	}).click(function(e){ onShowObjectBrowser(0, $allowfolder, $allowfile, 
		'$variableid', '$updateid', '{$object->id}', "{$object->name}", $callback);
	});});</script>
END;
}

///////////////////////////////////////////////////////////////////////////////

function showBrowserHeader($returnid)
{
	$userfolder = getUser()->folder;
	echo "<div id='objectbrowsertemplate_$returnid' class='objectbrowser'>";

	echo "<table><tr>";
	echo "<td width=48 valign=top style='text-align: center'>";

	echo "<a href='javascript:SelectCurrentObjectBrowser(\"mycourses\", \"My Courses\")'>";
	echo iconimg('course.png', '', array('width'=>32));
	echo "<br><b>My Courses</b></a><br><br>";

	echo "<a href='javascript:SelectCurrentObjectBrowser(\"myfolders\", \"My Saved Work\")'>";
	echo img(objectImageUrl($userfolder), '', array('width'=>32));
	echo "<br><b>My Saved Work</b></a><br><br>";

	echo "<a href='javascript:SelectCurrentObjectBrowser(\"mylocations\", \"Other Resources\")'>";
	echo img(objectImageUrl($userfolder), '', array('width'=>32));
	echo "<br><b>Other Resources</b></a><br><br>";

	echo "</td><td width=10></td><td valign='top'>";

	echo "<div class='border'>";
	echo "<div id='contentlist_$returnid' class='content'>";
	echo "<div id='currentlist_$returnid'>";
	echo "</div>";
	echo "</div>";
	echo "</div>";

	$saveas = getparam('saveas');
	if($saveas)
		echo "Filename: <input type=text id='saveasinput_$returnid' value='untitled.$saveas' style='width: 100%;'>";
	
	echo "</td>";
	echo "</tr>";

	echo "</table>";
	echo "</div>";
}

///////////////////////////////////////////////////////////////////////////////

function showBrowserObject($returnid, $id)
{
	$user = getUser();

	$allowfile = true;
	if(isset($_GET['allowfile']))
		$allowfile = $_GET['allowfile'] == 'true';

	////////////////////////////////////////////////////////////////////////

	function showobject($object)
	{
		$object = filterRecordingName($object);
	//	$objectname = urlencode($object->name);
		$objectname = addslashes($object->name);
		
		echo <<<END
<a href="javascript:SelectCurrentObjectBrowser($object->id, '$objectname')">
END;
		echo objectImage($object, 18);
		echo " $object->name</a><br>";
	}

	////////////////////////////////////////////////////////////////////////

	function showcurrentfolder($id)
	{
		echo 'Current Selection: ';
		if($id == 'mycourses')
		{
			echo "<a href='javascript:SelectCurrentObjectBrowser(\"mycourses\", \"My Courses\")'>My Courses</a> / ";
			return;
		}

		if($id == 'mylocations')
		{
			echo "<a href='javascript:SelectCurrentObjectBrowser(\"mylocations\", \"Other Resources\")'>Other Resources</a> / ";
			return;
		}
	
		if($id == 'myfolders')
		{
			echo "<a href='javascript:SelectCurrentObjectBrowser(\"myfolders\", \"My Saved Work\")'>My Saved Work</a> / ";
			return;
		}
	
		$object = getdbo('Object', $id);
		if(!$object) return;
	
		$parentList = array();
		$parentgroup = $object;
	
		while($parentgroup)
		{
			if(controller()->rbac->objectAction($parentgroup))
				array_unshift($parentList, $parentgroup);
	
			$parentgroup = $parentgroup->parent;
		}
	
		if(empty($parentList)) return;
	
		foreach($parentList as $model)
		{
			$modelname = urlencode($object->name);
			echo <<<END
<a href="javascript:SelectCurrentObjectBrowser($model->id, '$modelname')">$model->name</a> / 
END;
		}
	}

	///////////////////////////////////////////////////////////

	showcurrentfolder($id);
	echo '<hr>';

	$semester = getCurrentSemester();
	if($id == 'mycourses')
	{
		foreach($user->courseenrollments as $enrollment)
		{
			if($enrollment->object->type != CMDB_OBJECTTYPE_COURSE) continue;
			$course = $enrollment->object->course;
				
			if($semester && $course->semesterid && $course->semesterid != $semester->id)
				continue;
	
			showobject($course);
		}
	}

	else if($id == 'mylocations')
	{
		$objectids = $user->objectEnrollmentsExt2();
		foreach($objectids as $id=>$roleid)
		{
			$object = getdbo('Object', $id);
			if(!$object) continue;
			if($object->type == CMDB_OBJECTTYPE_COURSE) continue;

			showobject($object);
		}
	}

	else if($id == 'myfolders')
	{
		foreach($user->courseenrollments as $enrollment)
		{
			if($enrollment->object->type != CMDB_OBJECTTYPE_COURSE) continue;
			$course = $enrollment->object->course;
			
			if($semester && $course->semesterid && $course->semesterid != $semester->id)
				continue;

			$object = userRecordingFolder($course, $user);
			$object->name = $course->name;

			showobject($object);
		}

		$object = $user->folder;
		if($object)
		{
		//	$object->name = 'Practice Folder';
			showobject($object);
		}
	}

	else
	{
	//	$sql = buildSimpleObjectQuery($user, $id);
	//	$objects = getdbolist('Object', $sql);
		
		$object = getdbo('Object', $id);
		$objects = objectContentList($object);
		$objects = filterSemesters($objects);
		
		foreach($objects as $object)
		{
			if($allowfile || $object->type != CMDB_OBJECTTYPE_FILE)
				showobject($object);
		}

	}
	
}







