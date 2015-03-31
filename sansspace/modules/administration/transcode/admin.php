<?php

showAdminHeader(3);
echo "<h2>Manage Transcodings</h2>";

$list = getdbolist('TranscodeTemplate', "1 order by videodimension desc, name");

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Templates</a></li>";
echo "<li><a href='#tabs-4'>Settings</a></li>";
echo "<li><a href='#tabs-2'>Scheduled</a></li>";
echo "<li><a href='#tabs-3'>Error</a></li>";
echo "</ul><br>";

//////////////////////////////////////////////////////////

echo "<div id='tabs-1'>";

showButtonHeader();
showButton('New Template', array('create'));
//showButton('Refresh', array('admin'));

echo "</div>";
echo "<br>";

//echo <<<END
//<script>
//$(function(){
//	$('#maintable1 tbody').sortable(
//	{
//		delay: 300,
//		update: function(event, ui)
//		{
//			var id = ui.item.attr('id').substr(9);
//			$(this).children().each(function(i)
//			{
//				var id2 = $(this).attr('id').substr(9);
//				if(id == id2)
//					$.get("/transcode/setorder&id="+id+"&order="+i);
//			});
//		}
//	}).disableSelection();});
//</script>
//END;

showTableSorter('maintable1', '{headers: {7: {sorter: false}}}');
//echo "<table width='100%' class='dataGrid2'>";
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Name</th>";
echo "<th>Default</th>";
echo "<th>Enable</th>";

echo "<th>Audio</th>";
echo "<th width='40%'>Video</th>";
echo "<th>Scheduled</th>";
echo "<th>Ready</th>";
echo "<th>Error</th>";

echo "<th></th>";
echo "</tr></thead><tbody>";

$totalscheduled = 0;
$totalcomplete = 0;
$totalerror = 0;

foreach($list as $n=>$model)
{
	echo "<tr id='template_$model->id'>";
	echo "<td style='font-weight: bold;'>".l(h($model->name), array('update', 'id'=>$model->id))."</td>";
	echo "<td>".Booltoa($model->active)."</td>";
	echo "<td>".Booltoa($model->enable)."</td>";

	echo "<td>$model->audiocodec";
	if(!empty($model->audiobitrate))
		echo ", $model->audiobitrate";
	echo "</td>";
	
	echo "<td>$model->videocodec";
	if(!empty($model->videobitrate))
		echo ", $model->videobitrate";
	if(!empty($model->videodimension))
		echo ", $model->videodimension lines";
	if(!empty($model->params))
		echo ", $model->params";
	echo "</td>";
		
	$countqueued = getdbocount('TranscodeObject', "templateid=$model->id and ".
		'status='.CMDB_OBJECTTRANSCODE_QUEUED.
		' or status='.CMDB_OBJECTTRANSCODE_QUEUED2);

	$countcomplete = getdbocount('TranscodeObject', "templateid=$model->id and ".
		'status='.CMDB_OBJECTTRANSCODE_COMPLETE);
	
	$counterror = getdbocount('TranscodeObject', "templateid=$model->id and ".
		'status='.CMDB_OBJECTTRANSCODE_ERROR);
	
	echo "<td>$countqueued</td>";
	echo "<td>$countcomplete</td>";
	echo "<td>$counterror</td>";
	
	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
		'submit'=>'',
		'params'=>array('command'=>'delete','id'=>$model->id),
		'confirm'=>"Are you sure to delete #{$model->id}?"));
	echo "</td>";
	echo "</tr>";

	$totalscheduled += $countqueued;
	$totalcomplete += $countcomplete;
	$totalerror += $counterror;
}

echo"</tbody>";

echo "<tr>";
echo "<td>Total:</td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td>$totalscheduled</td>";
echo "<td>$totalcomplete</td>";
echo "<td>$totalerror</td>";
echo "<td></td>";
echo "</tr>";

echo"</table>";
echo"<br/>";

echo "</div>";

//////////////////////////////////////////////////////////////

echo "<div id='tabs-4'>";

echo "<p>Common settings used by respective templates.</p>";

$transcodeparams = getdbosql('TranscodeParams', "1");
if(!$transcodeparams)
{
	$transcodeparams = new TranscodeParams;
	$transcodeparams->h263params = '';
	$transcodeparams->h264params = '';
	$transcodeparams->save();
}

$this->widget('UniForm');
echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($transcodeparams);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($transcodeparams, 'h263params');
echo CUFHtml::activeLabelEx($transcodeparams, 'h263params');
echo CUFHtml::activeTextField($transcodeparams, 'h263params', array('maxlength'=>200));
echo "<p class='formHint2'>q:v parameter varies from 0 (lossless) to 31 (poor).</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($transcodeparams, 'h264params');
echo CUFHtml::activeLabelEx($transcodeparams, 'h264params');
echo CUFHtml::activeTextField($transcodeparams, 'h264params', array('maxlength'=>200));
echo "<p class='formHint2'>crf parameter varies from 0 (lossless) to 51 (poor).</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();

echo"<br/>";
echo "</div>";

//////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";

showButtonHeader();
echo CHtml::linkButton("Cancel All",
		array('submit'=>array('transcode/cancelall'),
				'confirm'=>'Are you sure you want to cancel all queued transcodings?'));
echo "</div>";
echo "<br>";

showTableSorter('maintable3');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>File</th>";
echo "<th>Folder</th>";
echo "<th>Duration</th>";
echo "<th>Size</th>";
echo "<th>Codec</th>";
echo "<th>Template</th>";
echo "<th>Status</th>";
echo "</tr></thead><tbody>";

showTranscodedStatus(CMDB_OBJECTTRANSCODE_CURRENT);
showTranscodedStatus(CMDB_OBJECTTRANSCODE_QUEUED3);
showTranscodedStatus(CMDB_OBJECTTRANSCODE_QUEUED2);
showTranscodedStatus(CMDB_OBJECTTRANSCODE_QUEUED);

echo"<tbody></table>";
echo"<br/>";

echo "</div>";

//////////////////////////////////////////////////////////////

echo "<div id='tabs-3'>";

showButtonHeader();
echo CHtml::linkButton("Clean Errors", 
	array('submit'=>array('transcode/cleanerrors'),
	'confirm'=>'Are you sure you want to clean all errors?'));
echo "</div>";
echo "<br>";

showTableSorter('maintable3');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>File</th>";
echo "<th>Folder</th>";
echo "<th>Duration</th>";
echo "<th>Size</th>";
echo "<th>Codec</th>";
echo "<th>Template</th>";
echo "<th>Status</th>";
echo "</tr></thead><tbody>";

showTranscodedStatus(CMDB_OBJECTTRANSCODE_ERROR);

echo"<tbody></table>";
echo"<br/>";

echo "</div>";

//////////////////////////////////////////////////////////////////////////////

function showTranscodedStatus($status)
{
	$tos = getdbolist('TranscodeObject', "status=$status limit 100");
	foreach($tos as $to)
	{
		$file = getdbo('VFile', $to->fileid);
		$template = getdbo('TranscodeTemplate', $to->templateid);
		
		echo "<tr class='ssrow'>";
		echo "<td>".objectImage($file, 18).' '.l($file->name, objectUrlUpdate($file))."</td>";
		echo "<td>".l($file->parent->name, objectUrlUpdate($file->parent))."</td>";
		
		echo "<td>".objectDuration2a($file)."</td>";
		echo "<td>".Itoa($file->size)."</td>";
		
		echo "<td>".$file->audiocodec;
		if($file->hasaudio && $file->hasvideo) echo '/';
		echo $file->videocodec."</td>";
		
		echo "<td>$template->name</td>";
		echo "<td>$to->statusText</td>";
		echo "</tr>";
	}
}




