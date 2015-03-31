<?php

// upload
// icons??

function objectHandleCategory($object)
{
	// not used
	return;
	
	if(!isset($_POST['Category'])) return;
	foreach($_POST['Category'] as $categoryid=>$itemid)
	{
		$allobjs = getdbolist('Object', "parentlist like '%, {$object->id}, %'");
		//Object::model()->findAll("parentlist like '%, {$object->id}, %'");
		foreach($allobjs as $o)
		{
			$categoryobject = getdbosql('CategoryObject', "objectid={$o->id} and categoryid={$categoryid}");
			//CategoryObject::model()->find(
			//	"objectid={$o->id} and categoryid={$categoryid}");

			if(!$categoryobject)
			{
				$categoryobject = new CategoryObject;
				
				$categoryobject->categoryid = $categoryid;
				$categoryobject->objectid = $o->id;
			}

			if($categoryobject->categoryitemid != $itemid)
			{
				$categoryobject->categoryitemid = $itemid;
				$categoryobject->save();
			}
		}
	}
}

function objectUpdateType($object, $oldtype)
{
	switch($object->type)
	{
		case CMDB_OBJECTTYPE_OBJECT:
			switch($oldtype)
			{
				case CMDB_OBJECTTYPE_FILE:
					app()->db->createCommand(
						"delete from File where objectid={$object->id}")->execute();
					break;
					
				case CMDB_OBJECTTYPE_COURSE:
					app()->db->createCommand(
						"delete from Course where objectid={$object->id}")->execute();
					break;
			}
			break;
			
		case CMDB_OBJECTTYPE_FILE:
			switch($oldtype)
			{
				case CMDB_OBJECTTYPE_OBJECT:
					$file = new File;
					$file->objectid = $object->id;
					$file->save();
					break;
					
				case CMDB_OBJECTTYPE_COURSE:
					app()->db->createCommand(
						"delete from Course where objectid={$object->id}")->execute();
					$file = new File;
					$file->objectid = $object->id;
					$file->save();
					break;
			}
			break;
			
		case CMDB_OBJECTTYPE_COURSE:
			switch($oldtype)
			{
				case CMDB_OBJECTTYPE_OBJECT:
					$course = new Course;
					$course->objectid = $object->id;
					$course->save();
					break;
					
				case CMDB_OBJECTTYPE_FILE:
					app()->db->createCommand(
						"delete from File where objectid={$object->id}")->execute();
					$course = new Course;
					$course->objectid = $object->id;
					$course->save();
					break;
			}
			break;
	}
}

function objectHandleDropdownCommand()
{
	switch($_POST['dropdown_command'])
	{
		case 'move':
			if(isset($_POST['new_parentid']) && $_POST['new_parentid'] != 0)
			{
				foreach($_POST['all_objects'] as $id=>$value)
				{
					$o = getdbo('Object', $id);
					$o->parentid = $_POST['new_parentid'];
					$o->parentlist = objectParentList($o);
					$o->save();
				}
			}
			break;
			
		case 'copy':
			if(isset($_POST['new_parentid']) && $_POST['new_parentid'] != 0)
			{
				foreach($_POST['all_objects'] as $id=>$value)
				{
					$o = getdbo('Object', $id);
					objectCopy($o, $_POST['new_parentid']);
				}
			}
			break;
			
		case 'delete':
			foreach($_POST['all_objects'] as $id=>$value)
			{
				$o = getdbo('Object', $id);
				objectDelete($o);
			}
			break;
	}
}

function objectHandleImage($object)
{
	$filename = objectImageFilename($object);
	$tempname = GetUploadedFilename();
	
	if($tempname)
	{
		@unlink($filename);
		@rename($tempname, $filename);
	}

	else if(isset($_POST['icon_url']) && !empty($_POST['icon_url']))
	{
		@unlink($filename);

		$data = file_get_contents($_POST['icon_url']);
		file_put_contents($filename, $data);
	}
	
	@unlink(SANSSPACE_CONTENT."/stamped-{$object->id}.png");
}

//////////////////////////////////////////////////////////////////////////////////////////////////

function fileCopy($object, $object2)
{
	$f = $object->file;
	$f2 = new File;
	$f2->attributes = $f->attributes;
	$f2->objectid = $object2->id;
	$f2->save();
		
	if($f->filetype == CMDB_FILETYPE_BOOKMARKS)
	{
		$bookmarks = getdbolist('Bookmark', "fileid=$object->id");
		foreach($bookmarks as $bookmark1)
		{
			$record1 = getdbo('VFile', $bookmark1->recordid);
			$recordid2 = 0;
				
			if($record1)
			{
				$file2 = objectCopy($record1->object, $object2->id);
				$recordid2 = $file2->id;
			}
		
			$bookmark2 = new Bookmark;
			$bookmark2->attributes = $bookmark1->attributes;
			$bookmark2->fileid = $object2->id;
			$bookmark2->recordid = $recordid2;
			$bookmark2->save();
		}
	}
	
	else if($f->filetype != CMDB_FILETYPE_URL)
	{
		$filename1 = objectPathname($object);
		$filename2 = objectPathname($object2);
		
		@copy($filename1, $filename2);
	}
}

function courseCopy($object, $object2)
{
	$c = $object->course;
	$c2 = new Course;
	$c2->attributes = $c->attributes;
	$c2->objectid = $object2->id;
	$c2->save();
}

function bankCopy($object, $object2)
{
	$questions = getdbolist('QuizQuestion', "bankid=$object->id");
	foreach($questions as $q)
	{
		$q2 = new QuizQuestion;
		$q2->attributes = $q->attributes;
		$q2->bankid = $object2->id;
		$q2->save();
		
		$list = getdbolist('QuizQuestionShortText', "questionid=$q->id");
		foreach($list as $a)
		{
			$a2 = new QuizQuestionShortText;
			$a2->attributes = $a->attributes;
			$a2->questionid = $q2->id;
			$a2->save();
		}
		
		$list = getdbolist('QuizQuestionSelect', "questionid=$q->id");
		foreach($list as $a)
		{
			$a2 = new QuizQuestionSelect;
			$a2->attributes = $a->attributes;
			$a2->questionid = $q2->id;
			$a2->save();
		}
		
		$list = getdbolist('QuizQuestionMatching', "questionid=$q->id");
		foreach($list as $a)
		{
			$a2 = new QuizQuestionMatching;
			$a2->attributes = $a->attributes;
			$a2->questionid = $q2->id;
			$a2->save();
		}
	}
}

function surveyCopy($object, $object2)
{
	$surveys = getdbolist('Survey', "objectid=$object->id");
	foreach($surveys as $survey)
	{
		$survey2 = new Survey;
		$survey2->objectid = $object2->id;
		$survey2->displayorder = $survey->displayorder;
		$survey2->question = $survey->question;
		$survey2->enumtype = $survey->enumtype;
		$survey2->allowupdate = $survey->allowupdate;
		$survey2->fileid = $survey->fileid;
		$survey2->startpos = $survey->startpos;
		$survey2->duration = $survey->duration;
		$survey2->save();
		
		$surveyoptions = getdbolist('SurveyOption', "surveyid=$survey->id");
		foreach($surveyoptions as $surveyoption)
		{
			$surveyoption2 = new SurveyOption;
			$surveyoption2->surveyid = $survey2->id;
			$surveyoption2->value = $surveyoption->value;
			$surveyoption2->fileid = $surveyoption->fileid;
			$surveyoption2->startpos = $surveyoption->startpos;
			$surveyoption2->duration = $surveyoption->duration;
			$surveyoption2->save();
		}
	}
}

function flashcardCopy($object, $object2)
{
	$flashcards = getdbolist('Flashcard', "objectid=$object->id");
	foreach($flashcards as $flashcard)
	{
		$flashcard2 = new Flashcard;
		$flashcard2->objectid = $object2->id;
		$flashcard2->displayorder = $flashcard->displayorder;
		$flashcard2->value1 = $flashcard->value1;
		$flashcard2->fileid1 = $flashcard->fileid1;
		$flashcard2->startpos1 = $flashcard->startpos1;
		$flashcard2->duration1 = $flashcard->duration1;
		$flashcard2->value2 = $flashcard->value2;
		$flashcard2->fileid2 = $flashcard->fileid2;
		$flashcard2->startpos2 = $flashcard->startpos2;
		$flashcard2->duration2 = $flashcard->duration2;
		$flashcard2->save();
	}
}

function objectCopy($object, $parentid)
{
//	debuglog("objectCopy($object->id, $parentid)");
	
	$object2 = new Object;
	$object2->type = $object->type;
	$object2->name = $object->name;
	$object2->authorid = userid();
	$object2 = objectInit($object2, $parentid);
	
	$object2->linkid = $object->linkid;
	$object2->size = $object->size;
	$object2->duration = $object->duration;
	$object2->hidden = $object->hidden;
	
	if(strstr($object->pathname, 'http://') || strstr($object->pathname, 'https://'))
		$object2->pathname = $object->pathname;
	else
		$object2->pathname = "$object2->id".getExtension($object->pathname);
	
	$object2->parentlist = objectParentList($object2);
	$object2->scanstatus = CMDB_OBJECTSCAN_NONE;
	$object2->save();

	$object2->ext->mp3tags = $object->ext->mp3tags;
	$object2->ext->doctext = $object->ext->doctext;
	$object2->ext->custom = $object->ext->custom;
	$object2->ext->save();
	
	$imagename = objectImageFilename($object);
	if(file_exists($imagename))
	{
		$imagename2 = objectImageFilename($object2);
		@copy($imagename, $imagename2);
	}
	
	switch($object->type)
	{
		case CMDB_OBJECTTYPE_COURSE:
			courseCopy($object, $object2);
			break;
			
		case CMDB_OBJECTTYPE_QUESTIONBANK:
			bankCopy($object, $object2);
			break;
			
 		case CMDB_OBJECTTYPE_FLASHCARD:
 			flashcardCopy($object, $object2);
 			break;

 		case CMDB_OBJECTTYPE_SURVEY:
			surveyCopy($object, $object2);
			break;
			
		case CMDB_OBJECTTYPE_FILE:
			fileCopy($object, $object2);
			break;
			
		case CMDB_OBJECTTYPE_QUIZ:
			$qz = getdbo('Quiz', $object->id);
			if(!$qz) break;
			
			$qz2 = new Quiz;
			$qz2->attributes = $qz->attributes;
			$qz2->quizid = $object2->id;
			$qz2->save();
		
			$list = getdbolist('QuizQuestionEnrollment', "quizid=$qz->quizid");
			foreach($list as $a)
			{
				$a2 = new QuizQuestionEnrollment;
				$a2->attributes = $a->attributes;
				$a2->quizid = $qz2->quizid;
				$a2->save();
			}

			break;
	}

	$object2->scanstatus = CMDB_OBJECTSCAN_PENDING;
	$object2->save();
	
	if($object->type != CMDB_OBJECTTYPE_FILE && $object->type != CMDB_OBJECTTYPE_LINK)
	{
		$children = getdbolist('Object', "parentid=$object->id and not recordings");
		foreach($children as $child)
			objectCopy($child, $object2->id); 
	}
	
	return $object2;
}



