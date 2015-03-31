<?php

function showMainTabMenu()
{
//	if(controller()->id == 'site' && controller()->action->id == 'login') return;

	echo "<div id='maintabwrapper' class='sansspacemenu ui-widget-header'>";

	showSearchBox();
	showLoginBox();
	
	echo "<ul>";

	$n = -1;
	$selected = -1;

	$commands = RbacCommandTabTable();
	foreach($commands as $id)
	{
		$command = getdbo('Command', $id);
		if(!controller()->rbac->globalAccess($command))
			continue;

		$n++;

		if(strstr($command->url, controller()->id))
			$selected = $n;

		showMainMenuItem($command);
	}

	$tabmenulist = getdbolist('Tabmenu', "1 order by displayorder");
	foreach($tabmenulist as $tabmenu)
	{
		if($tabmenu->objectid)
		{
			$object = $tabmenu->object;
			if(!$object) continue;
				
 			$b = controller()->rbac->objectUrl($object, 'object');
 			if(!$b) continue;
			
			$n++;
			if($selected == -1)
			{
				$co = controller()->object;
				if($co && strstr($co->parentlist, ", $object->id, "))
					$selected = $n;
			}
		
			showMainTabMenuItem($tabmenu);
		}
		
		else
		{
			$n++;
			showMainTabMenuUrl($tabmenu);
		}
	}
	
	echo "</ul><span id='nav-1' style='display: none'></span></div>";

	if($selected == -1)
		JavascriptReady("$('#maintabwrapper').tabs();");
	else
		JavascriptReady("$('#maintabwrapper').tabs({active: $selected});");
	
	JavascriptReady("sansspace_buildsubmenu('maintabwrapper');");
}

/////////////////////////////////////////////////////////////////

function showMainTabMenuUrl($tabmenu)
{
	echo "<li>";
	echo "<a id='url_{$tabmenu->id}' href='#nav-1'>$tabmenu->name";
	echo "</a>";

	JavascriptReady("$('#url_{$tabmenu->id}').click(function(e){
		window.location.href = '$tabmenu->url';});");
}

function showMainTabMenuItem($tabmenu)
{
	$object = $tabmenu->object;

	echo "<li id='$object->id'>";
	echo "<a id='maintab_{$object->id}' href='#nav-1'>$tabmenu->name";

	echo mainimg('arrow-down.gif', '', array('class'=>'sansspacemenu-anchor'));
	echo "</a>";

	echo '<ul><li>'. l(mainimg('loading_white.gif', '', array('width'=>16)).
 		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'Loading...') .'</li></ul>';

	echo "</li>";
	
	JavascriptReady("$('#maintab_{$object->id}').click(function(e){
		window.location.href = '/object?id=$object->id';});");
}

function showMainMenuItem($command)
{
	echo "<li>";
	
	if($command->id == SSPACE_COMMAND_MY)
	{
		echo "<a id='maintab_c{$command->id}' href='#nav-1'>{$command->name}";
		
		if(param('mysansspacedropdown'))
			echo mainimg('arrow-down.gif', '', array('class'=>'sansspacemenu-anchor'));
		
		echo "</a>";
			
		if(param('mysansspacedropdown'))
			showMyOptions();
	}
	
	else if($command->id == SSPACE_COMMAND_CHAT)
	{
		echo "<a id='maintab_c{$command->id}' href='#nav-1'>{$command->name}</a>";

	//	echo "<span id='totalchatcount'></span>";
	//	echo mainimg('arrow-down.gif', '', array('class'=>'sansspacemenu-anchor'))."</a>";
	//	showChatOptions();
	}
	
	else if($command->id == SSPACE_COMMAND_ADMIN)
	{
		echo "<a id='maintab_c{$command->id}' href='#nav-1'>{$command->name}";
		echo mainimg('arrow-down.gif', '', array('class'=>'sansspacemenu-anchor'))."</a>";
		
		showAdminNavigationBar();
	}

	else
	{
		echo "<a id='maintab_c{$command->id}' href='#nav-1'>{$command->name}</a>";
	}

	echo "</li>";

	$url = "/{$command->url}";
	if(strstr($command->url, 'http://'))
		$url = $command->url;

	JavascriptReady("$('#maintab_c{$command->id}').click(function(e) {
		window.location.href = '$url';});");
}

function showChatOptions()
{
	echo "<ul>";
	
	$user = getUser();
	$semester = getCurrentSemester();
	
	foreach($user->courseenrollments as $e)
	{
		if($e->object->type != CMDB_OBJECTTYPE_COURSE) continue;
		$course = $e->object->course;
		
		if($course->semesterid && $course->semesterid != $semester->id) continue;
			
		$image = iconimg("chat.png", '', array('width'=>16));
		echo '<li>'.l("$image &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$course->name", 
			array('chat/', 'id'=>$course->id)).'</li>';
	}
	
	echo '</ul>';
}

function showMyOptions()
{
	$commands = RbacCommandMyTable();

 	echo "<ul>";
 	foreach($commands as $id)
	{
		$command = getdbo('Command', $id);
		if(!controller()->rbac->globalAccess($command))
			continue;

 		showListCommand($command);
	}

	echo '</ul>';
}

/////////////////////////////////////////////////

function showAdminNavigationBar()
{
	echo "<ul>";

	$adminoptions = getAdminOptions();
	foreach($adminoptions as $admintitle)
	{
		if(isset($admintitle['adminonly']) && !controller()->rbac->globalNetwork()) continue;

		echo '<li>'.l($admintitle['title'], $admintitle['options'][0]['url']).'<ul>';
		foreach($admintitle['options'] as $option)
		{
			if(isset($option['adminonly']) && !controller()->rbac->globalNetwork()) continue;
			echo '<li>'.l($option['name'], $option['url']).'</li>';
		}

		echo '</ul></li>';
	}

	echo '</ul>';
}




