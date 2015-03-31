<?php

echo "<h2>New Category</h2>";

showButtonHeader();
showButton('All Categories', array('admin'));
echo "</div>";

echo $this->renderPartial('_form', array(
	'category'=>$category,
	'update'=>false,
));

