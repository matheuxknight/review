<?php

function objectShowPropertiesPermission($object, $update)
{
	echo "<div id='properties-permission'>";
	
	InitMenuTabs('#tabs2');
	
	echo "<div id='tabs2' style='display:none;'><ul>";
	echo "<li><a href='#tabs2-3'>Folder</a></li>";
	echo "<li><a href='#tabs2-5'>File</a></li>";
	echo "<li><a href='#tabs2-6'>Course</a></li>";
	echo "<li><a href='#tabs2-7'>Activity</a></li>";
	echo "<li><a href='#tabs2-4'>Comment</a></li>";
	echo "</ul><br>";
	
	showPermissionTabObject($object, 'tabs2-3', 'Folder');
	showPermissionTabObject($object, 'tabs2-5', 'File');
	showPermissionTabObject($object, 'tabs2-6', 'Course');
	showPermissionTabObject($object, 'tabs2-7', 'Activity, Quiz');
	showPermissionTabObject($object, 'tabs2-4', 'Comment');
	
	initPermissionTab($object);
	echo "</div>";
	
	echo "<br/>";
	
	showButtonHeader();

// 	showButtonPost('Save Permissions', array(
// 		'submit'=>array('permission/saveobject', 'id'=>$object->id),
// 		'confirm'=>'Are you sure you want to save this object\'s permissions?'));

	echo "<a href='#' id='save-permission'>Save Permissions</a>";

	if($object->custompermission)
		showButtonPost('Reset Permissions', array(
			'submit'=>array('permission/resetobject', 'id'=>$object->id),
			'confirm'=>'Are you sure you want to reset this object\'s permissions?'));
	
	echo "</div><br>";
	echo "<b><font color=red>SAVE PERMISSIONS USING THE SAVE PERMISSIONS BUTTON ABOVE.<br><br></font></b>";
	echo "</div>";	
}

function showPermissionTabObject($object, $tabname, $section)
{
	echo "<div id='$tabname'>";

	echo "<table class='dataGrid2'>";
	echo "<thead class='ui-widget-header'><tr>";
	
	echo "<th></th>";
	echo "<th>Permission</th>";
//	echo "<th></th>";
	echo "<th></th>";
	
 	$roles = getdbolist('Role', "id > 2 and type like '%user%' order by id desc");
	foreach($roles as $role)
		echo "<th>$role->description</th>";
	
	echo "</tr></thead><tbody>";
	
	$commands = getdbolist('Command', "objecttype order by name");
	foreach($commands as $command)
	{
	//	debuglog($command->name);
		if(!strstr($section, $command->description)) continue;
		
		$me = controller()->rbac->objectAccess($object, $command);
		if(!$me) continue;

		echo "<tr class='ssrow'>";
		echo "<td width=20>$command->image</td>";
		echo "<td><b>$command->name</b></td>";
	//	echo "<td><b>$command->description</b></td>";
		echo "<td></td>";
		
		foreach($roles as $role)
		{
			$has = controller()->rbac->objectRoleAccess($command->id, $role->id, $object);
			$has2 = controller()->rbac->objectRoleAccess($command->id, $role->id);
	
			echo CHtml::hiddenField("allperms[$command->id][$role->id]", $has);

			if($has != $has2)
				echo "<td style='background-color: rgba(255,244,191,0.5);'>";
			else
				echo "<td>";

			echo CHtml::checkBox("setperm[$command->id][$role->id]", $has,
				array('class'=>'setperm_class'));
			echo "</td>";
		}
		
		if($me) echo "</tr>";
	}
	
	echo "<tbody></table>";
	echo "</div>";
}

function initPermissionTab($object)
{
	$role_content = SSPACE_ROLE_CONTENT;
	$role_teacher = SSPACE_ROLE_TEACHER;
	$role_student = SSPACE_ROLE_STUDENT;
	$role_user = SSPACE_ROLE_USER;
	$role_all = SSPACE_ROLE_ALL;
	
	echo <<<END

<script>
$(function()
{
	$('.setperm_class').each(function(e)
	{
		var ar = this.id.match(/\d+/g);
		refresh_item(ar[0], ar[1]);
	});

	$('.setperm_class').change(function(e)
	{
		var ar = this.id.match(/\d+/g);
		refresh_item(ar[0], ar[1]);
	});
	
	$('#save-permission').click(function(e)
	{
		if(confirm('Are you sure you want to save this object\'s permissions?'))
		{
			$('.setperm_class').each(function(e){ $(this).removeAttr("disabled");});
			jQuery.yii.submitForm(this, '/permission/saveobject?id=$object->id',{});
		}
		
		return false;
	});
});

function refresh_item(itemid, roleid)
{
	var prefix = '#setperm_'+itemid+'_';
	var checked = $(prefix+roleid).is(':checked');

	switch(roleid)
	{
		case '$role_all':
			if(checked)
			{
				$(prefix+$role_user).attr("disabled", true);
				$(prefix+$role_user).attr("checked", true);
			}
			else
				$(prefix+$role_user).removeAttr("disabled");

			refresh_item(itemid, '$role_user');
			break;

		case '$role_user':
			if(checked)
			{
				$(prefix+$role_student).attr("disabled", true);
				$(prefix+$role_teacher).attr("disabled", true);
				$(prefix+$role_content).attr("disabled", true);

				$(prefix+$role_student).attr("checked", true);
				$(prefix+$role_teacher).attr("checked", true);
				$(prefix+$role_content).attr("checked", true);
			}
			else
			{
				$(prefix+$role_student).removeAttr("disabled");
				$(prefix+$role_teacher).removeAttr("disabled");
				$(prefix+$role_content).removeAttr("disabled");
			}
	}
}

</script>
END;
}




