<?php

$phpsessid = getparam('id');

$session = getdbosql('Session', "phpsessid='$phpsessid'");
if(!$session) return;

$this->pageTitle = $session->user->name;
include '/sansspace/ui/lib/pageheader.php';

$appid = 'sansmediad';

echo <<<END
<style>
html
{
	height: 100%;
	overflow: hidden;
}

body
{
	height: 100%;
	margin: 0;
	padding: 0;
}

#$appid
{
	height: 100%;
}
</style>
</head>
<body>
END;


$getflash = mainimg('getflash.jpg');
$flashvars = "live=1&userid={$session->user->id}&channel=1";

ShowApplication($flashvars, 'player', $appid, '100%');
JavascriptReady("RightClick.init('$appid');");

echo "</body></html>";








