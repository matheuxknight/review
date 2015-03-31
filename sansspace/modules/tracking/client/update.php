<?php

echo "<h2>Edit Client</h2>";

showButtonHeader();
showButton('All Clients', array('admin'));
showButtonPost('Delete Client', array('submit'=>array('delete','id'=>$client->id), 'confirm'=>'Are you sure?'));
showButton('Sessions', array('session/', 'clients'=>$client->remoteip));
//showButton('Google', "http://google.com/#q=$client->remoteip", array('target'=>'_blank'));
echo "</div>";

echo $this->renderPartial('_form', array(
	'client'=>$client,
	'update'=>true,
));

