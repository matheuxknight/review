<?php
echo "<h2>Edit Semester</h2>";

showButtonHeader();
showButton('All Templates', array('admin'));
showButton('New Template', array('create'));
showButtonPost('Delete Template', array('submit'=>
	array('delete','id'=>$semestertemplate->id),'confirm'=>'Are you sure?'));
echo "</div>";

echo $this->renderPartial('_form', array(
	'semestertemplate'=>$semestertemplate,
	'update'=>true,
));

