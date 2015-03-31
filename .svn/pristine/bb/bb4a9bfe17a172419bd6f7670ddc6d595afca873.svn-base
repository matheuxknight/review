<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

if($object->type == CMDB_OBJECTTYPE_FILE)
	echo "<h2>Edit Comment for {$object->author->name}</h2>";

else
	echo "<h2>Edit Comment</h2>";

echo $this->renderPartial('_form', array(
	'comment'=>$comment,
	'container'=>$object,
	'update'=>true,
));



	

