<?php

echo "<h2>User Enrollment for $user->name ($user->logon)</h2>";
showButtonHeader();

showButton('All Users', array('admin'));
showButton('New User',array('create'));

showButton('User Sessions', array('session/admin', 'user'=>$user->id));
showButton('User Details', array('update', 'id'=>$user->id));
showButton('User Folder', array('object/show', 'id'=>$user->folderid));
//showButton('Add Enrollment', array('createenrollment', 'id'=>$user->id));

if($user->id != 1)
	showButtonPost('Delete User',array('submit'=>array('delete','id'=>$user->id),'confirm'=>'Are you sure?'));

echo "</div><br>";
echo "<br>";

showTableSorter('maintable');
echo "<thead class='ui-widget-header'><tr>";
echo "<th></th>";
echo "<th>Object</th>";
echo "<th>Folder</th>";
echo "<th>Semester</th>";
echo "<th>Role</th>";
echo "<th>Enroll Count</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($user->courseenrollments as $enrollment)
{
	if($enrollment->object->type != CMDB_OBJECTTYPE_COURSE) continue;
	$course = $enrollment->object->course;
	
	echo "<tr class='ssrow'>";
	echo "<td>".l(objectImage($course, 18), objectUrl($course))."</td>";
	
	echo "<td style='font-weight: bold;'>".l(h($course->name), objectUrl($course))."</td>";
	
	if($course->parent)
		echo "<td>".l(h($course->parent->name), objectUrl($course->parent))."</td>";
	else
		echo "<td></td>";
	
	echo "<td>{$course->semester->name}</td>";
	echo "<td>{$enrollment->role->description}</td>";
	
	echo "<td>";
	echo l(dboscalar("select count(*) from CourseEnrollment where objectid=$course->id"),
		array('enroll/admin', 'id'=>$course->id));
		
	echo "</td>";
	
	echo "<td>";
	echo CHtml::linkButton('Unenroll', array(
		'submit'=>array('enroll/delete'),
		'params'=>array('command'=>'delete', 'id'=>$enrollment->id),
		'confirm'=>"Are you sure you want to unenroll $user->name from $course->name?"));
	echo "</td>";

	echo "</tr>";
}

foreach($user->objectenrollments as $enrollment)
{
	$object = $enrollment->object;
	if(!$object) continue;

	echo "<tr class='ssrow'>";
	echo "<td>".l(objectImage($object, 18), objectUrl($object))."</td>";
	
	echo "<td style='font-weight: bold;'>".l(h($object->name), objectUrl($object))."</td>";
	
	if($object->parent)
		echo "<td>".l(h($object->parent->name), objectUrl($object->parent))."</td>";
	else
		echo "<td></td>";
	
	echo "<td>{$object->semester->name}</td>";
	echo "<td>{$enrollment->role->description}</td>";
	
	echo "<td></td>";
	
	echo "<td>";
	echo CHtml::linkButton('Unenroll', array(
		'submit'=>array('enroll/delete'),
		'params'=>array('command'=>'delete', 'id'=>$enrollment->id),
		'confirm'=>"Are you sure you want to unenroll $user->name from $object->name?"));
	echo "</td>";

	echo "</tr>";
}

echo"</table>";
echo "<br/>";


