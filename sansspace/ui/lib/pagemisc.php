<?php

function showObjectComments($object)
{
	if(!controller()->rbac->objectAccess2($object, SSPACE_COMMAND_COMMENT_VIEW)) return;
	
	echo "<br>";
    $comments = getdbolist('Comment', "parentid=$object->id order by pinned desc, created");
    if(!$object->post){
        JavascriptReady("$('#quickcomment').css({'left': '-9999px', 'height': '0px'});");
        JavascriptReady("\$('#showcommentinput').click(function(){\$('#quickcomment').css({'left': '0px', 'height': '100%'});});");
    }
   
   	echo "<div id='commentblock'>";   
	if(	param('quickcomment') )
	{
        //echo CUFHtml::button('Add Comment', array('id'=>'showcommentinput','style'=>'margin-bottom:10px'));
        //JavascriptReady("$('#showcommentinput').click(function(){\$('#quickcomment').show();});");
        $comment = new Comment;
        
		echo CUFHtml::beginForm("/comment/create&id=$object->id");
        if(!$object->post){
		echo "<div id='showcommentinput'><b>Add Comment</b>&nbsp;<img src='/images/ui/arrow-down.gif'></div>";}
	    echo "<div id='quickcomment'>";
		echo CUFHtml::activeTextArea($comment, 'doctext');
		showAttributeEditor($comment, 'doctext', 120, 'custom1');
		
	 	echo "<br>";
	 	
		showButtonHeader();
		echo CUFHtml::submitButton('Add Comment', array('id'=>'btnSubmit'));
		//echo "<input id='saveasbutton' value='Save As...' size='6'>";
		echo "</div></div>";
        
		// TODO: if not mediafile
// 		if(!$object->file || $object->file->filetype != CMDB_FILETYPE_MEDIA)
// 			echo "<input id='recorderbutton' value='Recorder...' size='7'>";

//		echo "</div>";
	 	//echo <<<END
//<script>
//$(function()
//{
//	$('#saveasbutton').click(function()
// 	{
//		onShowObjectBrowser('html', false, true, '', '', 'myfolders', 'My Saved Work', 
//			function(selectedid, selectedname) 
//			{
//				post_to_url('/file/createhtml?id='+selectedid, 
//				{
//					'VFile[name]': selectedname,
//					'VFile[originalid]': $object->id,
//					'htmlcontents': $('#Comment_doctext').elrte('val')
//				});
//			});
			
//		return false;
//	});
	
//	$('#recorderbutton').click(function()
//	{
//		$('#recorder_dialog_div').remove();
//		$('body').append('<div id="recorder_dialog_div" style="padding: 0px;" />');
		
//		$('#recorder_dialog_div').dialog(
//		{
//			title: 'Quick Recorder',
//			autoOpen: true, 
//			width: 360, 
//			height: 354, 
//			minWidth: 300,
//			minHeight: 300,
//			modal: false,
			
//			resize: function(event, ui)
//			{
//				var h = $('#recorder_dialog_div').height();
//				$('#sansmediad').css("height", h);
//			},
//			beforeClose: function(event, ui){},
//		})

//		$.get('/recorder/internalquickrecorder&id=', '', 
//			function(data)
//			{
//				$('#recorder_dialog_div').html(data);
//			});
//	});

//});
//</script>
//END;
		echo CUFHtml::endForm();
	}
 
	if(count($comments))
	{
		$courseid = getContextCourseId();
		//echo "<p><b>User Comments: ".count($comments)."</b></p>";

		foreach($comments as $comment)
		{
			if(!$comment->courseid || $comment->courseid == $courseid)
				showComment($comment);
		}
	}
	echo "</div>";
	echo "<br>";
	echo "<br>";
}

function showComment($comment)
{
	echo "<div class='commentbox'>";

	echo "<div class=header><table width='100%' border=0 cellspacing=0><tr><td width=28>";
	echo userImage($comment->author, 32);
	echo "</td><td class='commentinfo'>";

	echo $comment->author->name;
	echo "<p class=subheader>".datetoa($comment->created)."</p>";
	echo "</td><td nowrap width=64>";

	$b = controller()->rbac->objectUrl($comment->object, 'comment', 'update');
	if($b || controller()->rbac->globalTeacher() || controller()->rbac->globalAdmin())
	{
		$command = controller()->rbac->commandfromurl('comment', 'update');
		echo l($command->image,
			array($command->url, 'id'=>$comment->id),
			array('title'=>$command->name, 'width'=>24)).'&nbsp;&nbsp;';
	}

	$b = controller()->rbac->objectUrl($comment->object, 'comment', 'delete');
	if($b || controller()->rbac->globalTeacher() || controller()->rbac->globalAdmin())
	{
		$command = controller()->rbac->commandfromurl('comment', 'delete');
		echo l($command->image, '#',
			array('id'=>"delete_comment_$comment->id", 'title'=>$command->name,'width'=>'24')).'&nbsp;&nbsp;';

		echo <<<END
<script>$(function(){ $('#delete_comment_$comment->id').click(function(){
	if(confirm("Are you sure you want to delete this comment?"))
		jQuery.yii.submitForm(this, "/$command->url&id=$comment->id",{});
	return false;});});</script>
END;
	}

	echo "</td></tr></table></div><!-- header -->";

	echo "<div class='content'>";
	echo processDoctext($comment->object, $comment->doctext);
	echo "</div><!-- content -->";

	echo "</div><!-- ssbox -->";
}

function showObjectFooter($object)
{
	if($object->authorid && $object->author)
		$username = $object->author->name;
	else
		$username = 'System';

	echo "<br><p class=smallprint>Created by $username, ".datetoa($object->created);
	if($object->created != $object->updated)
		echo ", last updated ".datetoa($object->updated);

	echo ".</p>";
}

///////////////////////////////////////////////////////////////

function showSubfolders($object)
{
	if(!param('subitemcount')) return;
	if($object->name == CMDB_PERSONALFOLDERNAME) return;

	$sort = getparam('sort');
	if(empty($sort)) $sort='displayorder';

	if($object->type == CMDB_OBJECTTYPE_LINK)
		$object = $object->link;
	
// 	$objects = getdbolist('Object', "parentid={$object->id} and not deleted and not hidden and type!=".
// 		CMDB_OBJECTTYPE_FILE." order by $sort");
// 	if(!$objects) return;
	$objects = objectContentList($object);
	
	echo "<p>";
	$n = 0;
	foreach($objects as $subitem)
	{
//		if($subitem->recordings) continue;
		$subitem = filterRecordingName($subitem);
		
	//	if(!controller()->rbac->objectAction($subitem))
	//		continue;

		if($n != 0) echo " &#9679; ";
		if($n >= param('subitemcount'))
		{
			echo l("[more...]", objectUrl($object));
			break;
		}

		$n++;
		echo l(h(substr($subitem->name, 0, 30)), array('object/', 'id'=>$subitem->id));
	}

	echo "</p>";
}

function showPreviousNext($object, $action='show')
{
	return;

	$urlfunc = objectUrl;
	if($action == 'update')
		$urlfunc = objectUrlUpdate;

	$previous = null;
	$next = null;

	$found = false;

	$objects = getdbolist('Object',
		"parentid={$object->parentid} and not deleted and not hidden order by displayorder, name");
	if($objects) foreach($objects as $object2)
	{
		if($object->id == $object2->id)
		{
			$found = true;
			continue;
		}

		if(controller()->rbac->objectUrl($object2, 'object', $action))
		{
			if($found)
			{
				$next = $object2;
				break;
			}

			else
				$previous = $object2;
		}
	}

	echo '<br><table width="100%"><tr>';

	if($previous)
		echo '<td>'.l(mainimg('16x16_2leftarrow.png').' '.
			objectImage($previous, 18).' '.
			h($previous->name), $urlfunc($previous), array('title'=>'Previous')).'</td>';

	if(!$next)
	{
		if(controller()->rbac->objectUrl($object->parent, 'object', $action))
			$next = $object->parent;
	}

	if($next)
		echo '<td align=right>'.l(mainimg('16x16_2rightarrow.png').' '.
			objectImage($next, 18).' '.
			h($next->name), $urlfunc($next), array('title'=>'Next')).'</td>';

	echo '</tr></table><br>';
}




