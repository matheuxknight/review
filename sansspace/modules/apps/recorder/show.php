<?php

if(!isset($_SERVER['HTTP_REFERER']) && IsMobileDevice()) return '';

$parentid = getparam('parentid');
$masterid = getparam('masterid');
$recordid = getparam('recordid');

echo "<table width='100%'><tr><td valign='top'>";

if($recordid)
{
	$file = getdbo('VFile', $recordid);
	$this->pageTitle = app()->name .' - '. $file->name;
	
	showRoleBar($file);
	showNavigationBar($file->parent);
	showObjectHeader($file);
	showObjectMenu($file->object);
}

else if($parentid)
{
	$parent = getdbo('Object', $parentid);
	$this->pageTitle = app()->name .' - '. $parent->name;
	
	showRoleBar($parent);
	showNavigationBar($parent->parent);
	showObjectHeader($parent);
	showObjectMenu($parent);
}

else echo "<br>";

////////////////////////////////////////////////////////////////////////////

$flashvars = "masterid=$masterid&recordid=$recordid&parentid=$parentid";

ShowApplication($flashvars, 'recorder', 'sansmediad', 320);
//JavascriptReady("RightClick.init('$name');");

if($recordid)
{
	$file = getdbo('VFile', $recordid);
	
	showObjectFooter($file);
	showObjectComments($file);
}

else if($parentid)
{
	$parent = getdbo('Object', $parentid);
	
	showObjectFooter($parent);
	showObjectComments($parent);
}

else echo "<br>";

////////////////////////////////////////////////////////////////////////////

echo "</td><td width='10px'></td><td valign='top' width='240px'>";

showAllDropBoxRecordings();
echo "</td></tr></table>";



