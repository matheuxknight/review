<?php

$object = $enrollment->object;

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

echo "<h2>Edit Enrollment</h2>";

showButtonHeader();
showButton('Back to Page Enrollment', array('object/update', 'id'=>$object->id, '#'=>'properties-enrollment'));

showButtonPost('Delete Enrollment', array(
	'submit'=>array('delete', 'id'=>$enrollment->id),
	'confirm'=>'Are you sure you want to delete this enrollment?'));

echo "</div>";

echo $this->renderPartial('_form', array('enrollment'=>$enrollment,
	'object'=>$object, 'update'=>true));




