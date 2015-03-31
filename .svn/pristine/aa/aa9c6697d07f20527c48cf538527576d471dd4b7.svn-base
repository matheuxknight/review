<?php

class Object extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'Object';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
//			array('pathname', 'file'),
			array('name','length','max'=>200),
			array('pathname','length','max'=>1024),
			array('size, duration', 'numerical'),
			array('type, parentid, displayorder, frontpage, model, recordings, enrolltype', 'numerical', 'integerOnly'=>true),
			array('authorid, views, folderimportid, deleted', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'author'=>array(self::BELONGS_TO, 'User', 'authorid'),
			'file'=>array(self::BELONGS_TO, 'VFile', 'id'),
			'course'=>array(self::BELONGS_TO, 'VCourse', 'id'),
			'contextcourse'=>array(self::BELONGS_TO, 'VCourse', 'courseid'),
			'link'=>array(self::BELONGS_TO, 'Object', 'linkid'),
			'ext'=>array(self::BELONGS_TO, 'ObjectExt', 'id'),

			'parent'=>array(self::BELONGS_TO, 'Object', 'parentid'),
			'enrolments'=>array(self::HAS_MANY, 'ObjectEnrollment', 'objectid'),

			'children'=>array(self::HAS_MANY, 'Object', 'parentid',
				'order'=>'??.displayorder, ??.name'),

			'comments'=>array(self::HAS_MANY, 'Comment', 'parentid',
				'order'=>'??.pinned desc, ??.created desc'),

			'folderimport'=>array(self::BELONGS_TO, 'FolderImport', 'folderimportid'),
			'defaultrole'=>array(self::BELONGS_TO, 'Role', 'defaultroleid'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'=>'Id',
			'name'=>'Name',
			'type'=>'Type',
			'parentid'=>'Folder',
			'linkid'=>'Link',
			'enrolltype'=>'Enrollments',
			'pathname'=>'Filename',
			'displayorder'=>'Display Order',
			'frontpage'=>'Home Page',
			'model'=>'Inherit Template',
			'recordings'=>'Recordings',
			'authorid'=>'Author',
			'doctext'=>'Description',
			'updated'=>'Updated',
			'created'=>'Created',
			'accessed'=>'Accessed',
			'folderimportid'=>'Folder Import',
			'defaultroleid'=>'Default Role'
		);
	}

	/////////////////////

	public function getEnrollTypeOptions()
	{
		return array(
			CMDB_OBJECTENROLLTYPE_AUTOSTUDENT=>'All Students',
			CMDB_OBJECTENROLLTYPE_NONE=>'Manual Enrollment',
			CMDB_OBJECTENROLLTYPE_SELF=>'Self Enrollment',
		);
	}

	public function getEnrollTypeText()
	{
		$options = $this->enrollTypeOptions;
		return isset($options[$this->enrolltype])? $options[$this->enrolltype]: "Unknown ({$this->enrolltype})";
	}

	/////////////////////

	public function getTypeOptions()
	{
		return array(
			CMDB_OBJECTTYPE_OBJECT=>'Object',
			CMDB_OBJECTTYPE_FILE=>'File',
			CMDB_OBJECTTYPE_COURSE=>'Course',
			CMDB_OBJECTTYPE_LINK=>'Link',
			CMDB_OBJECTTYPE_QUESTIONBANK=>'Question Bank',
			CMDB_OBJECTTYPE_FLASHCARD=>'Flashcards',
			CMDB_OBJECTTYPE_SURVEY=>'Survey',
			CMDB_OBJECTTYPE_LESSON=>'Lesson',
			CMDB_OBJECTTYPE_QUIZ=>'Quiz',
			CMDB_OBJECTTYPE_TEXTBOOK=>'Textbook',
		);
	}

	public function getTypeText()
	{
		$options = $this->typeOptions;
		return isset($options[$this->type])? $options[$this->type]: "Unknown ({$this->type})";
	}

	public function getTypeDetails()
	{
		if(controller()->rbac->globalAdmin())
		{
		if($this->type == CMDB_OBJECTTYPE_LINK)
			$object = $this->link;
		else
			$object = $this;
		
		$typedetails = '';
		
		if($object->type == CMDB_OBJECTTYPE_COURSE)
			$typedetails = 'Course ';
		
		else if($object->type == CMDB_OBJECTTYPE_QUESTIONBANK)
		{
			$count = getdbocount('QuizQuestion', "bankid=$object->id");
			$typedetails = "Question Bank ($count) ";
		}
		
		else if($object->type == CMDB_OBJECTTYPE_FLASHCARD)
		{
			$count = getdbocount('Flashcard', "objectid=$object->id");
			$typedetails = "Flashcards ($count) ";
		}
		
		else if($object->type == CMDB_OBJECTTYPE_SURVEY)
		{
			$count = getdbocount('Survey', "objectid=$object->id");
			$typedetails = "Survey ($count) ";
		}
		
		else if($object->type == CMDB_OBJECTTYPE_LESSON)
			$typedetails = "Lesson ";
		
		else if($object->type == CMDB_OBJECTTYPE_QUIZ)
		{
			$count = getdbocount('QuizQuestionEnrollment', "quizid=$object->id");
			$typedetails = "Quiz ($count)";
		}
				
		else if($object->type == CMDB_OBJECTTYPE_TEXTBOOK)
			$typedetails = "Textbook ";
				
		else if($object->file)
		{
			if($object->file->filetype == CMDB_FILETYPE_MEDIA)
			{
				if($object->file->hasaudio)
					$typedetails .= "Audio";
		
				if($object->file->hasaudio && $object->file->hasvideo)
					$typedetails .= "/";
		
				if($object->file->hasvideo)
					$typedetails .= "Video";
			}
			
			else if($object->file->filetype != CMDB_FILETYPE_UNKNOWN)
				$typedetails = $object->file->fileTypeText;
		}
	
		else if($object->post)
			$typedetails = "Forum";

		if($object->duration)
			$typedetails .= " <b>".objectDuration2a($object)."</b>";
		
		if($object->size)
			$typedetails .= " (".Itoa($object->size).")";

	//	debuglog("typedetails $typedetails");
		return $typedetails;
	}

	else
	{
	
		if($this->type == CMDB_OBJECTTYPE_LINK)
			$object = $this->link;
		else
			$object = $this;
	
		$typedetails = '';
	
		if($object->type == CMDB_OBJECTTYPE_COURSE)
			$typedetails = 'Course ';
	
		else if($object->type == CMDB_OBJECTTYPE_QUESTIONBANK)
		{
			$count = getdbocount('QuizQuestion', "bankid=$object->id");
			$typedetails = "Question Bank ";
		}
	
		else if($object->type == CMDB_OBJECTTYPE_FLASHCARD)
		{
			$count = getdbocount('Flashcard', "objectid=$object->id");
			$typedetails = "Flashcards ";
		}
	
		else if($object->type == CMDB_OBJECTTYPE_SURVEY)
		{
			$count = getdbocount('Survey', "objectid=$object->id");
			$typedetails = "Survey ";
		}
	
		else if($object->type == CMDB_OBJECTTYPE_LESSON)
			$typedetails = "Lesson ";
	
			
		else if($object->type == CMDB_OBJECTTYPE_QUIZ)
		{
			$count = getdbocount('QuizQuestionEnrollment', "quizid=$object->id");
			$typedetails = "Quiz ";
		}
	
		else if($object->type == CMDB_OBJECTTYPE_TEXTBOOK)
			$typedetails = "Textbook ";
	
		else if($object->file)
		{
			if($object->file->filetype == CMDB_FILETYPE_MEDIA)
			{
				if($object->file->hasaudio)
					$typedetails .= "Audio";
	
				if($object->file->hasaudio && $object->file->hasvideo)
					$typedetails .= "/";
	
				if($object->file->hasvideo)
					$typedetails .= "Video";
			}
				
			else if($object->file->filetype != CMDB_FILETYPE_UNKNOWN)
				$typedetails = $object->file->fileTypeText;
		}
	
		else if($object->post)
			$typedetails = "Forum";
	
		//	debuglog("typedetails $typedetails");
		return $typedetails;
	}
	}
	
	



}


