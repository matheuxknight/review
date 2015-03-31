<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($client);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($client, 'remotename');
echo CUFHtml::activeLabelEx($client, 'remotename');
echo CUFHtml::activeTextField($client, 'remotename', array('maxlength'=>200));

echo <<<END
<a id='google_name'>Google it</a>
<script>$(function(){ 
	$('#google_name').button({
			icons:{primary: 'ui-icon-search'}, text: false
		}).click(function(e){
			window.open("http://google.com/#q=$client->remotename", "_blank");
		});
	});</script>
END;

echo "<p class='formHint2'>Name of the client computer.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($client, 'remoteip');
echo CUFHtml::activeLabelEx($client, 'remoteip');
echo CUFHtml::activeTextField($client, 'remoteip', array('maxlength'=>200));

echo <<<END
<a id='google_ip'>Google it</a>
<script>$(function(){ 
	$('#google_ip').button({
			icons:{primary: 'ui-icon-search'}, text: false
		}).click(function(e){
			window.open("http://google.com/#q=$client->remoteip", "_blank");
		});
	});</script>
END;

echo "<p class='formHint2'>IP address of the client.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();





