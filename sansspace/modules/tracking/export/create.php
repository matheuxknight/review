<?php
echo "<h2>New Custom Template</h2>";

showButtonHeader();
showButton('All Templates', array('admin'));
echo "</div>";

echo $this->renderPartial('_form', array(
	'export'=>$export,
	'update'=>false,
));