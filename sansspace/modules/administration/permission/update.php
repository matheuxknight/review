<?php
echo "<h2>Edit Permission</h2>";

showButtonHeader();
showButton('All Permissions', array('admin'));
echo "</div>";

echo $this->renderPartial('_form', array(
	'permission'=>$permission,
	'update'=>true,
));

