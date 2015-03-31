<?php

$global_lastlog = 0;
function logtime($text)
{
	global $global_lastlog;

	$t = microtime(true);
	$d = $t - $global_lastlog;

	if($d >= 1) $text = $text.' =====================';
	error_log("$t, $d - $text");

	$global_lastlog = $t;
}

///////////////////////////////////////////////////////////

function SansspaceModulePath($name)
{
//	debuglog("SansspaceModulePath($name)");
	$varname = "module_$name";

	if(function_exists('xcache_isset') && xcache_isset($varname))
		return xcache_get($varname);
	
	$result = findfile('sansspace/models', "/\/{$name}.php/");
	if(!$result)
		$result = findfile('sansspace/modules', "/\/{$name}.php/");
	
	if($result && function_exists('xcache_isset'))
		xcache_set($varname, $result);
	
	return $result;
}

function findfile($path, $pattern)
{
	$result = null;

	$path = rtrim(str_replace("\\", "/", $path), '/') . '/*';
	foreach(glob($path) as $fullname)
	{
		if(is_dir($fullname))
		{
			$result = findfile($fullname, $pattern);
			if($result) break;
		}

		else if(preg_match($pattern, $fullname))
		{
			$result = $fullname;
			break;
		}
	}

	return $result;
}

function hasFavorite($userid, $objectid)
{
	return getdbosql('Favorite',"userid=$userid and id=$objectid");
	//Favorite::model()->find(array('condition'=>"userid=$userid and id=$objectid"));
}

function mydump($obj, $level=2)
{
	CVarDumper::dump($obj, $level, true);
	echo "<br>";
}

function mydumperror($obj, $level=2)
{
	CVarDumper::dumperror($obj, $level);
}

function debuglog($string, $level=2)
{
	if(!SANSSPACE_DEBUGLOG) return;
	
	if(is_array($string) || is_object($string))
	{
		mydumperror($string, $level);
		return;
	}

	$now = now();
	if(!is_dir(SANSSPACE_LOGS)) mkdir(SANSSPACE_LOGS);
	error_log("[$now] $string\r\n", 3, SANSSPACE_LOGS."/debug.log");
}

function xmltoarray($xmlcontent)
{
	$xml = simplexml_load_string($xmlcontent);
	$json = json_encode($xml);
	$array = json_decode($json, true);

	return $array;
}

function XssFilter($data)
{
	$data = str_replace(">", "", $data);
	$data = str_replace("<", "", $data);
	$data = str_replace("'", "", $data);
	$data = str_replace('"', "", $data);
//	$data = str_replace(".", "", $data);
	$data = str_replace("\\", "", $data);
	
//	mydump($data); die;
	return $data;
}

function showDatetimePicker($model, $attribute)
{
	$name = "{$model->tableSchema->name}[{$attribute}]";
	$id = "{$model->tableSchema->name}_{$attribute}";

	echo "<script>
	  $(function() {
	    $('#$id').datepicker(
	    {
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	  });
	  </script>";

	echo "<input id='$id' name='$name' class='textInput sans-input' type='text' value='{$model->$attribute}'>";
}

function showDatetimePicker2($name, $value, $options='', $callback='null')
{
	$id = $name;
	echo "<script>
	  $(function() {
	    $('#$id').datepicker(
	    {
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			onSelect: $callback
		});
	  });
	  </script>";

	if(empty($value)) $value = $name;
	echo "<input id='$id' name='$name' type='text' $options class='sans-input' value='$value' size='10'>";
}

function showSubmitButton($name)
{
	echo "<div class='buttonHolder'>";
	echo CUFHtml::submitButton($name, array('id'=>'btnSubmit'));
	echo "</div>";
	echo "<script>$(function(){ $('#btnSubmit').button(); }); </script>";
}

function showSubmitButton2($name)
{
	echo CUFHtml::submitButton($name, array('id'=>'btnSubmit'));
	echo "<script>$(function(){ $('#btnSubmit').button(); }); </script>";
}

function InitMenuTabs($tabname)
{
	JavascriptReady("

	$('$tabname').show();
	$('$tabname').tabs();
	$('$tabname').tabs(
	{
		activate: function(event, ui)
		{
			var temp = $(window).scrollTop();
			window.location.replace(ui.newTab.context.hash);
		 	$(window).scrollTop(temp)
			return true;}
	});
			
	");
	
}

function fetch_url($url)
{
	//println("fetch_url($url)");
	return file_get_contents($url);
	
// 	$buffer = '';

// 	$file = @fopen($url, "r");
// 	if(!$file) return null;

// 	while(!feof($file))
// 	{
// 		$line = fgets($file, 1024);
// 		$buffer .= $line;
// 	}

// 	fclose($file);
// 	return $buffer;
}

function gettempfile($ext)
{
	$phpsessid = session_id();
	$random = mt_rand();

	$filename = SANSSPACE_TEMP."\\{$phpsessid}-{$random}{$ext}";
	return $filename;
}

function delete_folder($dirPath)
{
	if(!is_dir($dirPath) || strlen($dirPath) < 10)
		return;
	
	debuglog("delete_folder($dirPath)");
	if (substr($dirPath, strlen($dirPath) - 1, 1) != '/')
		$dirPath .= '/';
	
	$files = glob($dirPath . '*', GLOB_MARK);
	foreach ($files as $file)
	{
		if (is_dir($file))
			delete_folder($file);
		else
			@unlink($file);
	}
	
	@rmdir($dirPath);
}





