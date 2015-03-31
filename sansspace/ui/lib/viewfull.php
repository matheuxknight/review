<?php

function showListFull($objects)
{
	echo '<table cellspacing=0 cellpadding=0 width="100%">';
	foreach($objects as $n=>$object) showObjectItemFull($object);
	echo '</table>';
}

function showObjectIdent($object)
{
	$indent = 0;
	$parent = getdbo('Object', $_REQUEST['id']);
	if($parent)
	{
		$iter = $object->parent;
		while($iter->id != $parent->id)
		{
			$indent++;
			$iter = $iter->parent;
		}
	}
	
	return $indent;
}

function showObjectItemFull($object)
{
 	echo "<tr class='ssrow'><td width='60%'>";
 	if(strstr(app()->getRequest()->getUrlReferrer(), 'recents'))
 		$indentpixel = showObjectIdent($object)*50;
 	else
 		$indentpixel = 0;
 	
	echo "<table cellspacing=0 cellpadding=0 width='100%' class='ssitem'
		style='padding-left: {$indentpixel}px;'><tr>";
	
	echo "<td width=56 valign=top>";
	echo l(objectImage($object), objectUrl($object));
	echo "</td>";
	
	echo "<td id='object_{$object->id}_parent' valign=top>";
	showObjectMenuContext($object);
	
	echo "<div class='small'>";
	
	if(!empty($object->tags))
		echo "Tags: <b>$object->tags</b><br>";
	
	echo $object->typeDetails;
		
	echo "</div>";
	echo "<div class='small'>";
	
	if($object->file)
	{
		if($object->file->original)
		{
			echo "Master File: ";
			echo l(h($object->file->original->name), 
				array('file/', 'id'=>$object->file->original->id));
		}
		
// 		$bookmark = getdbosql('Bookmark', "recordid=$object->id");
// 		if($bookmark)
// 		{
// 			$master = getdbo('Object', $bookmark->fileid);
// 			echo "Attached to: ";
// 			echo l(h($master->name), array('file/', 'id'=>$master->id));
// 		}
	}
		
	if($object->type == CMDB_OBJECTTYPE_COURSE && $object->course)
	{
		$teachername = $object->course->getTeacherName();
		$teacher = getdbosql('Role', "name='teacher'");
		if(!empty($teachername))
			echo "$teacher->description : <b>&nbsp;$teachername</b><br>";
			
		if($object->course->semester)
			echo "Semester: <b>{$object->course->semester->name}</b><br>";			
	}
	
	echo "</div>";
	if($object1->type != CMDB_OBJECTTYPE_FILE)
		showSubfolders($object);

	showTextTeaser($object->ext->doctext, array('object/show', 'id'=>$object->id), 160, 'small');
	
	echo "</td></tr></table>";
	echo "</td>";
	
	$authorname = $object->author? $object->author->name: 'SYSTEM';
	
	if($object->parent->post)
		echo "<td width=52 valign=top style='padding-top: 10px;'>".userImage($object->author, 32)."</td>";
	else
		echo "<td></td>";

//	if(param('theme') != 'wayside')
//	{
		echo "<td nowrap valign=top style='padding-top: 5px'><span style='font-size:0.85em'>";
		
		echo "<b>$authorname</b><br>";
		echo "Created ".datetoa($object->created). "<br>";
		
		if($object->created != $object->updated)
			echo "Updated ".datetoa($object->updated);
		
		echo "</span></td>";
//	}
		
	$commentcount = getdbocount('Comment', "parentid=$object->id");
	$childcount = getdbocount('Object', "parentid=$object->id");
	
	echo "<td nowrap valign=top style='padding-top: 5px'><span style='font-size:0.85em'>".
		"&nbsp; &#9679; {$object->ext->views} Views<br>".
	//	"&nbsp; &#9679; $childcount Children<br>".
		"&nbsp; &#9679; $commentcount Comments<br>";
		
	if($commentcount)
	{
		$lastcomment = getdbosql('Comment', 
			"parentid=$object->id order by updated desc");
		
		if($lastcomment)
			echo "&nbsp; &#9679; {$lastcomment->author->name}";
	}

	echo "&nbsp;&nbsp;&nbsp;&nbsp;</span></td>";
//	objectReadyState($object);
	
	echo "</tr>";
}
