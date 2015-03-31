<?php

function objectShowPropertiesEnrollment($object, $update)
{
	echo "<div id='properties-enrollment'>";
	
	showButtonHeader();
	showButton('Add', array('enroll/create', 'id'=>$object->id));
	
	showButtonPost('Remove All', array(
		'submit'=>array('enroll/deleteall'),
		'params'=>array('command'=>'deleteall', 'id'=>$object->id),
		'confirm'=>"Are you sure you want to unenroll everyone from this group?"));
	
	echo "</div>";
	echo "<br>";
	
	showTableSorter('maintable_enroll', '{headers: {0: {sorter: false}, 3: {sorter: false}}}');
	echo "<thead class='ui-widget-header'><tr>";
	echo "<th width=20></th>";
	echo "<th>User/Role</th>";
	echo "<th>Role</th>";
	echo "<th></th>";
	echo "</tr></thead><tbody>";
	
	$enrollments = getdbolist('ObjectEnrollment', "objectid=$object->id");
	if($enrollments) foreach($enrollments as $model)
	{
		echo "<tr class='ssrow'>";
		if($model->userid != 0)
		{
			echo "<td>".userImage($model->user, 18)."</td>";
	
			echo "<td style='font-weight: bold;'>";
			showUserMenuContext($model->user, array('enroll/update', 'id'=>$model->id));
			echo "</td>";
		}
	
		else
		{
			echo "<td></td>";
			echo "<td style='font-weight: bold;'>";
			echo l('Role', array('enroll/update', 'id'=>$model->id));
			echo "</td>";
		}
	
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
	
	$enrollments = getdbolist('CourseEnrollment', "objectid=$object->id");
	if($enrollments) foreach($enrollments as $enrollment)
	{
		if($enrollment->object->type == CMDB_OBJECTTYPE_COURSE) continue;

		$object = $enrollment->object;
		if(!$object) continue;
		
		$user = $enrollment->user;
		if(!$user) continue;
		
		echo "<tr class='ssrow'>";
		echo "<td>".userImage($user, 18)."</td>";
	
		echo "<td style='font-weight: bold;'>$user->name</td>";
		echo "<td>{$enrollment->role->description}</td>";
	
		echo "<td>";
		echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
			'submit'=>array('enroll/deletecourse'),
			'params'=>array('id'=>$enrollment->id),
			'confirm'=>"Are you sure you want to unenroll this object?",
			'title'=>'Unenroll')).' ';
		echo "</td>";
		echo "</tr>";
	}
	
	echo "</tbody>";
	echo "</table>";
	echo "<br>";
	
	echo "</div>";	
}




