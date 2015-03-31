<?php

function showPmHeader($page)
{
	echo "<br>";
	echo "<div class='portlet'>";
	echo "<div class='headerleft'>$page</div>";
	echo "<div class='content'>";
	
	echo "<table width='100%' border=0 cellspacing=0 cellpadding=0>";
	echo "<tr><td width=100 valign=top>";
	
	showPmMenu($page);
	
	echo "</td><td valign=top>";
	echo "<div class='inner'>";
}

function showPmFooter()
{
	echo "</div>";
	echo "</td></tr>";
	echo "</table>";
	echo "</div>";
	echo "</div>";
}

//////////////////////////////////////////////////////////////////////

function showPmMenu($page)
{
	$menuitems = array(
		array('New Message', array('pm/create')),
		array('Draft', array('pm/draft')),
		array('Inbox', array('pm/inbox')),
		array('Outbox', array('pm/outbox')),
		array('Sent', array('pm/sent')),
	);

	$user = getUser();
	echo "<table width='100%' border=0 cellpadding=4 cellspacing=0>";
	
	foreach($menuitems as $item)
	{
		echo "<tr";
		if($item[0] == $page)
			echo " style='background:white'";
			
		$name = $item[0];
		if($name == 'Draft')
		{
			$count = getdbocount('PrivateMessage', "authorid=$user->id and draft");
			//PrivateMessage::model()->count("authorid=$user->id and draft");
			if($count)
				$name .= " ($count)";			
		}
		
		if($name == 'Inbox')
		{
			$count = getdbocount('PrivateMessage', "touserid=$user->id and not recv and not draft");
			//PrivateMessage::model()->count("touserid=$user->id and not recv and not draft");
			if($count)
				$name .= " ($count)";			
		}
		
		if($name == 'Outbox')
		{
			$count = getdbocount('PrivateMessage', "authorid=$user->id and not recv and not draft");
			//PrivateMessage::model()->count("authorid=$user->id and not recv and not draft");
			if($count)
				$name .= " ($count)";			
		}
		
		echo "><td>";
		echo l($name, $item[1]) . '<br>';
		echo '</td></tr>';
	}
	
	echo "</table>";
}


