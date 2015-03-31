<?php

function showUserHeader($user, $title, $url=null)
{
	echo "<table width='100%'><tr><td width='60%'>";
	
	echo "<div class='ssheader' id='object_{$object->id}_parent'>";
	echo userImage($user);
		
	if($url)
		echo "<h2><a href='$url'>$title</a></h2></div>";	
	else
		echo "<h2>$title</h2></div>";
		
	echo "</td></tr></table>";
}

///////////////////////////////////////////////////////////////////////////

function showRoleBar($object)
{
	echo "<span class='role'>";
	
	if(controller()->rbac->globalAdmin())
	{
		$course = getContextCourse();
		if($course && $course->id != controller()->object->id)
		{
			echo objectImage($course, 18);
			echo "<b> Go to Textbook </b>";
			
			echo l(mainimg('16x16_link.png'), 'javascript:clear_context_course()', array('title'=>'Go to Textbook'));
			echo <<<END
<script>
function clear_context_course()
{
	window.location.href = '/object/clearcontextcourse?id=$object->id';
}
</script>
END;
		}
	}
	
	if(param('showrole'))
	{
		echo "role: ";
		$roles = controller()->rbac->objectRoles($object);
		foreach($roles as $roleid)
		{
			$role = getdbo('Role', $roleid);
			if(!$role) continue;
			echo "<b>$role->name, </b> ";
		}
	}
	
	echo "</span>";
}

//////////////////////////////////////////////////////////////////////

function showNavigationBar($object, $action = "")
{
//	debuglog("showNavigationBar $object->name");
	
	function findobject($list, $id)
	{
		foreach($list as $model) if($model->id == $id) return true; return false;
	}

	function findcoursemodel($user, $object, $parentlist)
	{
//		debuglog("  findcoursemodel({$object->parent->name}/$object->name)");
		$courseid = getContextCourseId();
		foreach($user->courseenrollments as $enrollment)
		{
			if($enrollment->object->type != CMDB_OBJECTTYPE_COURSE) continue;
			if($courseid && $enrollment->object->id != $courseid) continue;
			
			$course = $enrollment->object->course;
			if(findobject($parentlist, $course->id)) return null;
		
			if(strstr($course->parentlist, ", $object->id, "))
			{
//				debuglog("  switch1 {$course->parent->name}/$course->name");
				return $course;
			}
		}
		
		return null;
	}

	function findcourselink($user, $link, $parentlist)
	{
//		debuglog("  findcourselink({$link->parent->name}/$link->name)");
		if(findobject($parentlist, $link->id)) return null;
		
		foreach($user->courseenrollments as $enrollment)
		{
			if($enrollment->object->type != CMDB_OBJECTTYPE_COURSE) continue;
			$course = $enrollment->object->course;

			if(strstr($link->parentlist, ", $course->id, "))
			{
//				debuglog("  switch2 {$link->parent->name}/$link->name");
				return $link;
			}
			
			$model = $link->parent;
			while($model && $model->model)
			{
				if(strstr($link->parentlist, ", $model->id, "))
				{
//					debuglog("  switch3 {$link->parent->name}/$link->name");
					return $link;
				}
			}
		}
		
		return null;
	}

	$parentlist = array();
	$parent = $object;
	$user = getUser();

	$course = getContextCourse();
	while($parent !== null)
	{
		if(!controller()->rbac->objectAction($parent))
		{
			if($parent->recordings)
			{
				$parent = $parent->parent;
				continue;
			}
			
			if($parent->model)	// && $object->type != CMDB_OBJECTTYPE_TEXTBOOK)
				$parent = findcoursemodel($user, $parent, $parentlist);
		}
		
		else if(!controller()->rbac->objectAction($parent->parent))
		{
			$links = getdbolist('Object', "linkid=$parent->id and type=".CMDB_OBJECTTYPE_LINK);
			foreach($links as $link)
				$parent = findcourselink($user, $link, $parentlist);
		}

		if(!$parent) break;
		if(!controller()->rbac->objectAction($parent)) break;
		
		if($course && $parent->model && isCourseHasObject($course, $parent))
		{
			array_unshift($parentlist, $course);
			$course = null;
			
			if(!controller()->rbac->globalAdmin())
				break;
		}
		
		if(	$course && 
			$course->parentid == $parent->id && 
			$course->id != controller()->object->id)
		{
			array_unshift($parentlist, $course);
		//	break;
		}
				
		array_unshift($parentlist, $parent);
		$parent = $parent->parent;
	}
	
	//////////////////////////////////////////////////////////////////////

	if(empty($parentlist)) return;
	
	$o = getdbo('Object', getparam('id'));
	if($o && count($parentlist) == 1 && $parentlist[0]->id == $o->id) return;
	
	echo "<div id='mynavigationmenu' class='navigationmenu'><ul>";
	foreach($parentlist as $n=>$model)
	{
		if($n && $parentlist[$n-1]->id == $model->id) continue;
		
		$model = filterRecordingName($model);
		echo "<li id=$model->id>";
		
		echo l(($n > 0? '<b>/</b> ': '').objectImage($model, 18).
			'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$model->name, 
			array("object/$action", 'id'=>$model->id));
			
		echo '<ul><li>'. l(mainimg('loading_white.gif', '', 
			array('width'=>16)).
	 		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loading...') .'</li></ul>';
			
		echo '</li>';
	}
	
	echo "</ul>";
	echo "<br style='clear: left' /></div>";
}

//////////////////////////////////////////////////////////////////////

function showObjectHeader($object)
{
	$object = filterRecordingName($object);
	
// 	echo "<div class='sstitle' id='object_{$object->id}_parent'>";
// 	echo l(objectImage($object), objectUrl($object));
// 	showObjectMenuContext($object);
// 	echo "</div>";
	
	echo "<table width='100%'><tr><td width='60%'>";
	echo "<table width='100%' class='sstitle'><tr>";
	
	echo "<td width=56>";
	echo l(objectImage($object), objectUrl($object));
	echo "</td>";
	
	echo "<td id='object_{$object->id}_parent'>";
	showObjectMenuContext($object);
	
	echo "<div class='small'>";
	
	if(!empty($object->tags))
		echo "Tags: <b>$object->tags</b><br>";
	
	echo $object->typeDetails;
	echo "</div>";
	
	echo "</td>";
	echo "</tr></table></td>";
	
	if($object->post)
	{
		echo "<td width=52>".userImage($object->author, 32)."</td>";
		echo "<td nowrap><span style='font-size:0.85em'>";
		
		echo "<b>{$object->author->name}</b><br>";
		echo "Created ".datetoa($object->created). "<br>";
		
		if($object->created != $object->updated)
			echo "Updated ".datetoa($object->updated);
		
		echo "</span></td>";
		
		$commentcount = getdbocount('Comment', "parentid=$object->id");
		$childcount = getdbocount('Object', "parentid=$object->id");
	
		echo "<td nowrap><span style='font-size:0.85em'>".
			"&nbsp; &#9679; {$object->ext->views} Views<br>".
		//	"&nbsp; &#9679; $childcount Children<br>".
			"&nbsp; &#9679; $commentcount Comments";
	
		echo "</span></td>";
	}
	
	echo "</tr></table>";
}

function showFileInfo($file, $template=null)
{
	echo "<div class='fileinfo'>";
	echo "<div class='fileinfotitle'>$file->name</div>";
	echo "<div class='inner'>";
	echo "<table>";

	if($file->filetype == CMDB_FILETYPE_MEDIA)
		echo "<tr><td>Duration: </td><td>".objectDuration2a($file)."</td></tr>";
		
	echo "<tr><td>Updated: </td><td>".datetoa($file->updated)."</td></tr>";

	if($file->authorid)
		echo "<tr><td>Author: </td><td>{$file->author->name}</td></tr>";
	
	echo "<tr><td>Views: </td><td>{$file->ext->views}</td></tr>";
	
	// size
	if($template)
	{
		$to = getdbosql('TranscodeObject', "fileid=$file->id and templateid=$template->id");
		echo "<tr><td>Size: </td><td>".Itoa($to->size)."</td></tr>";
	}
	
	else if($file->size)
		echo "<tr><td>Size: </td><td>".Itoa($file->size)."</td></tr>";
	
	// bitrate
	if($file->filetype == CMDB_FILETYPE_MEDIA)
	{
		echo "<tr><td>Bitrate: </td><td>";
		echo Itoa2($file->bitrate);
		echo "</td></tr>";
	}
	
	if(isset($file->original) && $file->original)
	{
		echo "<tr><td>Master File: </td><td>";
		echo l(h($file->original->name), array('file/show', 'id'=>$file->originalid)).'<br>';
		echo "</td></tr>";
	}
	
	echo "</table>";
	echo "</div>";
	echo "</div>";
	echo "<br>";
}

function showFileInfoSameFolder($file, $defaulturl=null)
{
	$objects = objectList($file->parentid);
	if(!$objects) return false; 
	
	echo "<div class='fileinfo'>";
	echo "<div class='fileinfotitle'>In {$file->parent->name}</div>";
	echo "<div class='inner'>";
	echo "<table width='100%' border=0 cellpadding=2 cellspacing=0>";
	
	foreach($objects as $object)
	{
		echo "<tr";
		if($file->id == $object->id)
			echo " style='background:#A1B4D9'";
			
		echo '><td valign=top width=20>'.l(objectImage($object, 18), objectUrl($object));
		echo '</td><td>';
		showObjectMenuContext($object, $defaulturl? "$defaulturl?id=$object->id": null);
		echo '</td></tr>';
	}
	
	echo "</table>";
	echo "</div>";
	echo "</div>";
	echo "<br>";
	
	return true;
}

function showFileInfoMyRecordings($file)
{
	$user = getUser();

	$recordings = getdbolist('VFile', "originalid=$file->id and authorid=$user->id");
	if(!$recordings) return false;
	
	echo "<div class='fileinfo'>";
	echo "<div class='fileinfotitle'>My files attached to $file->name</div>";
	echo "<div class='inner'>";
	echo "<table width='100%' border=0 cellpadding=2 cellspacing=0>";

	foreach($recordings as $rec)
	{
		echo "<tr";
		if($rec->filetype == CMDB_FILETYPE_MEDIA && 
			isset($_GET['recordid']) && $_GET['recordid'] == $rec->id)
			echo " style='background:#A1B4D9'";
		
		else if($rec->filetype == CMDB_FILETYPE_SRT &&
			isset($_GET['subtitlesid']) && $_GET['subtitlesid'] == $rec->id)
			echo " style='background:#A1B4D9'";
		
		else if($rec->filetype == CMDB_FILETYPE_BOOKMARKS &&
			isset($_GET['bookmarksid']) && $_GET['bookmarksid'] == $rec->id)
			echo " style='background:#A1B4D9'";
		
		echo '><td valign=top width=20>'.objectImage($rec, 18);
		echo '</td><td>';

		if($rec->filetype == CMDB_FILETYPE_MEDIA)
			showObjectMenuContext($rec, 
				array('file/show', 'id'=>$file->id, 'recordid'=>$rec->id));
		
		else if($rec->filetype == CMDB_FILETYPE_SRT)
			showObjectMenuContext($rec, 
				array('file/show', 'id'=>$file->id, 'subtitlesid'=>$rec->id));
		
		else if($rec->filetype == CMDB_FILETYPE_BOOKMARKS)
			showObjectMenuContext($rec, 
				array('file/show', 'id'=>$file->id, 'bookmarksid'=>$rec->id));
		
		echo "</td>";
		echo "</tr>";
	}
	
	echo "</table>";
	echo "</div>";
	echo "</div>";
	echo "<br>";

	return true;
}

function showFileInfoStudentRecordings($file)
{
	$count = 0;
	$user = getUser();
	
	foreach($user->courseenrollments as $enrollment)
	{
		if($enrollment->roleid != SSPACE_ROLE_TEACHER) continue;
		if($enrollment->object->type != CMDB_OBJECTTYPE_COURSE) continue;
		$course = $enrollment->object->course;
		
		$object = getdbosql('Object', "parentid=$course->id and not deleted and recordings and type=".
			CMDB_OBJECTTYPE_OBJECT);
		if(!$object) continue;

		$recordings = getdbolist('VFile', "parentlist like '%, {$object->id}, %' and not deleted and originalid={$file->id} order by authorid");
		//VFile::model()->findAll(
		//	"parentlist like '%, {$object->id}, %' and not deleted and originalid={$file->id} order by authorid");
		if($recordings)
		{
			$count++;
			
			echo "<div class='fileinfo'>";
			echo "<div class='fileinfotitle'>";
			
			echo "In ".l(h("{$enrollment->object->name} Recordings"), objectUrl($object));

			echo " attached to $file->name</div>";
			echo "<div class='inner'>";
			echo "<table width='100%' border=0 cellpadding=2 cellspacing=0>";
							
			foreach($recordings as $rec)
			{
				echo "<tr";
				if($rec->filetype == CMDB_FILETYPE_MEDIA && 
					isset($_GET['recordid']) && $_GET['recordid'] == $rec->id)
					echo " style='background:#A1B4D9'";
				
				else if($rec->filetype == CMDB_FILETYPE_SRT &&
					isset($_GET['subtitlesid']) && $_GET['subtitlesid'] == $rec->id)
					echo " style='background:#A1B4D9'";

				else if($rec->filetype == CMDB_FILETYPE_BOOKMARKS &&
					isset($_GET['bookmarksid']) && $_GET['bookmarksid'] == $rec->id)
					echo " style='background:#A1B4D9'";
		
				echo '><td valign=top width=20>'.objectImage($rec, 18).'</td>';
				echo '<td>';
		
				if($rec->filetype == CMDB_FILETYPE_MEDIA)
					showObjectMenuContext($rec, 
						array('file/show', 'id'=>$file->id, 'recordid'=>$rec->id),
							"<b>{$rec->author->name}</b><br>$rec->name");

				else if($rec->filetype == CMDB_FILETYPE_SRT)
					showObjectMenuContext($rec, 
						array('file/show', 'id'=>$file->id, 'subtitlesid'=>$rec->id),
							"<b>{$rec->author->name}</b><br>$rec->name");
									
				else if($rec->filetype == CMDB_FILETYPE_BOOKMARKS)
					showObjectMenuContext($rec, 
						array('file/show', 'id'=>$file->id, 'bookmarksid'=>$rec->id),
							"<b>{$rec->author->name}</b><br>$rec->name");
									
				echo "</td>";
				echo "</tr>";
			}
		
			echo "</table>";
			echo "</div>";
			echo "</div>";
			echo "<br>";
		}
	}

	return $count;
}

function showFileInfoSameFolderAttached($file)
{
	$objects = getdbolist('VFile', "parentid=$file->parentid and originalid=$file->id");
	if(!$objects) return false; 
	
	echo "<div class='fileinfo'>";
	echo "<div class='fileinfotitle'>In {$file->parent->name} attached to $file->name</div>";
	echo "<div class='inner'>";
	echo "<table width='100%' border=0 cellpadding=2 cellspacing=0>";
	
	foreach($objects as $rec)
	{
		echo "<tr";
		if($rec->filetype == CMDB_FILETYPE_MEDIA && 
			isset($_GET['recordid']) && $_GET['recordid'] == $rec->id)
			echo " style='background:#A1B4D9'";
		
		else if($rec->filetype == CMDB_FILETYPE_SRT &&
			isset($_GET['subtitlesid']) && $_GET['subtitlesid'] == $rec->id)
			echo " style='background:#A1B4D9'";

		else if($rec->filetype == CMDB_FILETYPE_BOOKMARKS &&
			isset($_GET['bookmarksid']) && $_GET['bookmarksid'] == $rec->id)
			echo " style='background:#A1B4D9'";
		
		echo '><td valign=top width=20>'.l(objectImage($rec, 18),
			objectUrl($rec)).'</td>';
		echo '<td>';
		
		if($rec->filetype == CMDB_FILETYPE_MEDIA)
			showObjectMenuContext($rec, 
				array('file/show', 'id'=>$file->id, 'recordid'=>$rec->id));
		
		else if($rec->filetype == CMDB_FILETYPE_SRT)
			showObjectMenuContext($rec, 
				array('file/show', 'id'=>$file->id, 'subtitlesid'=>$rec->id));
		
		else if($rec->filetype == CMDB_FILETYPE_BOOKMARKS)
			showObjectMenuContext($rec, 
				array('file/show', 'id'=>$file->id, 'bookmarksid'=>$rec->id));
		
		echo '</td></tr>';
	}
	
	echo "</table>";
	echo "</div>";
	echo "</div>";
	echo "<br>";
	
	return true;
}

///////////////////////////////////////////////////////////////////////////

function showAllDropBoxRecordings()
{
	echo "<br>";
	$user = getUser();
	
	$courses = getdbolist('Object', "type=".CMDB_OBJECTTYPE_COURSE.
		" and id in (select objectid from CourseEnrollment where userid=$user->id)");
	foreach($courses as $course)
	{
		$folder = userRecordingFolder($course);
		showDropboxFolder($folder->name, $folder);
	}
	
	$folder = getdbo('Object', $user->folderid);
	showDropboxFolder("Practice Folder", $folder);
}

function showDropboxFolder($name, $folder)
{
	$objects = objectList($folder->id);
	if(!$objects) return false;
	
	echo "<div class='fileinfo'>";
	echo "<div class='fileinfotitle'>";
	echo l($name, array('object/', 'id'=>$folder->id));
	echo "</div>";
	echo "<div class='inner'>";
	echo "<table width='100%' border=0 cellpadding=2 cellspacing=0>";

	foreach($objects as $object)
	{
		echo "<tr";
		if(isset($_GET['id']) && $_GET['id'] == $object->id)
			echo " style='background:#A1B4D9'";
		
		echo '><td valign=top width=20>'.objectImage($object, 18).'</td>';
		echo '<td>';

		if($object->type == CMDB_OBJECTTYPE_FILE)	
			showObjectMenuContext($object, 
				array('file/edit', 'id'=>$object->id), "$object->name");
		else
			showObjectMenuContext($object,
				array('object/update', 'id'=>$object->id), "$object->name");
				
		echo "</td>";
		echo "</tr>";
	}

	echo "</table>";
	echo "</div>";
	echo "</div>";
	echo "<br>";
	
}





