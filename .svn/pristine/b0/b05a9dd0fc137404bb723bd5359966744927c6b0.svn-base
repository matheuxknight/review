<?php
$this->pageTitle = app()->name ." - {$object->name}";

if($object->type == CMDB_OBJECTTYPE_LINK && $object->link->type == CMDB_OBJECTTYPE_FILE)
{
	if($object->link->file->filetype == CMDB_FILETYPE_MEDIA ||
		$object->link->file->filetype == CMDB_FILETYPE_BOOKMARKS ||
		$object->link->file->filetype == CMDB_FILETYPE_SRT)
	echo "<table width='100%'><tr><td valign='top'>";
}

showRoleBar($object);
showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

echo processDoctext($object, $object->ext->doctext);

if($object->type == CMDB_OBJECTTYPE_LINK)
{
	switch($object->link->type)
	{
		case CMDB_OBJECTTYPE_FILE:
			showFileContent($object->link->file);
			break;
			
		default:
			showFolderContents($object->link->id);
	}
}

else
	showFolderContents($object->id);
	
showObjectFooter($object);
showPreviousNext($object);
showObjectComments($object);

if($object->type == CMDB_OBJECTTYPE_LINK && $object->link->type == CMDB_OBJECTTYPE_FILE)
{
	if($object->link->file->filetype == CMDB_FILETYPE_MEDIA ||
			$object->link->file->filetype == CMDB_FILETYPE_BOOKMARKS ||
			$object->link->file->filetype == CMDB_FILETYPE_SRT)
	{
		echo "</td><td width='10px'></td><td valign='top' width='240px'><br>";
	//	showFileInfo($file);
		
		showFileInfoMyRecordings($object->link->file);
		showFileInfoStudentRecordings($object->link->file);
		
		if($file->parent->authorid != userid())
		{
			showFileInfoSameFolderAttached($object->link->file);
		
			$record = getdbo('VFile', getparam('recordid'));
			if($record)
				showFileInfoSameFolderAttached($record);
		}
		
		showFileInfoSameFolder($object->link->file);
		echo "</td></tr></table>";
	}
}

user()->setState('currentobject', $object->id);
user()->setState('currentversion', $object->version);

JavascriptReady("window.onbeforeunload = function(){
	$.ajax({url: '/object/leavepage?id=$object->id', async: false});}");



