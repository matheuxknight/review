<?php

echo "<h2>Edit Folder Import</h2>";

showButtonHeader();
showButton('All Import Folders', array('admin'));
showButton('New Import Folder', array('create'));
showButton('Edit Object', array('object/update', 'id'=>$folderImport->objectid));
showButton('Rescan Now', array('object/rescan', 'id'=>$folderImport->objectid));
showButtonPost('Delete Folder', array('submit'=>array('delete','id'=>$folderImport->id), 'confirm'=>'Are you sure?'));
echo "</div>";

echo $this->renderPartial('_form', array(
	'parent'=>$parent,
	'folderImport'=>$folderImport,
	'update'=>true,
));

