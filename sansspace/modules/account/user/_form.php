<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($user);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Account</a></li>";
echo "<li><a href='#tabs-2'>Profile</a></li>";

if($update)
{
	echo "<li><a href='#tabs-8'>Date</a></li>";
	echo "<li><a href='#tabs-3'>Avatar</a></li>";
	echo "<li><a href='#tabs-4'>Roles</a></li>";
	echo "<li><a href='#tabs-5'>Courses</a></li>";
	echo "<li><a href='#tabs-6'>Objects</a></li>";
	echo "<li><a href='#tabs-7'>Others</a></li>";
//	echo "<li><a href='#tabs-7'>Sessions</a></li>";
}
echo "</ul><br>";

/////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-1'>";

echo CUFHtml::openActiveCtrlHolder($user, 'domainid');
echo CUFHtml::activeLabelEx($user, 'domainid');
echo CUFHtml::activeDropDownList($user, 'domainid', User::model()->domainOptions);
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'logon');
echo CUFHtml::activeLabelEx($user, 'logon');
echo CUFHtml::activeTextField($user, 'logon', array('logon','length','max'=>80));
echo "<p class='formHint2'>Unique logon used to connect to this server.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'name');
echo CUFHtml::activeLabelEx($user, 'name');
echo CUFHtml::activeTextField($user,'name',array('maxlength'=>80));
echo "<p class='formHint2'>Complete user name.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'email');
echo CUFHtml::activeLabelEx($user, 'email');
echo CUFHtml::activeTextField($user, 'email', array('email','length','max'=>80));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Password', 'password');
echo CUFHtml::textField('password', '', array('max'=>80, 'class'=>'miscInput'));
if($update)
{
	echo "<p class='formHint2'>Leave blank for no change.</p>";

//	if(!empty($user->password) && !param('required_password'))
//		echo CHtml::linkButton('[Reset Password]',
//			array('submit'=>array('resetpassword', 'id'=>$user->id), 'confirm'=>'Are you sure?'));
}
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Confirm', 'confirm');
echo CUFHtml::textField('confirm', '', array('max'=>80, 'class'=>'miscInput'));
echo "<p class='formHint2'>Confirm the new password.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'custom1');
echo CUFHtml::activeLabelEx($user, 'custom1', array('label'=>'Exempt'));
echo CUFHtml::activeCheckBox($user, 'custom1');
echo "<p class='formHint2'>Check this box to put an unenrolled user on the exempt from delete list.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'enrolled');
echo CUFHtml::activeLabelEx($user, 'enrolled');
echo CUFHtml::activeTextField($user, 'enrolled', array('readonly'=>true));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

/////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";

echo CUFHtml::openActiveCtrlHolder($user, 'organisation');
echo CUFHtml::activeLabelEx($user,'organisation');
echo CUFHtml::activeTextField($user,'organisation',array('maxlength'=>80));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'phone1');
echo CUFHtml::activeLabelEx($user, 'phone1');
echo CUFHtml::activeTextField($user, 'phone1', array('phone1','length','max'=>80));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'address');
echo CUFHtml::activeLabelEx($user, 'address');
echo CUFHtml::activeTextField($user, 'address', array('address','length','max'=>80));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'city');
echo CUFHtml::activeLabelEx($user, 'city');
echo CUFHtml::activeTextField($user, 'city', array('city','length','max'=>80));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'postal');
echo CUFHtml::activeLabelEx($user, 'postal');
echo CUFHtml::activeTextField($user, 'postal', array('maxlength'=>10));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'state');
echo CUFHtml::activeLabelEx($user, 'state');
echo CUFHtml::activeTextField($user, 'state', array('state','length','max'=>20));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'country');
echo CUFHtml::activeLabelEx($user, 'country');
echo CUFHtml::activeTextField($user, 'country', array('country','length','max'=>80));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

/////////////////////////////////////////////////////////////////////////


if($update)
{
echo "<div id='tabs-8'>";

echo CUFHtml::openActiveCtrlHolder($user, 'usedate');
echo CUFHtml::activeLabelEx($user, 'usedate');
echo CUFHtml::activeCheckBox($user, 'usedate', array('class'=>'miscInput'));
echo "<p class='formHint2'>Check to restrict user access to the date range in the fields below.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'startdate');
echo CUFHtml::activeLabelEx($user, 'startdate');
showDatetimePicker($user, 'startdate');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($user, 'enddate');
echo CUFHtml::activeLabelEx($user, 'enddate');
showDatetimePicker($user, 'enddate');
echo CUFHtml::closeCtrlHolder();

echo "</div>";
	
/////////////////////////////////////////////////////////////////////////
	
	
echo "<div id='tabs-3'>";

echo userImage($user);
echo '<br>'.CHtml::linkButton('[Reset Avatar]',
	array('submit'=>array('my/resetpicture', 'id'=>$user->id), 'confirm'=>'Are you sure?'));

echo "</div>";

/////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-4'>";

echo "<table id='maintable_roles' class='dataGrid2'>";
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Enrolled</th>";
echo "<th>Role</th>";
echo "</tr></thead><tbody>";

$startid = SSPACE_ROLE_ADMIN;
$stopid  = SSPACE_ROLE_USER;

if(controller()->rbac->globalNetwork())
	$startid = SSPACE_ROLE_NETWORK;

$roles = getdbolist('Role', "id>=$startid and id<$stopid order by id");
foreach($roles as $role)
{
	echo "<tr class='ssrow'>";
	echo "<td width=50>";
	
	echo CHtml::hiddenField("allroles[$role->id]");
	echo CHtml::checkBox("setrole[$role->id]", isUserEnrolled($user->id, $role->id));
	
	echo "</td>";
	echo "<td><b>{$role->description}</b></td>";
	
	echo "</tr>";
}

echo"</table>";
echo "</div>";

/////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-5'>";

showTableSorter('maintable_courses', '{headers: {6: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th></th>";
echo "<th>Object</th>";
echo "<th>Parent</th>";
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

	echo "<td>{$course->course->semester->name}</td>";
	echo "<td>{$enrollment->role->description}</td>";

	echo "<td>";
	echo l(dboscalar("select count(*) from CourseEnrollment where objectid=$course->id"),
		array('enroll/admin', 'id'=>$course->id));

	echo "</td>";

	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
		'submit'=>array('enroll/delete'),
		'params'=>array('command'=>'delete', 'id'=>$enrollment->id),
		'confirm'=>"Are you sure you want to unenroll $user->name from $course->name?"));
	echo "</td>";

	echo "</tr>";
	$courseCount++;
}
echo "<tr class='ssrow'>";
echo "<td></td><td></td><td></td><td></td><td colspan='2'><b>Courses Enrolled In : $courseCount</b></td></tr>";
echo"</table>";
echo "</div>";



/////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-6'>";

showTableSorter('maintable_objects', '{headers: {5: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th></th>";
echo "<th>Object</th>";
echo "<th>Type</th>";
echo "<th>Parent</th>";
echo "<th>Role</th>";
echo "<th>Enroll Count</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($user->objectenrollments as $enrollment)
{
	$object = $enrollment->object;
	if(!$object) continue;

	echo "<tr class='ssrow'>";
	echo "<td>".l(objectImage($object, 18), objectUrl($object))."</td>";

	echo "<td style='font-weight: bold;'>".l(h($object->name), objectUrl($object))."</td>";
	echo "<td>$object->typeText</td>";
	
	if($object->parent)
		echo "<td>".l(h($object->parent->name), objectUrl($object->parent))."</td>";
	else
		echo "<td></td>";

	echo "<td>{$enrollment->role->description}</td>";

	echo "<td>";
	echo l(dboscalar("select count(*) from ObjectEnrollment where objectid=$object->id"),
		array('enroll/admin', 'id'=>$object->id));

	echo "</td>";

	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
		'submit'=>array('enroll/delete'),
		'params'=>array('command'=>'delete', 'id'=>$enrollment->id),
		'confirm'=>"Are you sure you want to unenroll $user->name from $object->name?"));
	echo "</td>";

	echo "</tr>";
}

echo"</table>";
echo "</div>";

/////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-7'>";

showTableSorter('maintable_others', '{headers: {6: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th></th>";
echo "<th>Object</th>";
echo "<th>Type</th>";
echo "<th>Parent</th>";
echo "<th>Role</th>";
echo "<th>Enroll Count</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($user->courseenrollments as $enrollment)
{
	if($enrollment->object->type == CMDB_OBJECTTYPE_COURSE) continue;
	$object = $enrollment->object;

	echo "<tr class='ssrow'>";
	echo "<td>".l(objectImage($object, 18), objectUrl($object))."</td>";

	echo "<td style='font-weight: bold;'>".l(h($object->name), objectUrl($object))."</td>";
	echo "<td>$object->typeText</td>";
	
	if($object->parent)
		echo "<td>".l(h($object->parent->name), objectUrl($object->parent))."</td>";
	else
		echo "<td></td>";

	echo "<td>{$enrollment->role->description}</td>";

	echo "<td>";
	echo l(dboscalar("select count(*) from ObjectEnrollment where objectid=$object->id"),
		array('enroll/admin', 'id'=>$object->id));

	echo "</td>";

	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
		'submit'=>array('enroll/delete'),
		'params'=>array('command'=>'delete', 'id'=>$enrollment->id),
		'confirm'=>"Are you sure you want to unenroll $user->name from $object->name?"));
	echo "</td>";

	echo "</tr>";
}

echo"</table>";
echo "</div>";

/////////////////////////////////////////////////////////////////////////

//echo "<div id='tabs-5'>";
//echo "</div>";

/////////////////////////////////////////////////////////////////////////
}

echo "</div>";

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

echo <<<end
<script>
$(document).ready(function(){
  $("#User_exempt").change(function(){
	if ($(this).attr('checked')) 
        	$user->exempt = 1;
	else
		$user->exempt = 0;
  });
});
</script>
end;

