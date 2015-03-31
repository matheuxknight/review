<?php

echo "<h2>Edit Transcode Template</h2>";

showButtonHeader();
showButton('Manage Templates', array('admin'));
showButton('New Template', array('create'));
showButtonPost('Delete Template', array('submit'=>array('delete','id'=>$template->id), 'confirm'=>'Are you sure?'));
showButtonPost('Delete Transcoded Files', array('submit'=>array('deletetranscoded','id'=>$template->id), 'confirm'=>'Are you sure?'));
echo "</div>";

echo $this->renderPartial('_form', array(
	'template'=>$template,
	'update'=>true,
));

