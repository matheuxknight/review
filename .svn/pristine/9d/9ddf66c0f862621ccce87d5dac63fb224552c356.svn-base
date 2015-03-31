<?php

showAdminHeader(5);
echo "<h2>Software Update</h2>";

////////////////////////////////////////////////////////////////////////////////

$localversion = getdbosql('DatabaseVersion', "");
//DatabaseVersion::model()->find("");
if($localversion)
{
	echo "Your current version is <b>$localversion->version</b> and was installed 
		on <b>$localversion->updated</b>.<br><br>";
}

// get latest version from sansspace.com
$remoteinfo = fetch_url('http://'.SANSSPACE_MASTERNAME.'/sansspacehost/version');
if($remoteinfo)
{
	if($remoteinfo == $localversion->version)
		echo "Your SANSSpace is up to date.<br><br>";
	
	else
	{
		echo "The latest version on sansspace.com is <b>$remoteinfo</b>.<br><br>";

		echo "Click the Update button below if you want to update your server with the latest
			version of SANSSpace. Make sure nobody is connected as it may take a few minutes, 
			the server will restart and close all client connections.<br><br>";
		
		echo "<div class='buttonHolder'>";
		showButton('Update', array('update'));
		echo "</div>";
		echo "<script> $(function() {\$('a', '.buttonHolder').button();	}); </script>";
	}
}
else
	echo "Unable to connect to sansspace.com<br><br>";

//echo '<br>'.l('View the SANSSpace change log.', 'http://inside.sansspace.com/object/show&id=2482', 
//	array('target'=>'_blank')).'<br>';
			





