<?php

echo "<h2>New Item for {$category->name}</h2>";

showButtonHeader();
showButton('All Categories', array('admin'));
showButton($category->name, array('update', 'id'=>$category->id));
echo "</div>";

echo $this->renderPartial('_formitem', array(
	'category'=>$category,
	'categoryitem'=>$categoryitem,
	'update'=>false,
));

