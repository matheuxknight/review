<?php

$connect = getPlayerConnect();
$flashvars =
	"&headercolor=".preg_replace('/#/', '0x', param('appheadercolor')).
	"&headerback=".preg_replace('/#/', '0x', param('appheaderback')).
	"&maincolor=".preg_replace('/#/', '0x', param('appmaincolor')).
	"&mainback=".preg_replace('/#/', '0x', param('appmainback')).
	"&mainalpha=".preg_replace('/#/', '0x', param('appmainalpha')).
	"&slidercolor=".preg_replace('/#/', '0x', param('appslidercolor')).
	"&phpsessid=".session_id().
	"&autosave=".param('appautosave').
	"&servername=".$_SERVER['HTTP_HOST'].
	"&connect=".getPlayerConnect().
	"&connectrtmpt=".getPlayerConnectRtmpt().
	"&connecthttp=".getFullServerName()."&id=";

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($object);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openCtrlHolder();
//echo "<table class='dataGrid' cellspacing=0 width='100%'><tr>";

echo <<<END
<script>
$(function()
{
	$('#maintable tbody').sortable(
	{
		delay: 300,
		update: function(event, ui)
		{
			var id = ui.item.attr('id').substr(10);
			$(this).children().each(function(i)
			{
				var id2 = $(this).attr('id').substr(10);
				if(id == id2)
				{
				//	$.ajax("/quiz/setorder&id="+id+"&order="+i);
					window.location = "/flashcard/setorder&id=" + id + "&order=" + i;
				}
			});
		}
	}).disableSelection();
});
</script>
END;

showTableSorter('maintable');
echo "<thead class='ui-widget-header'><tr>";

echo "<th>Question</th>";
echo "<th>Answers</th>";
// echo "<th>File</th>";
// echo "<th width=50>Start</th>";
// echo "<th width=50>End</th>";

echo "<th></th>";
echo "</tr></thead><tbody>";

$flashcards = getdbolist('Flashcard', "objectid=$object->id order by displayorder");

if(!count($flashcards))
	echo "<tr><td colspan=6><i>-none-</i></td></tr>";

else foreach($flashcards as $flashcard)
{
	$startpos1 = sectoa($flashcard->startpos1);
	$duration1 = sectoa($flashcard->duration1);
	
	$startpos2 = sectoa($flashcard->startpos2);
	$duration2 = sectoa($flashcard->duration2);
	
	$img1 = $flashcard->fileid1? objectImage($flashcard->file1, 16): '';
	$img2 = $flashcard->fileid2? objectImage($flashcard->file2, 16): '';
	
	echo "<tr id='flashcard_$flashcard->id' class='ssrow' onclick='load_flash_item($flashcard->id)'>";
	
	echo CUFHtml::hiddenField("Flashcard_{$flashcard->id}_value1", $flashcard->value1);
	echo CUFHtml::hiddenField("Flashcard_{$flashcard->id}_fileid1", $flashcard->fileid1);
	echo CUFHtml::hiddenField("Flashcard_{$flashcard->id}_startpos1", $flashcard->startpos1);
	echo CUFHtml::hiddenField("Flashcard_{$flashcard->id}_duration1", $flashcard->duration1);
	echo CUFHtml::hiddenField("Flashcard_{$flashcard->id}_value2", $flashcard->value2);
	echo CUFHtml::hiddenField("Flashcard_{$flashcard->id}_fileid2", $flashcard->fileid2);
	echo CUFHtml::hiddenField("Flashcard_{$flashcard->id}_startpos2", $flashcard->startpos2);
	echo CUFHtml::hiddenField("Flashcard_{$flashcard->id}_duration2", $flashcard->duration2);
	
	echo "<td>$flashcard->value1";

 	if($flashcard->file1 && $flashcard->file1->filetype == CMDB_FILETYPE_MEDIA)
 		echo "<a href='javascript:flashcardOsrPlayer(1, $flashcard->id, $flashcard->fileid1, $flashcard->startpos1, $flashcard->duration1)'>
 			$img1 {$flashcard->file1->name}</a> (at $startpos1 for $duration1)";
 	
 	else if($flashcard->file1)
 		echo "$img1 {$flashcard->file1->name}";
 	
 	echo "</td>";
 	
 	echo "<td>$flashcard->value2";
 	
 	if($flashcard->file2 && $flashcard->file2->filetype == CMDB_FILETYPE_MEDIA)
 		echo "<a href='javascript:flashcardOsrPlayer(2, $flashcard->id, $flashcard->fileid2, $flashcard->startpos2, $flashcard->duration2)'>
 		$img2 {$flashcard->file2->name}</a> (at $startpos2 for $duration2)";
 	
 	else if($flashcard->file2)
 		echo "$img2 {$flashcard->file2->name}";
 	
 	echo "</td>";
 	
	echo "<td>";
	echo l(mainimg('16x16_delete.png'), array('delete', 'id'=>$flashcard->id), array('title'=>'Delete this flashcard'));
	echo "</td>";
	
	echo "</tr>";
}

$flashcard = new Flashcard;
$flashcard->startpos1 = 0;
$flashcard->duration1 = 0;
$flashcard->startpos2 = 0;
$flashcard->duration2 = 0;

echo "<tr><td colspan=6><br><b><span id='add_new_message'>add new</span></b></td></tr>";
echo "<tr>";

echo "<td>".CUFHtml::activeTextField($flashcard, 'value1')."</td>";
echo showAttributeEditor($flashcard, 'value1', 80, 'custom4');

echo "<td>".CUFHtml::activeTextField($flashcard, 'value2')."</td>";
echo showAttributeEditor($flashcard, 'value2', 80, 'custom4');

echo "<td valign=top>";

showObjectBrowserButton($object, 'false', 'true', 'Flashcard_fileid1', 'flashcard1', 'flashcardFileSelectedNew1');
echo " <span id='mediafilename_flashcard1'></span><br>";

showObjectBrowserButton($object, 'false', 'true', 'Flashcard_fileid2', 'flashcard2', 'flashcardFileSelectedNew2');
echo " <span id='mediafilename_flashcard2'></span>";

echo "</td>";

echo "<td colspan=3></td>";

echo CUFHtml::activeHiddenField($flashcard, 'id');
echo CUFHtml::activeHiddenField($flashcard, 'startpos1');
echo CUFHtml::activeHiddenField($flashcard, 'duration1');
echo CUFHtml::activeHiddenField($flashcard, 'startpos2');
echo CUFHtml::activeHiddenField($flashcard, 'duration2');
echo CUFHtml::activeHiddenField($flashcard, 'fileid1');
echo CUFHtml::activeHiddenField($flashcard, 'fileid2');
echo CUFHtml::activeHiddenField($object, 'id');

echo "</tr>";
echo "<tbody></table>";

echo CUFHtml::closeCtrlHolder();


echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();


echo <<<END
<script>

$(function()
{
	$('#Flashcard_id').val(0);
//	alert($('#Flashcard_id').val());

	$('#Flashcard_value1').focus().val('');
	$('#Flashcard_value2').val('');
	
	$('#Flashcard_startpos1').val('');
	$('#Flashcard_startpos1').val('');
	
	$('#Flashcard_duration1').val('');
	$('#Flashcard_duration2').val('');
});

function load_flash_item(id)
{
	$('#Flashcard_id').val(id);
	$('#Flashcard_fileid1').val($('#Flashcard_'+id+'_fileid1').val());
	$('#Flashcard_startpos1').val($('#Flashcard_'+id+'_startpos1').val());
	$('#Flashcard_duration1').val($('#Flashcard_'+id+'_duration1').val());
	$('#Flashcard_fileid2').val($('#Flashcard_'+id+'_fileid2').val());
	$('#Flashcard_startpos2').val($('#Flashcard_'+id+'_startpos2').val());
	$('#Flashcard_duration2').val($('#Flashcard_'+id+'_duration2').val());
	
	var tmp = $('#Flashcard_'+id+'_value1').val();
	if(tmp == '') tmp = ' ';
	$('#Flashcard_value1').elrte('val', tmp);
	
	var tmp = $('#Flashcard_'+id+'_value2').val();
	if(tmp == '') tmp = ' ';
	$('#Flashcard_value2').elrte('val', tmp);
	
	$('#add_new_message').html('modify');
}

function flashcardOsrPlayer(index, id, fileid, startpos, duration)
{
	$('#Flashcard_startpos'+index).val(startpos);
	$('#Flashcard_duration'+index).val(duration);

	$("#flashcard-dialog").dialog(
	{
    	autoOpen: true,
		width: 640, 
		height: 480, 
		modal: true,
		title: 'filename',

		buttons:
		{
			"Save": function()
			{
				startpos = $('#Flashcard_startpos'+index).val();
				duration = $('#Flashcard_duration'+index).val();
				
				window.location.href = '/flashcard/save?id='+id+'&index='+index+'&startpos='+startpos+'&duration='+duration;
			},

			"Cancel": function(){ $(this).dialog("close");}
		}
	});

	$('#objectrangeselectortemplate_flashcard').html("<div id='objectrangeselectorflash_flashcard"+index+"'></div>");

	var params = {};
	params.allowscriptaccess = "sameDomain";
	params.allowfullscreen = "false";
	params.wmode = "opaque";
	var attributes = {};
	attributes.id = "sansors";
	attributes.name = "sansors";
	attributes.align = "middle";

	var flashvars = "$flashvars"+fileid+
		"&savecallback=flashcardSavePosition"+index+
		"&startpos="+startpos+"&duration="+duration;

	swfobject.embedSWF(
		"/extensions/players/sansors.swf", "objectrangeselectorflash_flashcard"+index,
		"100%", "360", "11.1.0", "playerProductInstall.swf",
		flashvars, params, attributes);
}

////////////////////////////////////////////////////////////////////////

function flashcardFileSelectedNew1(selectedid, selectedname)
{
	if(!selectedid) return;

	$('#mediafilename_flashcard1').html(selectedname);
	$('#Flashcard_fileid1').val(selectedid);
		
	flashcardOsrPlayerNew(1);
}

function flashcardFileSelectedNew2(selectedid, selectedname)
{
	if(!selectedid) return;

	$('#mediafilename_flashcard2').html(selectedname);
	$('#Flashcard_fileid2').val(selectedid);
		
	flashcardOsrPlayerNew(2);
}

function flashcardOsrPlayerNew(index)
{
	var filename = $('#mediafilename_flashcard'+index).html();
	$("#flashcard-dialog").dialog(
	{
    	autoOpen: true,
		width: 640, 
		height: 480, 
		modal: true,
		title: filename,

		buttons:
		{
			"Ok": function() { $(this).dialog("close");},
		}
	});
		
	$('#objectrangeselectortemplate_flashcard').html("<div id='objectrangeselectorflash_flashcard"+index+"'></div>");
	var fileid = $('#Flashcard_fileid'+index).val();

	var params = {};
	params.allowscriptaccess = "sameDomain";
	params.allowfullscreen = "false";
	params.wmode = "opaque";
	var attributes = {};
	attributes.id = "sansors";
	attributes.name = "sansors";
	attributes.align = "middle";

	var flashvars = "$flashvars"+fileid+
		"&savecallback=flashcardSavePosition"+index+
		"&startpos="+$('#Flashcard_startpos'+index).val()+
		"&duration="+$('#Flashcard_duration'+index).val();

	swfobject.embedSWF(
		"/extensions/players/sansors.swf", "objectrangeselectorflash_flashcard"+index,
		"100%", "380", "11.1.0", "playerProductInstall.swf",
		flashvars, params, attributes);
}

function flashcardSavePosition1(startpos, duration)
{
	$('#Flashcard_startpos1').val(startpos);
	$('#Flashcard_duration1').val(duration);
}

function flashcardSavePosition2(startpos, duration)
{
	$('#Flashcard_startpos2').val(startpos);
	$('#Flashcard_duration2').val(duration);
}

</script>

<div id="flashcard-dialog" style='display: none;'>
<div id='objectrangeselectortemplate_flashcard'></div>
</div>

END;






