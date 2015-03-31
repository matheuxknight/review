<?php

function objectDisplayTitle($object)
{

}

function objectDisplayOverview($object)
{

}

//////////////////////////////////////////////////////////////////////////////////////

function objectContentDisplay($object)
{
	$order = user()->getState('listsort');
	$format = user()->getState('layout');
		
	////////////////////////////////////////////////////////////////
	
	$show_divider = false;
	
	$list = objectContentList($object);
	if(count($list))
	{
		showListResult($object->id, $list);
		$show_divider = true;
	}
	
	if(getparam('filter') != -1) return;

	if(controller()->rbac->objectUrl($object, 'teacherreport'))
	{
		$list = objectContentList($object, CMDB_OBJECTTYPE_COURSE);
		if(count($list))
		{
			if($show_divider) echo "<hr>";
			echo "<b>Courses</b> ";

			if(count($list) > 100)
			{
				$coursesearch = getparam('coursesearch');
				$list = objectContentList($object, CMDB_OBJECTTYPE_COURSE, $coursesearch);
			
				if($coursesearch == 'undefined') $coursesearch = '';
				echo <<<end
<input type='text' name='course-search' id='course-search' size='30' class='sans-input' 
	placeholder='search' value='$coursesearch' /> 

<script>
	$('#course-search').bind('keyup', function(event)
	{
		clearTimeout(this.searching);
		this.searching = setTimeout(function()
		{
			refreshContentPage();
		}, 1000);
	});

</script>
end;
			}

			showListResult($object->id, $list);
			$show_divider = true;
		}
		
		$list = objectContentList($object, CMDB_OBJECTTYPE_QUESTIONBANK);
		if(count($list))
		{
			if($show_divider) echo "<hr>";
			echo "<b>Question Banks</b>";
			
			showListResult($object->id, $list);
			$show_divider = true;
		}
	}
	
	if($object->type != CMDB_OBJECTTYPE_COURSE || !$object->model) return;

	$parent = $object->parent;
	while($parent && $parent->model)
	{
		$cmdb_link = CMDB_OBJECTTYPE_LINK;
		$cmdb_course = CMDB_OBJECTTYPE_COURSE;
		$cmdb_bank = CMDB_OBJECTTYPE_QUESTIONBANK;
		$cmdb_textbook = CMDB_OBJECTTYPE_TEXTBOOK;
		
		if(param('theme') == 'wayside')
			$list1 = getdbolist('Object', "parentid=$parent->id and type!=$cmdb_course and type!=$cmdb_bank and type!=$cmdb_textbook order by $order");
		else
			$list1 = getdbolist('Object', "parentid=$parent->id and type=$cmdb_link order by $order");
		if(count($list1))
		{
			if($show_divider) echo "<hr>";
			//echo "<p><b>$parent->name</b></p>";
			
			echo processDoctext($parent, $parent->ext->doctext);
			showListResult($object->id, $list1);
		}

		$parent = $parent->parent;
	}
}

function objectContentList($object, $showtype=0, $pattern=null)
{
//	debuglog(__METHOD__);
	
	if(isset($_GET['semesterid']) && $_GET['semesterid'] != 'undefined')
	{
		$semesterid = $_GET['semesterid'];
		user()->setState('semesterid', $semesterid);
	}
	
	else
	{
		$semester = getCurrentSemester();
		$semesterid = user()->getState('semesterid', $semester->id);
	}
	
	////////////////////////////////////////////////////////////////
	
	if(isset($_GET['sort']) && !empty($_GET['sort']))
		$order = $_GET['sort'];
	
	else if(user()->getState('listsort') && !isset($_GET['sort']))
		$order = user()->getState('listsort');
	
	else
		$order = 'displayorder, name';
	
	////////////////////////////////////////////////////////////////////////
	
	$sql = '1';
	if(isset($_GET['s']) && !empty($_GET['s']))
	{
		$s = XssFilter($_GET['s']);
		if(!empty($s) && $s != 'Search')

		$sql .= " and (name like '%{$s}%' or tags like '%{$s}%')";
	}
	
	if($pattern)
	{
		debuglog('1');
		$sql .= " and name like '%{$pattern}%'";
	}
	
	////////////////////////////////////////////////////////////////
	
	if(!isset($_GET['filter']))
		;
	
	else if($_GET['filter'] != -1 && $_GET['filter'] != 'undefined')
		$sql = "type={$_GET['filter']} and $sql";

	else
	{
		if($showtype == CMDB_OBJECTTYPE_COURSE || $showtype == CMDB_OBJECTTYPE_QUESTIONBANK)
			$sql = "type=$showtype and ".$sql;
		else
			$sql = "type!=".CMDB_OBJECTTYPE_COURSE." and type!=".CMDB_OBJECTTYPE_QUESTIONBANK." and ".$sql;
	}
	
	////////////////////////////////////////////////////////////////////////
	
//	debuglog("parentid=$object->id and not recordings and $sql order by $order");
	$courseid = getContextCourseId();
	
	$list = getdbolist('Object', "parentid=$object->id and not recordings and $sql order by $order");
	foreach($list as $i=>$o)
	{
		if(!controller()->rbac->objectAction($object, 'view'))
			unset($list[$i]);

		if(!controller()->rbac->objectUrl($object, 'teacherreport') && ($o->deleted || $o->hidden))
			unset($list[$i]);

		if($semesterid>0 && $o->type == CMDB_OBJECTTYPE_COURSE)
		{
			$course = $o->course;
			if($course->semesterid != 0 && $course->semesterid != $semesterid)
				unset($list[$i]);
		}
		
		else if(!$o->recordings && !$o->parent->recordings && $o->courseid && $o->courseid != $courseid)
			unset($list[$i]);
	}
	
	$list = array_values($list);
	return $list;
}








