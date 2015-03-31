<?php

showPmHeader('Forward Message');

echo $this->renderPartial('_form', array(
	'pm'=>$pm,
));

showPmFooter();


