<?php

$user = getUser();
$object = getdbo('Object', getparam('id'));
$course = getContextCourse();

$this->pageTitle = app()->name ." - ". $object->name;

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

$questioncount = getdbocount('Survey', "objectid=$object->id");
if($course)
	$listuser = getdbolist('CourseEnrollment', "objectid=$object->id and courseid=$course->id");
else
	$listuser = getdbolist('CourseEnrollment', "objectid=$object->id");

echo "<table cellspacing=4>";
echo "<tr><td>Number of Questions </td><td><b>$questioncount</b></td></tr>";
echo "</table><br>";

////////////////////////////////////////////////////////////////////////////////////////////

showTableSorter('maintable', '{headers: {0: {sorter: false}}}');

echo "<thead class='ui-widget-header'><tr>";
echo "<th width=20></th>";
echo "<th>User</th>";
echo "<th>Attempted</th>";
echo "</tr></thead><tbody>";

foreach($listuser as $model)
{
	$user = $model->user;

	if($course)
		$answerred = getdbocount('SurveyAnswer', "userid=$user->id and surveyid in (select id from Survey where objectid=$object->id) and courseid=$course->id");
	else
		$answerred = getdbocount('SurveyAnswer', "userid=$user->id and surveyid in (select id from Survey where objectid=$object->id)");
	
	echo "<tr class='ssrow'>";
	echo "<td>".userImage($user, 18)."</td>";

	echo "<td style='font-weight: bold;'>";
	echo l($user->name, array('studentreport/', 'id'=>$object->id, 'userid'=>$user->id));
	echo "</td>";

	$b = Booltoa($answerred != 0);
	echo "<td>$b</td>";
	echo "</tr>";
}

echo "</tbody>";

$count = count($listuser);

echo "<tr class='ssrow'>";
echo "<th></th>";
echo "<th><b>$count Users</b></th>";

echo "<th></th>";

echo "</tr>";
echo "</table>";





