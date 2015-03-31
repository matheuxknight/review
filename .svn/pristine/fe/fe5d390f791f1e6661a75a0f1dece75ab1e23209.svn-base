<?php

$search = getparam('search');
$list = getdbolist('VCourse', "parentid=$code->objectid");
//debuglog($code->objectid);

showTableSorter('maintable', '{headers: {0: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th width=20></th>";
echo "<th style='min-width:300px;'>Course</th>";
echo "<th>Teacher</th>";
echo "<th style='min-width:400px;'>Details</th>";
echo "</tr></thead><tbody>";

$count = 0;
foreach($list as $course)
{
	$teachers = $course->getTeacherName();
	
	if(!empty($search))
	{
		if(	!stristr($course->name, $search) && 
			!stristr($course->tags, $search) && 
			!stristr($teachers, $search))
			continue;
	}

	if(isCourseOutOfDate($course)) continue;

	echo "<tr>";
	echo "<td>".objectImage($course, 16)."</td>";
	
	$coursename = addslashes($course->name);
	
	echo <<<end
<td><a href="javascript:doenrollment('$code->code', $course->id)">
<b>$course->name</b></a></td>
end;
	
	echo "<td>$teachers</td>";
	echo "<td>$course->tags</td>";
	echo "</tr>";
	
	$count++;
}

if(!$count)
	echo "<td></td><td colspan=3><br>If you cannot locate your course, your teacher may not have created it yet. Contact your teacher for course information. Your student access code will remain valid until you choose a course.<br><br></td>";

echo "</tbody></table>";




