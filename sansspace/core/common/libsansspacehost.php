<?php

//define('SANSSPACE_MASTERNAME', 'localhost:8080');
define('SANSSPACE_MASTERNAME', 'system.sansspace.com');

////////////////////////////////////////////////////////////////

function SansspaceUpdate()
{
//	debuglog("SansspaceUpdate()");

	$to = getdbosql('TranscodeObject', "status=".CMDB_OBJECTTRANSCODE_CURRENT);
	if($to) return;

	$info = fetch_url('http://'.SANSSPACE_MASTERNAME.'/sansspacehost/version');
	if(!$info) return;
	if($info == SANSSPACE_VERSION) return;

	$server = getdbo('Server', 1);
	$server->netmessage = '
		<p><span style="color: #ff6600;"><strong>
		<span style="font-size: medium;">Software update in progress. This server will
		be unavailable for a few minutes.</span></strong></span></p>';
	$server->save();
	sleep(40);			// enough time for everyone to catch up

	$filecontent = @file_get_contents("http://".SANSSPACE_MASTERNAME."/sansspacehost/download");
	if(!$filecontent) return;

	$filename = SANSSPACE_TEMP."\\sansspace-$info.exe";
	file_put_contents($filename, $filecontent);

	if(!filesize($filename)) return;

	// backp first
	$backupname = 'update-'.SANSSPACE_VERSION;
	$filename1 = SANSSPACE_BACKUP."\\$backupname.sql";

	$cmd = "\"".SANSSPACE_INSTALL."\\mysql\\bin\\mysqldump.exe\"".
			" --host ".SANSSPACE_DBHOST.
			" -u ".SANSSPACE_DBUSER.
			" -p\"".SANSSPACE_DBPASSWORD.
			"\" --skip-extended-insert ".
			SANSSPACE_DBNAME." > $filename1";

	system($cmd);

	// then do the upgrade
	sendMessageSansspace('RUN Program', "Program=$filename\r\nParameter=-s");
	//	system("\"$filename\" -s");

	debuglog("SansspaceUpdate() started");
}




