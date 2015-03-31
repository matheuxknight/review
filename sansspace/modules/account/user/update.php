<?php
echo "<h2>$user->name - User Properties</h2>";

showButtonHeader();
showButton('All Users', array('admin'));
showButton('New User',array('create'));
showButton('User Folder', array('object/show', 'id'=>$user->folderid));
showButton('User Sessions', array('session/', 'users'=>$user->logon));
showButtonPost('Log As', array('submit'=>array('user/logas','id'=>$user->id), 'confirm'=>'Are you sure?'));

if($user->logon != 'admin' && $user->logon != 'SYSTEM')
	showButtonPost('Delete User',array('submit'=>array('delete','id'=>$user->id),'confirm'=>'Are you sure?'));

echo "</div>";
echo $this->renderPartial('_form', array('user'=>$user, 'update'=>true));

