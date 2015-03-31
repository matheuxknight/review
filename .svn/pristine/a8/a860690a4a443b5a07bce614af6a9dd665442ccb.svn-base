<?php

class VCourse extends CActiveRecord
{
	public static $startdate_required = false;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'VCourse';
	}

	public function primaryKey()
	{
		return 'id';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name','length','max'=>200),
			//array('exempt'),
				
			VCourse::$startdate_required? array('startdate', 'required'): null,
				
			array('pathname','length','max'=>1024),
			array('size, duration', 'numerical'),
			array('id, type, usedate, parentid, displayorder, frontpage, model, enrolltype, objectid, authorid, param, dependid', 'numerical', 'integerOnly'=>true),
			array('startdate, enddate', 'type', 'type'=>'datetime', 'datetimeFormat'=>'yyyy-MM-dd', 'allowEmpty'=>true),
		);
	}

	public function relations()
	{
		$relations = Object::model()->relations();

//		$relations['parent'] = array(self::BELONGS_TO, 'Object', 'parentid');
		$relations['object'] = array(self::BELONGS_TO, 'Object', 'id');
		$relations['course'] = array(self::BELONGS_TO, 'VCourse', 'id');
		$relations['rcourse'] = array(self::BELONGS_TO, 'Course', 'id');
		$relations['enrollment'] = array(self::HAS_MANY, 'CourseEnrollment', 'objectid');
		$relations['recording'] = array(self::BELONGS_TO, 'Object', 'recordingid');
		$relations['author'] = array(self::BELONGS_TO, 'User', 'authorid');
		$relations['depend'] = array(self::BELONGS_TO, 'VCourse', 'dependid');
		$relations['semester']=array(self::BELONGS_TO, 'Semester', 'semesterid');
		$relations['quiz']=array(self::BELONGS_TO, 'Quiz', 'id');

		return $relations;
	}

	public function attributeLabels()
	{
		return array(
			'name'=>'Course Name',
			'displayorder'=>'Display Order',
			'accesstype'=>'Student Access',
			'frontpage'=>'Front Page',
			'model'=>'Inherit Parent\'s Links',
			'activitytype'=>'Activity Type',
			'param'=>'Parameter',
			'dependid'=>'Prerequisite',
			'recordingid'=>'Recording Folder',
			'enrolltype'=>'Enrollments',
			'usedate'=>'Use Calendar',
			'startdate'=>'Start Date',
			'enddate'=>'End Date',
			'semesterid'=>'Semester',
			'doctext'=>'Description',
		);
	}

	/////////////////////
	
	public function getExempt()
	{
	if ($this->ext->custom == 1)
			$exempt = "Exempt";
		else
			$exempt = "Not Exempt";
		return $exempt;
	}

	public function getTypeOptions()
	{
		return array(
			CMDB_OBJECTTYPE_OBJECT=>'Page',
			CMDB_OBJECTTYPE_FILE=>'File',
			CMDB_OBJECTTYPE_COURSE=>'Course',
		);
	}

	public function getTypeText()
	{
		$options = $this->typeOptions;
		return isset($options[$this->type])? $options[$this->type]: "Unknown ({$this->type})";
	}

	/////////////////////

	public function getEnrollTypeOptions()
	{
		return array(
			CMDB_OBJECTENROLLTYPE_NONE=>'None',
			CMDB_OBJECTENROLLTYPE_AUTO=>'Auto',
			CMDB_OBJECTENROLLTYPE_SELF=>'Self',
		//	CMDB_OBJECTENROLLTYPE_APPROVAL=>'Approval',
		);
	}

	public function getEnrollTypeText()
	{
		$options = $this->enrollTypeOptions;
		return isset($options[$this->enrolltype])? $options[$this->enrolltype]: "Unknown ({$this->enrolltype})";
	}

	////////////////////////
	
	public function getActivityTypeOptions()
	{
		return array(
			CMDB_ACTIVITYTYPE_NONE=>'None',
			CMDB_ACTIVITYTYPE_PLAY=>'Play',
			CMDB_ACTIVITYTYPE_RECORD=>'Record',
//			CMDB_ACTIVITYTYPE_READ=>'Read',
//			CMDB_ACTIVITYTYPE_WRITE=>'Write',
//			CMDB_ACTIVITYTYPE_APPROVAL=>'Approval',
			CMDB_ACTIVITYTYPE_QUIZ=>'Quiz',
		);
	}

	public function getActivityTypeText()
	{
		$options = $this->activityTypeOptions;
		return ($this->activitytype && isset($options[$this->activitytype]))? $options[$this->activitytype]: "None";
	}

	////////////////////////
	
	public function getAccessTypeOptions()
	{
		return array(
			CMDB_COURSEACCESS_NONE=>'Save Only',
			CMDB_COURSEACCESS_READ=>'Save/Read Only',
			CMDB_COURSEACCESS_WRITE=>'Save/Read/Write',
		);
	}

	public function getAccessTypeText()
	{
		$options = $this->accessTypeOptions;
		return ($this->accesstype && isset($options[$this->accesstype]))? $options[$this->accesstype]: "None";
	}

	//////////////////////

	public function getSemesterOptions()
	{
		$list = CHtml::listData(getdbolist('Semester', 'true order by starttime desc'), 'id', 'name');
		$list[0] = 'All Semesters';
		return $list;
	}

	public function getSemesterText()
	{
		$options = $this->semesterOptions;
		return isset($options[$this->semesterid])? $options[$this->semesterid]: "Unknown ({$this->semesterid})";
	}
	
	//////////////////

	public function getUrl()
	{
		return array('course/show','id'=>$this->id);
	}

	public function getTeacherName($admin=false)
	{
		$result = '';

		$enrollments = getdbolist('CourseEnrollment', "objectid=$this->id and roleid=".SSPACE_ROLE_TEACHER);
		if($enrollments) foreach($enrollments as $e)
		{
			if($e->user)
			{
				if(!empty($result))
					$result .= ', ';

				if($admin)
					$result .= l($e->user->name, array('user/update', 'id'=>$e->user->id));
				else
					$result .= $e->user->name;
			}
		}

		return $result;
	}
	
	public function getTeacherName2($admin=false)
	{
		$result = '';

		$enrollments = getdbolist('CourseEnrollment', "objectid=$this->id and roleid=".SSPACE_ROLE_TEACHER);
		if($enrollments) foreach($enrollments as $e)
		{
			if($e->user)
			{
				if(!empty($result))
					$result .= ', ';

				if($admin)
					$result .= l($e->user->name);
				else
					$result .= $e->user->email;
			}
		}

		return $result;
	}

	/////////////////////

	public function update()
	{
		$object = getdbo('Object', $this->id);
		$object->attributes = $this->attributes;
		
		$course = getdbo('Course', $this->id);
		$course->attributes = $this->attributes;
		
		if(!$object->save()) return false;
		if(!$course->save()) return false;
		
		return true;
	}

	public function delete()
	{
		$object = getdbo('Object', $this->id);
		//$course = getdbo('Course', $this->id);
		
		$object->delete();
		//$course->delete();
		
		return true;
	}
	
	public function validate()
	{
		$object = new Object;
		$object->attributes = $this->attributes;
				
		$course = new Course;
		$course->attributes = $this->attributes;
		$course->objectid = $object->id;
		
		if(!$object->validate())
		{
			$this->addErrors($object->getErrors());
			return false;
		}
		
		if(!$course->validate())
		{
			$this->addErrors($course->getErrors());
			return false;
		}
		
		return true;
	}

	public function getTypeDetails()
	{
		return $this->object->typeDetails;
	}
	
	public function getCreatedint()
	{
		$a = explode(' ', $this->created);
		return isset($a[0])? $a[0]: '';
	}
	
	public function getCreatedyearint()
	{
		$a = explode('-', $this->createdint);
		return isset($a[0])? $a[0]: '';
	}

	public function getCreatedmonthint()
	{
		$a = explode('-', $this->createdint);
		return isset($a[1])? $a[1]: '';
	}

	public function getCreateddayint()
	{
		$a = explode('-', $this->createdint);
		return isset($a[2])? $a[2]: '';
	}

	public function getNowint()
	{
		$a = explode(' ', now());
		return isset($a[0])? $a[0]: '';
	}
	
	public function getNowyearint()
	{
		$a = explode('-', $this->nowint);
		return isset($a[0])? $a[0]: '';
	}

	public function getNowmonthint()
	{
		$a = explode('-', $this->nowint);
		return isset($a[1])? $a[1]: '';
	}

	public function getNowdayint()
	{
		$a = explode('-', $this->nowint);
		return isset($a[2])? $a[2]: '';
	}
}



