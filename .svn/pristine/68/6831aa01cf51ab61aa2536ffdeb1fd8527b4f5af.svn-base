<?php

if(user()->isGuest)
	showLoginMenu();

echo "<h2>Login Required</h2>";

$server = getdbo('Server', 1); 
//Server::model()->findByPk(1);
if($server)
	echo $server->accessdenied;

	