<?php
$this->pageTitle = app()->name ." - {$object->name}";

showRoleBar($object);
showNavigationBar($object->parent);
showObjectHeader($object);

echo "<br>";
echo "The content you want to delete has an associated file(s) in a folder import ".
"that is outside of SANSSpace internal content management.<br><br>";

echo "Do you want to also delete the associated file(s)?<br><br>";




