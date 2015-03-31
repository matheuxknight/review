<?php

echo "<br>";
showPmHeader($page);

echo "<table border=0 cellspacing=2 cellpadding=0>";
echo "<tr><td width=80>Sent On:</td><td>{$pm->senttime}</td></tr>";
echo "<tr><td>From:</td><td><b>{$pm->author->name}</b></td></tr>";

if($pm->togroup)
	echo "<tr><td>To:</td><td><b>{$pm->togroup->name}</b></td></tr>";
else
	echo "<tr><td>To:</td><td><b>{$pm->touser->name}</b></td></tr>";
	
echo "<tr><td>Subject:</td><td><b>{$pm->name}</b></td></tr>";
echo "</table>";

echo "<hr>";
echo "<table border=0 cellspacing=2 cellpadding=0>";
echo "<tr><td>$pm->doctext</td></tr>";

echo "<tr><td><br><br><br><br><br></td></tr>";
echo "<tr><td>";

if(!$pm->togroupid || $pm->authorid == userid())
{
	showButtonHeader();
	
	if($page == 'Inbox')
		showButton('Reply', array('reply', 'id'=>$pm->id));
		
	showButton('Forward', array('forward', 'id'=>$pm->id));
	showButtonPost('Delete Message', array('submit'=>array('delete', 'id'=>$pm->id, 'page'=>$page),
		'confirm'=>'Are you sure you want to delete this message?'));
	echo "</div>";
}

echo "</td></tr>";
echo "</table>";

showPmFooter();










