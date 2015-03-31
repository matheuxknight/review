<?php

echo "<h2>Edit Category</h2>";

showButtonHeader();
showButton('All Categories', array('admin'));
showButton('New Category', array('create'));
//showButtonPost('Delete Category', array('submit'=>array('delete','id'=>$category->id),'confirm'=>'Are you sure?'));
echo "</div>";

echo $this->renderPartial('_form', array(
	'category'=>$category,
	'categoryitemList'=>$categoryitemList,
	'update'=>true,
));


