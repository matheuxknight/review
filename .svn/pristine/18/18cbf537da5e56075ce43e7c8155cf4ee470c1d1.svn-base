<?php

function objectCreateData($object, $parentid, $data, $data2)
{
	$object->attributes = $data;
	if(!$object->validate()) return null;

	$object = objectInit($object, $parentid);
	if(!$object) return null;

	$object->ext->attributes = $data2;
	$object->ext->save();

	$parent = getdbo('Object', $parentid);
	$object->post = $parent->post;
	
	if($object->type == CMDB_OBJECTTYPE_OBJECT && $parent->folderimportid)
	{
		$pathname = objectPathname($parent).'/'.$object->name;
		mkdir($pathname);
	
		$object->pathname = "$parent->pathname/$object->name";
		$object->folderimportid = $parent->folderimportid;
	}
		
	$object->save();
	return $object;
}

function objectUpdateData($object, $data, $data2)
{
	$object->attributes = $data;
	if(!$object->validate()) return null;

// 	$parent = getdbo('Object', $object->parentid);
// 	if(!controller()->rbac->objectAction($parent, 'update'))
// 		return null;
	
 	if(!controller()->rbac->objectAction($object, 'update'))
 		return null;

	$object->ext->attributes = $data2;
	$object->ext->save();

	$object->updated = now();
	$object->parentlist = objectParentList($object);

// 	if($object->type == CMDB_OBJECTTYPE_OBJECT && $object->folderimportid)
// 	{
// 		$oldname = objectPathname($object);
// 		$object->pathname = "{$object->parent->pathname}/$object->name";

// 		$newname = objectPathname($object);
		
// 		debuglog("move $oldname, $newname");
// 		@rename($oldname, $newname);
// 	}
			
	$object->save(true);
	return $object;
}

////////////////////////////////////////////////////////////////

function objectCreate($name, $parentid=0)
{
	$object = new Object;

	$object->name = $name;
	$object->type = CMDB_OBJECTTYPE_OBJECT;

	return objectInit($object, $parentid);
}

function objectInit($object, $parentid)
{
	if(empty($object->name))
		$object->name = "temp";
	
	$object->parentid = $parentid;
	$object->authorid = userid();
	$object->updated = now();
	$object->created = now();
	$object->accessed = now();

	$object->views = -1;
	$object->size = 0;
	$object->duration = 0;
	$object->displayorder = 99999;
	$object->frontpage = false;
	$object->model = false;
	$object->enrolltype = CMDB_OBJECTENROLLTYPE_NONE;
	$object->recordings = false;

	$object->deleted = false;
	$object->scanstatus = CMDB_OBJECTSCAN_READY;
	$object->folderimportid = 0;
	$object->tags = '';
	
	if(param('theme') == 'wayside')
		$object->courseid = getContextCourseId();
	
	$ok = $object->validate();
	if(!$ok) return null;

	$object->save(false);
	$object->parentlist = objectParentList($object);

	$object->save(false);

	$objectext = getdbo('ObjectExt', $object->id);
	if(!$objectext)
	{
		$objectext = new ObjectExt;
		$objectext->objectid = $object->id;
	}

	$object->ext = $objectext;

	$objectext->views = 0;
	$objectext->mp3tags = '';
	$objectext->doctext = '';
	$objectext->save();

	return $object;
}

function objectDelete($object)
{
	if(!$object) return;
//	debuglog("objectDelete($object->id, $object->name)");
	
	$children = getdbolist('Object', "parentid={$object->id}");
	foreach($children as $child)
		objectDelete($child);

	dborun("delete from ObjectEnrollment where objectid=$object->id");
	dborun("delete from CommandEnrollment where objectid=$object->id");
	dborun("delete from CourseEnrollment where objectid=$object->id");
	
	dborun("delete from Favorite where id=$object->id");
	dborun("delete from Comment where parentid=$object->id");
	dborun("delete from Object where linkid=$object->id");
	dborun("delete from FileSession where id=$object->id");
	dborun("delete from CategoryObject where objectid=$object->id");
	dborun("delete from ObjectExt where objectid=$object->id");
	dborun("delete from Bookmark where recordid=$object->id");
	dborun("delete from Bookmark where fileid=$object->id");
	dborun("update file set originalid=0 where originalid=$object->id");

	switch($object->type)
	{
		case CMDB_OBJECTTYPE_COURSE:
			courseDelete($object->course);
			break;

		case CMDB_OBJECTTYPE_FILE:
			fileDelete($object->file);
			break;

		case CMDB_OBJECTTYPE_QUESTIONBANK:
			$questions = getdbolist('QuizQuestion', "bankid=$object->id");
			foreach($questions as $question)
			{
				dborun("delete from QuizQuestionSelect where questionid=$question->id");
				dborun("delete from QuizQuestionMatching where questionid=$question->id");
				dborun("delete from QuizQuestionShortText where questionid=$question->id");
			}
			
			dborun("delete from QuizQuestion where bankid=$object->id");
			break;

		case CMDB_OBJECTTYPE_FLASHCARD:
			dborun("delete from Flashcard where objectid=$object->id");
			break;

		case CMDB_OBJECTTYPE_SURVEY:
			dborun("delete from SurveyAnswer where surveyid=$object->id");
			dborun("delete from SurveyOption where surveyid=$object->id");
			dborun("delete from Survey where objectid=$object->id");
			break;
			
		case CMDB_OBJECTTYPE_QUIZ:
			dborun("delete from Quiz where quizid=$object->id");
			dborun("delete from QuizQuestionEnrollment where quizid=$object->id");
	
			dborun("delete from QuizAttemptAnswer where attemptid in (select id from QuizAttempt where quizid=$object->id)");
			dborun("delete from QuizAttempt where quizid=$object->id");
			break;
			
		case CMDB_OBJECTTYPE_TEXTBOOK:
			dborun("delete from UserCode where objectid=$object->id");
			break;
	}

	// delete all object files
	array_map("localunlink", glob(SANSSPACE_CONTENT."/{$object->id}.*"));
	array_map("localunlink", glob(SANSSPACE_CONTENT."/{$object->id}-*"));
	array_map("localunlink", glob(SANSSPACE_CACHE."/{$object->id}.*"));

	@unlink(SANSSPACE_CONTENT."/object-{$object->id}.png");
	@unlink(SANSSPACE_CONTENT."/stamped-{$object->id}.png");

	$parent = $object->parent;
	$object->delete();

	objectUpdateParent($parent);
}

function localunlink($filename){ @unlink($filename);}

function objectMove($object, $parentid)
{
	$object->parentid = $parentid;
	$object->save();

	$object->parentlist = objectParentList($object);
	$object->save();

	objectUpdateParent($object->parent);
	return $object;
}

/*
 * propagate data (date, size, duration, ) up to parents
 */

function objectUpdateParent($object, $updated=null)
{
	if(!$object) return;
	if($object->type != CMDB_OBJECTTYPE_FILE || count($object->children))
	{
		$result = dborow("select sum(size), sum(duration) from Object ".
			"where parentid={$object->id} and not deleted and not recordings");

		$object->size = $result['sum(size)'];
		$object->duration = $result['sum(duration)'];
	}

	if($updated != null)
		$object->updated = $updated;

	$object->version = $object->version + 1;
	$object->save();

	objectUpdateParent($object->parent, $updated);
}

function objectChangeAllFields($object, $field, $value, $ifis = -1)
{
	$sql = "update object set $field=$value where parentlist like '%, $object->id, %'";

	if($ifis != -1)
		$sql .= " and $field=$ifis";

	dborun($sql);
}

function objectParentList($object)
{
	$parentlist = ", ";

	$parent = $object;
	while($parent)
	{
		$parentlist .= $parent->id .", ";
		if($parent->recordings) break;

		$parent = getdbo('Object', $parent->parentid);
	}

//	error_log("$object->name $parentlist");
	return $parentlist;
}

////////////////////////////////////////////////////////////////////////

function objectPathname($object)
{
	$result = '';

	if($object->folderimport &&
		strncmp($object->folderimport->pathname, 'http://', 7) != 0)
		$result = "{$object->folderimport->pathname}\\{$object->pathname}";

	else if($object->type == CMDB_OBJECTTYPE_FILE)
		$result = SANSSPACE_CONTENT . "\\{$object->pathname}";

	else
		$result = '';	//SANSSPACE_CONTENT;

//	return iconv("UTF-8", "Windows-1252", $result);
//	return utf8_decode($result);
	return $result;
}

function objectPathnameIndex($object)
{
	if($object->type != CMDB_OBJECTTYPE_FILE) return '';
	$result = '';

	if($object->folderimport)
		$result = SANSSPACE_CACHE . "\\{$object->id}.flv" . FLV_INDEX_EXTENSION2;

	else
		$result = SANSSPACE_CACHE . "\\{$object->pathname}" . FLV_INDEX_EXTENSION2;

	return utf8_decode($result);
}

function objectPathnameThumbnail($object)
{
	$result = SANSSPACE_CACHE . "\\thumbnails-$object->id";
	return $result;
}

function objectPathnameSoundSamples($object)
{
	$result = SANSSPACE_CACHE . "\\$object->id.samples";
	return $result;
}

/////////////////////////////////////////////////////////////////////

function objectUrl($object)
{
	$a = null;
	switch($object->type)
	{
		case CMDB_OBJECTTYPE_COURSE:
			$a = array('course/', 'id'=>$object->id);

		case CMDB_OBJECTTYPE_FILE:
			$a = array('file/', 'id'=>$object->id);

		default:
			$a = array('object/', 'id'=>$object->id);
	}
	
//	$courseid = getContextCourseId();
//	if($courseid) $a['courseid'] = $courseid;
	
	return $a;
}

function objectUrlUpdate($object)
{
	switch($object->type)
	{
		case CMDB_OBJECTTYPE_COURSE:
			return array('course/update', 'id'=>$object->id);

		case CMDB_OBJECTTYPE_FILE:
			return array('file/update', 'id'=>$object->id);

		default:
			return array('object/update', 'id'=>$object->id);
	}
}

///////////////////////////////////////////////////////////////

function objectDuration2i($object)
{
	return round($object->duration/1000);
}

function objectDuration2a($object)
{
	return sectoa(objectDuration2i($object));
}

///////////////////////////////////////////////////////////////

//function objectReadyState($object)
//{
//	if(!controller()->rbac->defaultAdmin())
//		return;
//
//	$show = false;
//
//	$filename = objectPathname($object);
//	$cachename = fileTranscodedFilename($object->id);
//
//	if($object->type == CMDB_OBJECTTYPE_FILE && $object->file)
//	{
//		$file = $object->file;
//		if(	$file->filetype == CMDB_FILETYPE_MEDIA &&
//			$object->transcoded != CMDB_OBJECTTRANSCODE_NATIVE)
//		{
//			if($object->transcoded == CMDB_OBJECTTRANSCODE_COMPLETE &&
//				file_exists($cachename))
//				$show = true;
//		}
//
//		else if(file_exists($filename))
//			$show = true;
//	}
//
//	else if($object->transcoded == CMDB_OBJECTTRANSCODE_COMPLETE)
//		$show = true;
//
//	if($show)
//		echo '<td nowrap>'.mainimg('green-check.png').'&nbsp;&nbsp;&nbsp;&nbsp;</td>';
//
//	else
//		echo '<td></td>';
//}


