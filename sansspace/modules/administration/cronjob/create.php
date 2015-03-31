<?php

echo "<h2>New Cron Job</h2>";

showButtonHeader();
showButton('All Jobs', array('admin'));
echo"</div>";

echo $this->renderPartial('_form', array(
		'cronjob'=>$cronjob,
		'update'=>false,
));

