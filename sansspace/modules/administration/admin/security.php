<?php

echo "<h2>Security System</h2>";
ShowUploadHeader();

////////////////////////////////////////////////////////////////////////////////

echo "<h3>Backup</h3>";

echo "Click the Backup button below to download the current role and permission 
security file.<br><br><br>";

showButtonHeader();
showButton('Backup Roles and Permissions', array('admin/backupperm'));
echo "</div>";

////////////////////////////////////////////////////////////////////////////////

echo "<h3>Restore</h3>";

echo "Click the Select File button below to select your security file and click on 
the Restore button to start uploading it.<br><br>";

echo CUFHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data'));

echo '<div class="miscInput"><span id="spanButtonPlaceholder"></span></div>';
echo '<div class="flash" id="fsUploadProgress"></div>';

echo "<br><div class='buttonHolder'>";
echo CUFHtml::submitButton('Restore Roles and Permissions', array(
	'id'=>'btnSubmit',
	'confirm'=>'Are you sure you want to restore this file?',
));

echo "</div>";
echo CUFHtml::endForm();











