<?php

function fileShowPropertiesTags($file)
{
	if(empty($file->ext->mp3tags)) return;
	
$mp3taglist = array(
	'TALB'=>'Album',
	'TBPM'=>'BPM (beats per minute)',
	'TCOM'=>'Composer',
	'TCON'=>'Type',
	'TCOP'=>'Copyright',
	'TDAT'=>'Date',
	'TDLY'=>'Playlist delay',
	'TENC'=>'Encoder',
	'TEXT'=>'Text writer',
	'TFLT'=>'File type',
	'TIME'=>'Time',
	'TIT1'=>'Content',
	'TIT2'=>'Title',
	'TIT3'=>'Subtitle',
	'TKEY'=>'Initial key',
	'TLAN'=>'Language(s)',
	'TLEN'=>'Length',
	'TMED'=>'Media type',
	'TOAL'=>'Original album title',
	'TOFN'=>'Original filename',
	'TOLY'=>'Original lyricist(s)',
	'TOPE'=>'Original artist(s)',
	'TORY'=>'Original release year',
	'TOWN'=>'Owner',
	'TPE1'=>'Creator',
	'TPE2'=>'Group',
	'TPE3'=>'Conductor',
	'TPE4'=>'Interpreted by',
	'TPOS'=>'Part of a set',
	'TPUB'=>'Publisher',
	'TRCK'=>'Track',
	'TRDA'=>'Recording dates',
	'TRSN'=>'Internet radio station name',
	'TRSO'=>'Internet radio station owner',
	'TSIZ'=>'Size',
	'TSRC'=>'ISRC (international standard recording code)',
	'TSSE'=>'Software/Hardware and settings used for encoding',
	'TYER'=>'Year',

	'TT1'=>'Group',
	'TT2'=>'Title',
	'TP1'=>'Creator',
	'TAL'=>'Album',
	'TRK'=>'Track',
	'TYE'=>'Year',
	'TCO'=>'Type',
	'TEN'=>'Encoder',
);

	echo "<div id='properties-filetags'>";
	echo "<p>These tags where extracted from this file:</p>";
	echo "<table><tr>";
	
	$text = explode(",", $file->ext->mp3tags);
	foreach($text as $item)
	{
		$item = trim($item);
		if(!empty($item))
		{
			echo "<tr class='ssrow'>";
			$item = explode('=', $item);
			
			$item[0] = trim($item[0]);
			$item[1] = trim($item[1]);
			
			if(isset($mp3taglist[$item[0]]))
				$item[0] = $mp3taglist[$item[0]];
			
			echo "<td>{$item[0]}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			echo "<td><b>{$item[1]}</b></td>";

			echo "</tr>";
		}
	}
	
	echo "</table>";
	echo "</div>";	
}

