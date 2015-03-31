<?php

class VFile extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'VFile';
	}

	public function primaryKey()
	{
		return 'id';
	}

	public function rules()
	{
		return array(
//		array('name', 'required'),
		array('name','length','max'=>200),
		array('pathname','length','max'=>1024),
		array('id, type, parentid, displayorder, frontpage, model, enrolltype, objectid, authorid, filetype, width, height, originalid', 'numerical', 'integerOnly'=>true),
		array('size, duration', 'numerical'),
		);
	}

	public function relations()
	{
		$relations = Object::model()->relations();

		$relations['parent'] = array(self::BELONGS_TO, 'Object', 'parentid');
		$relations['object'] = array(self::BELONGS_TO, 'Object', 'id');
		$relations['file'] = array(self::BELONGS_TO, 'File', 'id');
		$relations['author'] = array(self::BELONGS_TO, 'User', 'authorid');
		$relations['original'] = array(self::BELONGS_TO, 'VFile', 'originalid');
		$relations['folderimport'] = array(self::BELONGS_TO, 'FolderImport', 'folderimportid');
		
		return $relations;
	}

	public function attributeLabels()
	{
		return array(
			'parentid'=>'Folder',
			'displayorder'=>'Display Order',
			'frontpage'=>'Frontpage',
			'pathname'=>'Filename',
			'objectid'=>'Object',
			'authorid'=>'Author',
			'filetype'=>'File Type',
			'size'=>'Size',
			'duration'=>'Duration',
			'originalid'=>'Master File',
			'temp_pathname'=>'Upload',
			'temp_url'=>'URL',
			'screencapture'=>'Screen Capture',
			'youtube_url'=>'Youtube',
			'doctext'=>'Description',
			'audiocodec'=>'Audio Codec',
			'videocodec'=>'Video Codec',
			'width'=>'Dimension',
		);
	}

	/////////////////////

	public function getFileTypeOptions()
	{
		return array(
			CMDB_FILETYPE_UNKNOWN		=>'None',
			CMDB_FILETYPE_MEDIA			=>'Media',
			CMDB_FILETYPE_LINK			=>'Link',
			CMDB_FILETYPE_APPLICATION	=>'Application',
			CMDB_FILETYPE_DOCUMENT		=>'Document',
			CMDB_FILETYPE_SWF			=>'Flash',
			CMDB_FILETYPE_IMAGE			=>'Image',
			CMDB_FILETYPE_TEXT			=>'Text',
			CMDB_FILETYPE_DVD			=>'DVD',
			CMDB_FILETYPE_URL			=>'URL',
			CMDB_FILETYPE_PDF			=>'PDF',
			CMDB_FILETYPE_SRT			=>'Subtitles',
			CMDB_FILETYPE_BOOKMARKS		=>'Bookmarks',
			CMDB_FILETYPE_LIVE			=>'Live',
//			CMDB_FILETYPE_INSTALL		=>'Install',
		);
	}

	public function getFileTypeText()
	{
		$options = $this->fileTypeOptions;
		return isset($options[$this->filetype])? $options[$this->filetype]: "None";
	}

	/////////////////////

	public function getRecordModeOptions()
	{
		return array(
			CMDB_RECORDMODE_OFF=>'Off',
			CMDB_RECORDMODE_SYNC=>'Synchronized',
			CMDB_RECORDMODE_QA=>'Question & Answer',
			CMDB_RECORDMODE_VOICEOVER=>'Voice Over',
		);
	}

	public function getRecordModeText()
	{
		$options = $this->recordModeOptions;
		return isset($options[$this->recordmode])? $options[$this->recordmode]: "Unknown ({$this->recordmode})";
	}
	
	public function getBitrate()
	{
		return Itoa($this->bitrate);
	}

	///////////////////////////////////////////////////////////////////////

//	public function insert()
//	{
//		die("VFile::insert"); return true;
//	}

	public function update()
	{
		$object = getdbo('Object', $this->id);
		$object->attributes = $this->attributes;
		
		$file = getdbo('File', $this->id);
		$file->attributes = $this->attributes;
		
		if(!$object->save()) return false;
		if(!$file->save()) return false;
		
		return true;
	}

	public function delete()
	{
		$object = getdbo('Object', $this->id);
		$file = getdbo('File', $this->id);
		
		$object->delete();
		$file->delete();
		
		return true;
	}
	
	public function validate()
	{
		$object = new Object;
		$object->attributes = $this->attributes;
		
		$file = new File;
		$file->attributes = $this->attributes;
		$file->objectid = $object->id;
				
		if(!$object->validate()) return false;
		if(!$file->validate()) return false;
		
		return true;
	}

	public function getTypeDetails()
	{
		return $this->object->typeDetails;
	}
	
}



