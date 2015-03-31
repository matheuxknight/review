<?php

$this->pageTitle = "My Reports ". Yii::app()->name;
echo "<h2>Grades</h2>";

$user = getUser();
showTableSorter('maintable', '{headers: {1: {sorter: false}, 2: {sorter: false}, 0: {sorter: false}}}');

echo "<thead class='ui-widget-header'><tr>";
echo "<th width=20></th>";
echo "<th>Course</th>";
//echo "<th>Semester</th>";
//echo "<th>File Views</th>";
//echo "<th>Play Time</th>";
//echo "<th>Record Time</th>";
//echo "<th>Status</th>";
//echo "<th>Grade</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

//$totalplay = 0;
//$totalrecord = 0;

foreach($user->courseenrollments as $enrollment)
{
	if($enrollment->object->type != CMDB_OBJECTTYPE_COURSE) continue;
	$course = $enrollment->object->course;
	

	//$playtime = getPlayTime($course->semester, $course, $user);
	//$recordtime = getRecordTime($course, $user);
	
	//$totalplay = $playtime;
	//$totalrecord = $recordtime;
	
	echo "<tr class='ssrow'>";
	echo '<td>'.objectImage($course, 24).'</td>';
	
	echo "<td style='font-weight: bold;'>";
	if(controller()->rbac->globalTeacher())
	{
		echo "<a href='/teacherreport?id=$course->id'>$course->name</a>";
	}
	else
	{
		echo "<a href='/studentreport?id=$course->id'>$course->name</a>";
	}
	echo "</td>";
		
	//if($course->semester)
		//echo "<td>{$course->semester->name}</td>";
	//else
		//echo "<td></td>";
		
	//echo "<td><b>".l(sectoa($playtime), array('studentreport/', 'id'=>$course->id))."</b></td>";
	
	//$folder = userRecordingFolder($course);
	//echo "<td><b>".l(sectoa($recordtime), array('object/show', 'id'=>$folder->id))."</b></td>";
	
//	echo "<td>$enrollment->statusText</td>";
	//echo "<td>$enrollment->grade</td>";
	
	echo "<td>";
	$teacher = getdbosql('Role', "name='teacher'");
	if(controller()->rbac->objectAction($course, 'update'))
		echo "".l("$teacher->description Report", array('teacherreport/', 'id'=>$course->id));
	
	echo "</td>";
	echo "</tr>";
}

echo "</tbody><tr>";
//echo "<th></th>";
//echo "<th>Total:</th>";
//echo "<th></th>";
//echo "<th>".sectoa($totalplay)."</th>";
//echo "<th>".sectoa($totalrecord)."</th>";
//echo "<th></th>";
//echo "<th></th>";
//echo "<th></th>";
//echo "</tr>";

echo "</table>";
echo "<br/>";




