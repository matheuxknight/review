<?php

function showUserMenuContext($user, $defaulturl=null)
{
	echo "<span id='user_item_{$user->id}'>";
	
	if($defaulturl) echo l($user->name, $defaulturl);
	else echo $user->name;

//	echo mainimg('arrow-down.gif', '', 
//		array('id'=>"user_anchor_{$user->id}", 'class'=>'objectmenu-anchor'));

// 	echo "<div id='user_box_{$user->id}' class='objectmenu-box'>";

//  	echo '<ul><li>'. l(mainimg('loading_white.gif', '', array('width'=>16)).
//  		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'Loading...') .'</li></ul>';

// 	echo "</div></span>";
// 	echo "<script>$(function(){initUserMenu({$user->id});});</script>";
}

function showObjectMenuContext($object, $defaulturl=null, $defaultname=null)
{
	if(!$defaulturl) $defaulturl = objectUrl($object);
	if(!$defaultname) $defaultname = $object->name;
	
// 	if($object->parent->recordings && userid() == $object->authorid)
// 		$defaultname = "{$object->parent->parent->name} Saved Work";
	
	echo "<span id='object_item_{$object->id}'>";
	
	echo l(h($defaultname), $defaulturl);
	echo "<div id='object_box_{$object->id}' class='objectmenu-box'>";

 	echo '<ul><li>'. l(mainimg('loading_white.gif', '', array('width'=>16)).
 		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.'Loading...') .'</li></ul>';
		
	echo "</div>";
	
	echo mainimg('arrow-down.gif', '',
		array('id'=>"object_anchor_{$object->id}", 'style'=>'padding: 1px 10px 1px 10px;')).' ';
	
	echo "</span>";
	
//	if(canQuickContent($object))
//	{
//		$height = heightQuickContent($object);
//		
//		echo "<span id='object_quickview_{$object->id}' class='objectmenu-quickview'
//			style='font-size: .7em; font-weight: normal;'>";
//		echo " <a href='#' id='button_quickview_{$object->id}'>QuickView</a>";
//		echo "</span>";
//		
//		echo <<<END
//<script>$(function(){
//	$('#button_quickview_{$object->id}').click(function(){
//		onShowQuickView({$object->id}, "{$object->name}", $height);
//		return false;});});</script>
//END;
//	}
	
	echo "<script>$(function(){initObjectMenu({$object->id});});</script>";
}



