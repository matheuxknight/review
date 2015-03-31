<?php

$sessionid = $_REQUEST['phpsessid'];
$filedata = $_FILES['Filedata'];

$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';
$basename = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($filedata['name']));

$filename = SANSSPACE_TEMP."/upload-$sessionid-$basename";
@move_uploaded_file($filedata['tmp_name'], $filename);


