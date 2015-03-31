<?php

function fileShowPropertiesTranscode($file)
{
	echo "<div id='properties-transcode'>";
	
	if(isMediaFormatSupported($file))
		echo "<p>This file can be played natively by SANSSpace. You do not need to transcode it.</p>";
	
	echo "<table width='100%' class='dataGrid'>";
	echo "<tr>";
	echo "<th>Template</th>";
	echo "<th>Default</th>";
	echo "<th>Bitrate</th>";
	echo "<th>Size</th>";
	echo "<th>Status</th>";
	echo "<th></th>";
	echo "<th></th>";
	echo "</tr>";
	
	echo "<tr class='ssrow'>";

	echo "<td><b>Original</b></td>";
	echo "<td></td>";
	echo "<td>".Itoa2($file->bitrate)."</td>";
	echo "<td>".Itoa2($file->size)."</td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "</tr>";
	
	$list = getdbolist('TranscodeTemplate', "enable order by videodimension desc, name");
	foreach($list as $template)
	{
		echo "<tr class='ssrow'>";
		echo "<td><b>".l($template->name, 
			array('file/', 'id'=>$file->id, 'templateid'=>$template->id))."</b></td>";
		
		echo "<td>".Booltoa($template->active)."</td>";
		
		$to = getdbosql('TranscodeObject', "fileid=$file->id and templateid=$template->id");
		if(!$to)
		{
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			
			echo "<td>".l("[Create]", 
				array('file/transcodecreate', 'id'=>$file->id, 'templateid'=>$template->id))."</td>";
		}
		else
		{
			echo "<td>".Itoa2($to->bitrate)."</td>";
			echo "<td>".Itoa($to->size)."</td>";

			echo "<td>$to->statusText</td>";
			
			switch($to->status)
			{
				case CMDB_OBJECTTRANSCODE_COMPLETE:
				case CMDB_OBJECTTRANSCODE_QUEUED:
				case CMDB_OBJECTTRANSCODE_QUEUED2:
					echo "<td>".CHtml::linkButton("[Delete]", 
						array('submit'=>array('file/transcodedelete', 
						'id'=>$file->id, 'templateid'=>$template->id),
						'confirm'=>'Are you sure you want to delete this transcode?'))."</td>";
						
					break;

				case CMDB_OBJECTTRANSCODE_CURRENT:
					echo "<td></td>";
					break;
					
				default:
					echo "<td>".l("[Create]", 
						array('file/transcodecreate', 'id'=>$file->id, 'templateid'=>$template->id))."</td>";
			}
		}
		
		if(controller()->rbac->globalAdmin())
		{
			echo "<td>".l("[Edit Template]", 
				array('transcode/update', 'id'=>$template->id)).'&nbsp;&nbsp;';
				
			if($to->status == CMDB_OBJECTTRANSCODE_COMPLETE)
				echo CHtml::linkButton("[Replace]", 
					array('submit'=>array('file/transcodereplace', 
					'id'=>$file->id, 'templateid'=>$template->id),
					'confirm'=>'Are you sure you want to replace the original file ('.
					Itoa($file->size).') with this transcode ('.Itoa($to->size).')? '.
					'Warning, the original file will be deleted.'));
			
			echo "</td>";
		}
			
		echo "</tr>";
	}

	echo "</table><br>";
	showButtonHeader();

	echo CHtml::linkButton("Cancel All", 
		array('submit'=>array('transcode/cancelallobject', 
		'objectid'=>$file->id),
		'confirm'=>'Are you sure you want to cancel all queued transcodings?'))." ";
		
	echo CHtml::linkButton("Delete All", 
		array('submit'=>array('transcode/deleteallobject', 
		'objectid'=>$file->id),
		'confirm'=>'Are you sure you want to delete all transcodings?'))." ";
		
	echo "</div>";
	echo "</div>";
}



