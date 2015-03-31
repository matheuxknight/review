<?php
echo "<h2>Edit Roster Template</h2>";

showButtonHeader();
showButton('All Templates', array('admin'));
showButton('New Template', array('create'));
showButtonPost('Delete Template', array('submit'=>array('delete','id'=>$roster->id),'confirm'=>'Are you sure?'));
echo "</div>";

echo $this->renderPartial('_form', array(
	'roster'=>$roster,
	'update'=>true,
));

