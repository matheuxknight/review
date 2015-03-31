<?php

function objectShowPropertiesTranscode($object)
{
	echo "<div id='properties-transcode'>";

	echo "<table width='100%' class='dataGrid'>";
	echo "<tr>";
	echo "<th>Template</th>";
	echo "<th>Default</th>";
	echo "<th>Audio</th>";
	echo "<th>Video</th>";
	echo "<th>Scheduled</th>";
	echo "<th></th>";
	echo "</tr>";

	$totalaudio = 0;
	$totalvideo = 0;
	$totalscheduled = 0;

	$filelist = getdbolist('VFile', "filetype = ".CMDB_FILETYPE_MEDIA." and parentlist like '%, {$object->id}, %'");
	$templatelist = getdbolist('TranscodeTemplate', "enable order by videodimension desc, name");

	foreach($templatelist as $template)
	{
		echo "<tr class='ssrow'>";
		echo "<td><b>$template->name</b></td>";
		echo "<td>".Booltoa($template->active)."</td>";

		$audiocount = dboscalar(
			"select count(*) from TranscodeObject where templateid=$template->id ".
			"and status=".CMDB_OBJECTTRANSCODE_COMPLETE." and fileid in (select id from VFile where filetype = ".
			CMDB_FILETYPE_MEDIA." and not hasvideo and parentlist like '%, {$object->id}, %')");

		$videocount = dboscalar(
			"select count(*) from TranscodeObject where templateid=$template->id ".
			"and status=".CMDB_OBJECTTRANSCODE_COMPLETE." and fileid in (select id from VFile where filetype = ".
			CMDB_FILETYPE_MEDIA." and hasvideo and parentlist like '%, {$object->id}, %')");

		$scheduledcount = dboscalar(
			"select count(*) from TranscodeObject where templateid=$template->id and ".
			" (status=".CMDB_OBJECTTRANSCODE_CURRENT.
			" or status=".CMDB_OBJECTTRANSCODE_QUEUED.
			" or status=".CMDB_OBJECTTRANSCODE_QUEUED2.
			" or status=".CMDB_OBJECTTRANSCODE_QUEUED3.") and ".
			"fileid in (select id from VFile where filetype = ".
			CMDB_FILETYPE_MEDIA." and parentlist like '%, {$object->id}, %')");

		echo "<td>$audiocount</td>";
		echo "<td>$videocount</td>";
		echo "<td>$scheduledcount</td>";

		echo "<td>";

		echo CHtml::linkButton("Create Audio",
			array('submit'=>array('transcode/queueaudio',
				'objectid'=>$object->id, 'id'=>$template->id),
				'confirm'=>'Are you sure you want to queue all audios for transcoding?'))." ";

		echo ' - ';
		echo CHtml::linkButton("Delete Audio",
			array('submit'=>array('transcode/deleteaudio',
				'objectid'=>$object->id, 'id'=>$template->id),
				'confirm'=>'Are you sure you want to delete audio transcoded files?'))." ";
	
		echo ' - ';
		echo CHtml::linkButton("Create Video",
			array('submit'=>array('transcode/queuevideo',
				'objectid'=>$object->id, 'id'=>$template->id),
				'confirm'=>'Are you sure you want to queue all videos for transcoding?'))." ";
	
		echo ' - ';
		echo CHtml::linkButton("Delete Video",
			array('submit'=>array('transcode/deletevideo',
				'objectid'=>$object->id, 'id'=>$template->id),
				'confirm'=>'Are you sure you want to delete video transcoded files?'))." ";
	
		if(controller()->rbac->globalAdmin())
		{
			echo ' - ';
			echo l("Template", array('transcode/update', 'id'=>$template->id))." ";
		}
	
		echo "</td>";
		echo "</tr>";
	}
	
	echo "<tr>";
	echo "<td>total</td>";
	echo "<td></td>";

	$totalaudio = dboscalar(
		"select count(*) from TranscodeObject where ".
		"status=".CMDB_OBJECTTRANSCODE_COMPLETE." and fileid in (select id from VFile where filetype = ".
		CMDB_FILETYPE_MEDIA." and not hasvideo and parentlist like '%, {$object->id}, %')");

	$totalvideo = dboscalar(
		"select count(*) from TranscodeObject where ".
		"status=".CMDB_OBJECTTRANSCODE_COMPLETE." and fileid in (select id from VFile where filetype = ".
		CMDB_FILETYPE_MEDIA." and hasvideo and parentlist like '%, {$object->id}, %')");

	$totalscheduled = dboscalar(
		"select count(*) from TranscodeObject where ".
		" (status=".CMDB_OBJECTTRANSCODE_CURRENT.
		" or status=".CMDB_OBJECTTRANSCODE_QUEUED.
		" or status=".CMDB_OBJECTTRANSCODE_QUEUED2.
		" or status=".CMDB_OBJECTTRANSCODE_QUEUED3.") and ".
		"fileid in (select id from VFile where filetype = ".
		CMDB_FILETYPE_MEDIA." and parentlist like '%, {$object->id}, %')");

	echo "<td>$totalaudio</td>";
	echo "<td>$totalvideo</td>";
	echo "<td>$totalscheduled</td>";

	$totalfiles = dboscalar("select count(*) from VFile where filetype=".
		CMDB_FILETYPE_MEDIA." and parentlist like '%, {$object->id}, %'");

	$totalaudios = dboscalar("select count(*) from VFile where filetype=".
		CMDB_FILETYPE_MEDIA." and not hasvideo and parentlist like '%, {$object->id}, %'");

	$totalvideos = dboscalar("select count(*) from VFile where filetype=".
		CMDB_FILETYPE_MEDIA." and hasvideo and parentlist like '%, {$object->id}, %'");

	echo "<td><b>$totalfiles media files, $totalaudios audios, $totalvideos videos.</b></td>";
	echo "</tr>";

	echo "</table><br>";
	

	echo "<br><br>";
	showButtonHeader();

	echo CHtml::linkButton("Cancel All",
	array('submit'=>array('transcode/cancelallobject',
	'objectid'=>$object->id),
	'confirm'=>'Are you sure you want to cancel all queued transcodings?'))." ";

	echo CHtml::linkButton("Delete All",
	array('submit'=>array('transcode/deleteallobject',
		'objectid'=>$object->id),
		'confirm'=>'Are you sure you want to delete all transcodings?'))." ";

	echo CHtml::linkButton("Delete Natives",
	array('submit'=>array('transcode/deleteallnative',
		'objectid'=>$object->id),
		'confirm'=>'Are you sure you want to delete all transcodings that have a native original?'))." ";
	
	echo "</div>";
	echo "<br></div>";
	
}



