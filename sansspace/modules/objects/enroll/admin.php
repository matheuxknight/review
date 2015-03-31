<?php

showAdminHeader(2);
echo "<h2>Global Enrollments</h2>";

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Roles</a></li>";
echo "<li><a href='#tabs-2'>Users</a></li>";
echo "</ul><br>";

//////////////////////////////////////////////////////////////////////

echo "<div id='tabs-1'>";

showTableSorter('maintable_roles', '{headers: {0: {sorter: false}, 3: {sorter: false}}}');

echo "<thead class='ui-widget-header'><tr>";
echo "<th width=20></th>";
echo "<th>Object</th>";
echo "<th>Role</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

$enrollments = getdbolist('ObjectEnrollment', "userid=0");
if($enrollments) foreach($enrollments as $model)
{
	echo "<tr class='ssrow'>";
	
	echo "<td width=20>".objectImage($model->object, 18)."</td>";
	echo "<td><b>";
	showObjectMenuContext($model->object, array('object/update', 'id'=>$model->object->id, '#'=>'properties-enrollment'));
	echo "</b></td>";
	
	echo "<td>{$model->role->description}</td>";
	
	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
		'submit'=>array('enroll/delete'),
		'params'=>array('id'=>$model->id),
		'confirm'=>"Are you sure you want to unenroll this object?",
		'title'=>'Unenroll')).' ';
	echo "</td>";
	echo "</tr>";
}

echo "</tbody>";
echo "<tr>";
echo "<th></th>";
echo "<th><b>Total: ".count($enrollments)."</b></th>";
echo "<th></th>";
echo "<th></th>";
echo "</tr>";
echo "</table>";
echo "<br>";

echo "</div>";

//////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";

showTableSorter('maintable_users', '{headers: {0: {sorter: false}, 4: {sorter: false}}}');

echo "<thead class='ui-widget-header'><tr>";
echo "<th width=20></th>";
echo "<th>Object</th>";
echo "<th>User</th>";
echo "<th>Role</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

$enrollments = getdbolist('ObjectEnrollment', "userid!=0 and userid is not null");
if($enrollments) foreach($enrollments as $model)
{
	echo "<tr class='ssrow'>";

	echo "<td width=20>".objectImage($model->object, 18)."</td>";
	
	echo "<td><b>";
	showObjectMenuContext($model->object, array('object/update', 'id'=>$model->object->id, '#'=>'properties-enrollment'));
	echo "</b></td>";

	echo "<td><b>";
	showUserMenuContext($model->user, array('user/update', 'id'=>$model->user->id, '#'=>'tabs-6'));
	echo "</b></td>";
	
	echo "<td>{$model->role->description}</td>";

	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
			'submit'=>array('enroll/delete'),
			'params'=>array('id'=>$model->id),
			'confirm'=>"Are you sure you want to unenroll this object?",
			'title'=>'Unenroll')).' ';
	echo "</td>";
	echo "</tr>";
}

echo "</tbody>";
echo "<tr>";
echo "<th></th>";
echo "<th><b>Total: ".count($enrollments)."</b></th>";
echo "<th></th>";
echo "<th></th>";
echo "<th></th>";
echo "</tr>";
echo "</table>";
echo "<br>";

echo "</div>";
echo "</div>";




