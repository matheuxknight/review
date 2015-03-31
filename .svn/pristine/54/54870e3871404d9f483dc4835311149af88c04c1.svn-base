<?php
echo "<h2>Custom Template $export->name</h2>";

showButtonHeader();
showButton('All Templates', array('admin'));
showButton('New Template', array('create'));
showButton('Browse Data', array('browse', 'id'=>$export->id));
showButtonPost('Delete Template', array('submit'=>array('delete','id'=>$export->id),'confirm'=>'Are you sure?'));
echo "</div>";

echo $this->renderPartial('_form', array(
	'export'=>$export,
	'update'=>true,
));

