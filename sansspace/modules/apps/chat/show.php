<?php

$this->pageTitle = "SANSSpace Chat";
$appid = 'sansmediad';

$getflash = mainimg('getflash.jpg');
$flashvars = "chat=1";

echo "<br>";

ShowApplication($flashvars, 'chat', $appid, '520');
JavascriptReady("RightClick.init('$appid');");

echo "</body></html>";








