<?php
exit(1);	//broken

require_once('sansspace/ui/app.php');
require_once('sansspace/core/webdav/include.php');

WebdavAuthenticate();
set_time_limit(0);

$server = new WebDAVServer();
$server->serveRequest();




