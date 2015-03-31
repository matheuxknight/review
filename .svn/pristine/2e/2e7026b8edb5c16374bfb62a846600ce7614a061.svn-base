<?php

echo "<h2>Edit Tab Menu</h2>";

showButtonHeader();
showButton('All', array('admin'));
showButton('New Tab Menu', array('create'));
showButtonPost('Delete', array('submit'=>array('delete','id'=>$tabmenu->id),'confirm'=>'Are you sure?'));
echo "</div>";

echo $this->renderPartial('_form', array('tabmenu'=>$tabmenu, 'update'=>true));

