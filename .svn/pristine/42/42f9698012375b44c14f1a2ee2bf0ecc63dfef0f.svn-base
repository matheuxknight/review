<?php

$object = getdbo('Object', $enrollment->objectid);

showNavigationBar($object->parent);
showObjectHeader($object);

echo "<h2>New Enrollment</h2>";

showButtonHeader();
showButton('Back to Page Enrollment', array('object/update', 'id'=>$object->id, '#'=>'properties-enrollment'));

echo "</div>";

echo $this->renderPartial('_form', array('enrollment'=>$enrollment,
	'object'=>$object, 'update'=>false));


