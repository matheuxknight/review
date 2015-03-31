<?php

echo "<h2>New Template</h2>";

showButtonHeader();
showButton('Manage Templates', array('admin'));
echo"</div>";

echo $this->renderPartial('_form', array(
	'template'=>$template,
	'update'=>false,
));

