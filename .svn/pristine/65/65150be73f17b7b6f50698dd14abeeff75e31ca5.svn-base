<?php

echo "<h2>Edit Domain</h2>";

showButtonHeader();
showButton('All Domains', array('admin'));
showButton('New Domain', array('create'));

if($domain->id != 1)
	showButtonPost('Delete Domain', array('submit'=>array('delete','id'=>$domain->id),'confirm'=>'Are you sure?'));

//showButtonPost('Import Extracts', array('submit'=>array('processscript','id'=>$domain->id),'confirm'=>'Are you sure?'));
echo "</div>";

echo $this->renderPartial('_form', array('domain'=>$domain, 'update'=>true));

