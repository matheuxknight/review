<?php
$this->pageTitle = app()->name ." - {$object->name}";

showRoleBar($object);
showNavigationBar($object->parent);
showObjectHeader($object);

echo "<h3 style='color: red;'>Warning - Deleting a file</h3>";

echo "<p>The content you want to delete has an associated file in a folder import 
that is outside of SANSSpace internal content management.</p>";

$filename = objectPathname($object);

echo "<p style='padding-left: 20px'><b>$filename</b><p>";
echo "<p>If you select Yes, this file will be deleted. If you select No, only the 
database record will be deleted, not the file.<p>";

echo "<p>Do you want to also delete the associated file(s)?<p>";
echo "<br>";

echo "<div class='buttonHolder'>";
showButton('Yes', array('file/harddelete', 'id'=>$object->id)).' ';
showButton('No', array('file/softdelete', 'id'=>$object->id)).' ';
showButton('Cancel', array('object/show', 'id'=>$object->parentid));
echo "</div><br>";

echo "<script> $(function() {\$('a', '.buttonHolder').button();	}); </script>";

