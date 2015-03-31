
<?php

showAdminHeader(0);
echo "<h2>Courses</h2>";

echo "<script type='text/javascript'>
	function selectFunction()
	{
		var dd = document.getElementById('semesterid');
		window.location = '/admin/courses&semesterid='+dd[dd.selectedIndex].value;
	}
	</script>";
	
echo "<p>Semester: ";

if(isset($_GET['semesterid']))
	$semesterid = $_GET['semesterid'];
else
{
	$semester = getCurrentSemester();
	$semesterid = $semester->id;
}

echo CHtml::dropDownList('semesterid', $semesterid, Semester::model()->options,
	array('onchange'=>'javascript:selectFunction()'));

echo "</p>";

echo "<br>";

showTableSorter('maintable');
echo "<thead class='ui-widget-header'><tr>";
echo "<th width=20></th>";
echo "<th>Course Name</th>";
echo "<th>Folder</th>";
echo "<th>Exemption Status</th>";
echo "<th>Creation Date</th>";
echo "<th>Semester</th>";
echo "<th>Teacher</th>";
echo "<th>Enrolled</th>";
echo "</tr></thead><tbody>";

$n = 0;
$totalenroll = 0;

foreach($courses as $course)
{
	if(!$course->parent) continue;
	if($course->semesterid != $semesterid && $semesterid != 0)
		continue;

	$n++;
	echo "<tr class='ssrow'>";
	echo "<td>".l(objectImage($course, 18), objectUrl($course))."</td>";

	echo "<td style='font-weight: bold;'>";
	showObjectMenuContext($course);
	echo "</td>";
	
	echo "<td>";
	showObjectMenuContext($course->parent);
	echo "</td>";
	
	echo "<td>{$course->exempt}</td>";
	echo "<td style='width:200px'>{$course->createdint}</td>";
	echo $course->semester? "<td>{$course->semester->name}</td>": "<td></td>";
		
	echo "<td>".$course->getTeacherName(true)."</td>";

	echo "<td>";
	$count = dboscalar("select count(*) from CourseEnrollment where objectid=$course->id");
	echo l($count, array('teacherreport/', 'id'=>$course->id));
		
	echo "</td>";
	echo "</tr>";
	
	$totalenroll += $count;
}

echo "</tbody><tr>";

echo "<th></th>";
echo "<th>$n Courses</th>";
echo "<th></th>";
if($semesterid == 0)
	echo "<th></th>";
echo "<th></th>";
echo "<th>$totalenroll</th>";
	
echo "</tr>";
	
echo"</table>";
echo "<br/>";


