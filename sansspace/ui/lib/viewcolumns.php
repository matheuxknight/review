<?php

function showListIcons($objects)
{
	$mid  =         intval((count($objects) + 1) / 2);
	$mid1 =         intval((count($objects) + 2) / 3);
	$mid2 = $mid1 + intval((count($objects) + 1) / 3);

	$percent = '33%';
	if(param('columncount') == 2)
		$percent = '50%';
	
	echo "<table cellspacing=0 cellpadding=0 width='100%'><tr><td valign='top' width='$percent'>";
	foreach($objects as $n=>$object)
	{
	//	if(!$object) continue;
		showObjectItemIcons($object);

		if(param('columncount') == 2)
		{
			if($n+1 == $mid)
				echo "</td><td valign='top' width='$percent'>";
		}
		
		else
		{
			if($n+1 == $mid1 || $n+1 == $mid2)
				echo "</td><td valign='top' width='$percent'>";
		}
	}

	echo "</td></tr></table>";
}
	
function showObjectItemIcons($object)
{
	echo "<table cellspacing=0 cellpadding=0 width='100%' class='ssitem'
		style='padding: 6px; '><tr>";
	
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
	
	if($object->type == CMDB_OBJECTTYPE_COURSE && $object->course)
	{
		$teachername = $object->course->getTeacherName();
		$teacher = getdbosql('Role', "name='teacher'");
		if(!empty($teachername))
			echo "$teacher->description : <b>$teachername</b><br>";
				
		if($object->course->semester)
			echo "Semester: <b>{$object->course->semester->name}</b><br>";
	}
	
	if($object->file)
	{
		if($object->file->original)
		{
			echo "Master File: ";
			echo l(h($object->file->original->name),
				array('file/', 'id'=>$object->file->original->id));
			echo "<br>";
		}
	
// 		$bookmark = getdbosql('Bookmark', "recordid=$object->id");
// 		if($bookmark)
// 		{
// 			$master = getdbo('Object', $bookmark->fileid);
// 			echo "Attached to: ";
// 			echo l(h($master->name),
// 			array('file/', 'id'=>$master->id));
// 			echo "<br>";
// 		}
	}
	
	echo "</div>";
	
	if($object->type != CMDB_OBJECTTYPE_FILE)
		showSubfolders($object);

	showTextTeaser($object->ext->doctext, array('object/show', 'id'=>$object->id), 100, 'normal');
	echo "</td></tr></table>";
}

