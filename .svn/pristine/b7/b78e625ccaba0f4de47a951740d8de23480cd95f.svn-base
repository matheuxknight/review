<?php 

$fss = getdbolist('FileSession', "starttime > '2012-08-01' and starttime < '2012-10-10'");
foreach($fss as $fs)
{
	if($fs->duration > $fs->file->duration/1000)
	{
		$fs->duration = $fs->file->duration/1000;
		$fs->save();
	}
}
