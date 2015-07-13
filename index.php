<?php
//$t1 = microtime(true);
//define(SANSSPACE_DEBUGLOG, true);

// another inapropriate comment

// if(isset($_SERVER['HTTPS']))
// {
// 	$redirect = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
// 	header("HTTP/1.1 301 Moved Permanently");
// 	header("Location: $redirect");
// }
error_reporting(E_ERROR | E_PARSE);
set_include_path(get_include_path() . ':' . __DIR__);
require_once('vendor/autoload.php');
if ($_SERVER['SERVER_ADDR'] == $_SERVER['REMOTE_ADDR']) {
    require_once('../serverconfig.php');
}
require_once('sansspace/ui/app.php');


if (isset($_REQUEST['noheader']) || strstr(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '', 'noheader'))
    user()->setState('noheader', 1);

//if(SANSSPACE_DEBUG && !strstr($_SERVER['REQUEST_URI'], 'ping'))
//	debuglog("{$_SERVER['REMOTE_ADDR']}: {$_SERVER['REQUEST_URI']} - {$_SERVER['HTTP_REFERER']}");

if (!preg_match('/^\/proxy\?url=/', $_SERVER['REQUEST_URI'])) {
    $pattern = "{$_SERVER['HTTP_HOST']}/proxy?url=(.*)";
    $pattern = preg_replace('/\//', '\/', $pattern);
    $pattern = preg_replace('/\?/', '\?', $pattern);

    $b = preg_match("/$pattern/", isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '', $m);
    if ($b) {
        $localdomain = $_SERVER['HTTP_HOST'];
        $remotedomain = $m[1];

        $pos = strpos($remotedomain, '/', 8);
        if ($pos) $remotedomain = substr($remotedomain, 0, strpos($remotedomain, '/', 8));

        header("Location: http://$localdomain/proxy?url={$remotedomain}{$_SERVER['REQUEST_URI']}");
        return;
    }
}

try {
    $app->run();
} catch (CException $e) {
//	debuglog($e, 3);
    mydump($e, 3);
}

//if(!strstr($_SERVER['REQUEST_URI'], 'ping'))
//	debuglog("{$_SERVER['REMOTE_ADDR']} end: {$_SERVER['REQUEST_URI']} - {$_SERVER['HTTP_REFERER']}");

// $t2 = microtime(true);
// $d1 = precision($t2 - $t1, 2);

// if($d1 > 1)
// {
// 	$message = username()." - {$_SERVER['REQUEST_URI']}";
// 	debuglog("$d1 - $message");
// }




