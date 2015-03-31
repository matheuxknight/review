<?php

require_once('sansspace/ui/app.php');
$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';

$sessionid = getparam('phpsessid');
$number = getparam('number');

$filedata = $_FILES['user_file'];

$basename = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", 
	basename($filedata['name'][0]));

$filename = SANSSPACE_TEMP."/upload-$sessionid-$basename";

@move_uploaded_file($filedata['tmp_name'][0], $filename);
exit;


