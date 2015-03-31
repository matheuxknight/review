<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

if($object->type == CMDB_OBJECTTYPE_FILE)
	echo "<h2>New Comment for {$object->author->name}</h2>";

else
	echo "<h2>New Comment</h2>";

echo $this->renderPartial('_form', array(
	'comment'=>$comment,
	'container'=>$object,
	'update'=>false,
));


	
	

