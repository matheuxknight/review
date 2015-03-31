<?php

echo "<h2>Restarting Service</h2>";
echo 'The SANSSpace Service is restarting, please wait...<br><br><br>';

echo "<div id='messagediv'></div><br>";
echo "<div style='width:50%' id='progressbar'></div>";

JavascriptFile('/sansspace/modules/administration/admin/RestartService.js');
JavascriptReady("RestartService.init('#progressbar', '#messagediv')");

