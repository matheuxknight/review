<?php

echo "<h2>Edit Certificate $certificate->commonname</h2>";

showButtonHeader();
showButton('All Certificates', array('admin'));
//showButton('Download Certificate Request', array('downloadcsr', 'id'=>$certificate->id));
//showButton('Upload Signed Certificate', array('uploadcert', 'id'=>$certificate->id));

showButtonPost('Generate Request and Private Key', 
	array('submit'=>array('generatecsr', 
	'id'=>$certificate->id), 'confirm'=>'Are you sure?'));

showButtonPost('Self-Sign Certificate', array('submit'=>array('selfsign', 
	'id'=>$certificate->id), 'confirm'=>'Are you sure?'));

showButton('Upload .pfx file', array('uploadpfx', 'id'=>$certificate->id));

echo "</div>";

echo $this->renderPartial('_form', array(
	'certificate'=>$certificate, 'update'=>true,));




