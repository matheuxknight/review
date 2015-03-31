<?php
$this->pageTitle = app()->name .' - '. $file->name;

if(	$file->filetype == CMDB_FILETYPE_MEDIA || 
	$file->filetype == CMDB_FILETYPE_BOOKMARKS ||
	$file->filetype == CMDB_FILETYPE_SRT)
	echo "<table width='100%'><tr><td valign='top'>";

showRoleBar($file);
showNavigationBar($file->parent);
showObjectHeader($file);
showObjectMenu($file->object);

showFileContent($file);

echo processDoctext($file, $file->ext->doctext);
showFolderContents($file->id);

showObjectFooter($file);
showPreviousNext($file);
showObjectComments($file);

if(	$file->filetype == CMDB_FILETYPE_MEDIA || 
	$file->filetype == CMDB_FILETYPE_BOOKMARKS ||
	$file->filetype == CMDB_FILETYPE_SRT)
{
	echo "</td><td width='10px'></td><td valign='top' width='240px'><br>";
//	showFileInfo($file);

	showFileInfoMyRecordings($file);
	showFileInfoStudentRecordings($file);
	
	if($file->parent->authorid != userid())
	{
		showFileInfoSameFolderAttached($file);
	
		$record = getdbo('VFile', getparam('recordid'));
		if($record)
			showFileInfoSameFolderAttached($record);
	}
	
	showFileInfoSameFolder($file);
	echo "</td></tr></table>";
}

