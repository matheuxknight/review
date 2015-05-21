<?php

function showFolderContents($id)
{
	$loading_image = mainimg('loading_white.gif');
	$defaultsort = user()->getState('listsort');
	
	if(!$defaultsort || empty($defaultsort) || $defaultsort == 'null')
		$defaultsort = param('defaultorder');
	
//	debuglog("defaultsort $defaultsort");

//	$noheader = '';
//	if(IsMobileEmbeded())
//		$noheader = "&noheader";

	if(intval($id))
	{
		$object = getdbo('Object', $id);
		if($object)
		{
			if(!count($object->children) && $object->type != CMDB_OBJECTTYPE_LINK)
			{
				echo <<<END
<div id='results'></div>
<script>$(function(){
	$.get("/html/objectresults&id=$id&sort={$defaultsort}",
	function(data){ $('#results').append(data);});});
</script>
END;
				return;
			}
		}
	}

	////////////////////////////////////////////////////////////
	
	$searchtitle = 'Search';
	$searchstring = 'Search';

	$allchecked = '';
	$displayfilters = 'none';
	
	if(isset($_GET['s']))
	{
		$searchstring = XssFilter($_GET['s']);
		$allchecked = 'checked=true';
		$displayfilters = 'visible';
		$_GET['recursive'] = 'true';
	}

	$format = user()->getState('layout');
	$defaultfilter = '-1';

	///////

	if(intval($id))
	{
		$object = getdbo('Object', $id);
		if($object)
		{
			if(controller()->action->id == 'recents')
			{
				$defaultsort = 'updated desc';
				$format = 'showdetail';
	
				$allchecked = 'checked=true';
				$_GET['recursive'] = 'true';
			}

			else if($object->post)
			{
				$defaultsort = 'updated desc';
				$format = 'showdetail';
			}
			
			else if(!empty($object->defaultsort))
			{
				$defaultsort = $object->defaultsort;
				$format = 'showsmall';
			}
				
			else
			{
				$defaultsort = param('defaultorder');
				$format = 'showsmall';
			}
		}
		
	//	debuglog("defaultsort $defaultsort");
	}

	///////

	if(isset($_GET['semesterid']) && $_GET['semesterid'] != 'undefined')
		$semesterid = $_GET['semesterid'];
	else
	{
		$semester = getCurrentSemester();
		$semesterid = user()->getState('semesterid', $semester->id);
	}
		
//	debuglog("semesterid2 $semesterid");
	
	$semesterselect = CHtml::dropDownList('semesterid', $semesterid,
		Semester::model()->options, array('title'=>'Filter by semester'));
	
	$extrastyle = '';
	if(!controller()->rbac->globalAdmin() && param('theme') == 'wayside')
		$extrastyle = 'display: none; height: 0px; width: 0px;';
		
	echo <<<END

	<div id="searchdiv" style="$extrastyle margin-top:10px" >
	<input type="checkbox" id="showpanel" $allchecked />
		<label for="showpanel" title="Search from this folder">Filters</label>

	&nbsp;
	<span id="searchpanel" style="display: $displayfilters;" >

	<input type="checkbox" id="recursive" $allchecked />
		<label for="recursive" title='Show all contents recursively' >All</label>

	&nbsp;
	<input type='text' name='search' id='search' size='30' class='sans-input'
		onblur="this.value==''?this.value='$searchtitle':''"
		onclick="this.value=='$searchtitle'?this.value='':''"
		value='$searchstring' title="Search string" />

	<select id="sortdropdown" title="Sort by" class="sans-combobox" >
		<option value='displayorder'>Default</option>
		<option value='name'>Name</option>
		<option value='duration desc'>Duration</option>
		<option value='updated desc'>Date</option>
		<option value='size desc'>Size</option>
		<option value='views desc'>Views</option>
	</select>

	$semesterselect

	<select id="filterdropdown" title="Filter by object type" class="sans-combobox" >
		<option value=-1>All</option>
		<option value=0>Folder</option>
		<option value=1>File</option>
		<option value=2>Course</option>
		<option value=4>Link</option>
		<option value=5>Question</option>
		<option value=6>Flashcard</option>
		<option value=7>Survey</option>
		<option value=8>Lesson</option>
		<option value=9>Quiz</option>
		<option value=10>Textbook</option>
		</select>

	&nbsp;
	<span id='showoptions2'>
		<input type="radio" id="showmedium" name="showoptions2"/><label for="showmedium">One per Line</label>
		<input type="radio" id="showsmall" name="showoptions2"/><label for="showsmall">Columns</label>
		<input type="radio" id="showdetail" name="showoptions2"/><label for="showdetail">Detailed</label>
	</span>

	</span></div>

	<div id='results' style='margin-top:15px'>
	<p style='margin-left: 300px;'>$loading_image</p>
	</div>

<script>initSearchBar('$id', '$searchtitle', '$format', '$defaultsort', '$semesterid', '$defaultfilter');</script>

END;

}




