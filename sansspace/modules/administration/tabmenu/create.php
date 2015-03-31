<?php
echo "<h2>New Tab Menu</h2>";

showButtonHeader();
showButton('All', array('admin'));
echo "</div>";

echo $this->renderPartial('_form', array('tabmenu'=>$tabmenu, 'update'=>false));

