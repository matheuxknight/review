<?php

showAdminHeader(2);
echo "<h2>Global Permissions</h2>";

showButtonHeader();
showButtonPost('Reset to Default', array(
	'submit'=>array('resetpermissions'),
	'confirm'=>'Are you sure you want to reset the global permissions?'));
echo "</div><br>";

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Tab Menu</a></li>";
echo "<li><a href='#tabs-2'>My SANSSpace</a></li>";
echo "<li><a href='#tabs-3'>Folder</a></li>";
echo "<li><a href='#tabs-4'>File</a></li>";
echo "<li><a href='#tabs-5'>Course</a></li>";
echo "<li><a href='#tabs-6'>Comment</a></li>";
echo "<li><a href='#tabs-7'>Textbook</a></li>";
echo "<li><a href='#tabs-8'>Quiz</a></li>";
echo "<li><a href='#tabs-10'>Survey</a></li>";
echo "<li><a href='#tabs-11'>Flashcard</a></li>";
echo "</ul><br>";

echo CUFHtml::beginForm();

showPermissionTab('tabs-1', 'Tab Menu');
showPermissionTab('tabs-2', 'My SANSSpace');
showPermissionTab('tabs-3', 'Folder');
showPermissionTab('tabs-4', 'File');
showPermissionTab('tabs-5', 'Course');
showPermissionTab('tabs-6', 'Comment');
showPermissionTab('tabs-7', 'Textbook');
showPermissionTab('tabs-8', 'Quiz');
showPermissionTab('tabs-10', 'Survey');
showPermissionTab('tabs-11', 'Flashcard');

echo "</div>";

showSubmitButton('Save');
echo CUFHtml::endForm();

function showPermissionTab($tabname, $section)
{
	echo "<div id='$tabname'>";
	
	echo "<table id='maintable' class='dataGrid2'>";
	echo "<thead class='ui-widget-header'><tr>";
	
	echo "<th></th>";
	echo "<th>Permission</th>";
	echo "<th></th>";
	
	$roles = getdbolist('Role', "id > 2 and type like '%user%' order by id desc");
	foreach($roles as $role)
		echo "<th>$role->description</th>";
	
	echo "</tr></thead><tbody>";
	
	$commands = getdbolist('Command', "1 order by description, name");
	foreach($commands as $command)
	{
		if(!strstr($section, $command->description)) continue;
		
		echo "<tr class='ssrow'>";
		echo "<td width=20>$command->image</td>";
		echo "<td><b>".l($command->name, array('update', 'id'=>$command->id))."</b></td>";
		echo "<td></td>";
		
		foreach($roles as $role)
		{
			$has = controller()->rbac->objectRoleAccess($command->id, $role->id);
			
			echo "<td>";
			echo CHtml::hiddenField("allperms[$command->id][$role->id]");
			echo CHtml::checkBox("setperm[$command->id][$role->id]", $has, 
					array('class'=>'setperm_class'));
			echo "</td>";
		}
		
		echo "</tr>";
	}
	
	echo "<tbody></table>";
	echo "<br/></div>";
}

$role_owner = SSPACE_ROLE_OWNER;
$role_forum = SSPACE_ROLE_FORUM;
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
				$(prefix+$role_forum).attr("disabled", true);
				$(prefix+$role_owner).attr("disabled", true);
				$(prefix+$role_student).attr("disabled", true);
				$(prefix+$role_teacher).attr("disabled", true);
				$(prefix+$role_content).attr("disabled", true);
				
				$(prefix+$role_forum).attr("checked", true);
				$(prefix+$role_owner).attr("checked", true);
				$(prefix+$role_student).attr("checked", true);
				$(prefix+$role_teacher).attr("checked", true);
				$(prefix+$role_content).attr("checked", true);
			}
			else
			{
				$(prefix+$role_forum).removeAttr("disabled");
				$(prefix+$role_owner).removeAttr("disabled");
				$(prefix+$role_student).removeAttr("disabled");
				$(prefix+$role_teacher).removeAttr("disabled");
				$(prefix+$role_content).removeAttr("disabled");
			}
	}
}

</script>
END;






