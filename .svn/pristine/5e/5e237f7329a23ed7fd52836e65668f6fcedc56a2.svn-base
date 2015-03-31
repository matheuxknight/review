<?php

/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

/**
 * This is the shortcut to Yii::app()
 */
function app()
{
	return Yii::app();
}

/**
 * This is the shortcut to Yii::app()->clientScript
 */
function cs()
{
	return Yii::app()->clientScript;
}

/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route,$params=array(),$ampersand='&')
{
	return Yii::app()->createUrl($route,$params,$ampersand);
}

///////////////////////////////////////////////////////////////////////

function h($text)
{
	return $text;
}

function decode_string($text)
{
	if(!mb_detect_encoding($text, 'UTF-8', true))
	{
		$text = htmlentities($text);
		$text = htmlspecialchars_decode($text);
	}

	return $text;
}

/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array())
{
	return CHtml::link($text, $url, $htmlOptions);
}

function button($text, $url = '#', $htmlOptions = array())
{
	if(!isset($htmlOptions['id']))
		$htmlOptions['id'] = 'sans_button_'.rand(1000, 10000);
	
	$res = CHtml::link($text, $url, $htmlOptions);
	$res .= "<script>$(function(){ $('#{$htmlOptions['id']}').button(); })</script>";
	
	return $res;
}

/**
 * This is the shortcut to CHtml::image()
 */
function img($text, $url = '#', $htmlOptions = array())
{
	return CHtml::image($text, $url, $htmlOptions);
}

/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function t($message, $category = 'stay', $params = array(), $source = null, $language = null)
{
	return Yii::t($category, $message, $params, $source, $language);
}

/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url=null)
{
	static $baseUrl;
	if ($baseUrl===null)
	$baseUrl=Yii::app()->request->baseUrl;
	return $url===null ? $baseUrl : $baseUrl.'/'.ltrim($url,'/');
}

// echo CHtml::cssFile(bu('/themes/'.param('theme').'/main.css'));

function tf($url = null)
{
	error_log("tf($url) called");
	return '';
}

function iconurl($source)
{
	$param = currentPageIconset();
	return "/images/iconset/$param/$source";
}

function iconimg($source, $text='', $options=array())
{
	$param = currentPageIconset();
	return img(iconurl($source), $text, $options);
}

function mainurl($source)
{
	return "/images/ui/{$source}";
}

function mainimg($source, $text='', $options=array())
{
	return img(mainurl($source), $text, $options);
}

/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name)
{
	$default_params = Array(
		'title'=>'SANSSpace',
		'adminemail'=>'support@sansinc.com',
		'allowregister'=>false,
		'autoplay'=>true,
		'useshortdate'=>true,
		'emailenrollment'=>false,
		'quicklogin'=>true,
		'showrole'=>false,
		'shortcutbutton'=>true,
		'singlelogin'=>false,
		'mustlogin'=>false,
		'htmleditor'=>'ck-editor',
		'iconset'=>'sansspace',
		'theme'=>'sans',
		'localnetwork'=>'127.0.0.1, 192.168.*.*, 172.16.*.*, 10.*.*.*',
		'logofftimeout'=>0,
		'quickcomment'=>true,
		'usetrackdoc'=>true,
		'keepfileextension'=>true,
		'mysansspacedropdown'=>true,
		'mysansspacetiles'=>false,
		
		'pagecount'=>25,
		'columncount'=>3,
		'subitemcount'=>5,
		'defaultorder'=>'name',
		'defaultprefix'=>'Comparative',
		'bookmarkprefix'=>'Bookmark',
		'commentprefix'=>'Comment',
		'linkname1'=>'sansinc.com',
		'linkurl1'=>'http://www.sansinc.com/',
		'defaultdomain'=>1,
		'defaultenrollment'=>CMDB_OBJECTENROLLTYPE_NONE,
		'defaultinherit'=>false,
		'enrolledonly'=>false,
		'usesemester'=>true,
				
		'linkcolor'=>'black',
		'topback'=>'white',
		'headerback'=>'#fbfbfb',
		'appheadercolor'=>'#ffffff',
		'appheaderback'=>'#888888',
		'appmaincolor'=>'#555555',
		'appmainback'=>'#eeeeee',
		'appmainalpha'=>'.9',
		'appslidercolor'=>'#999999',
		'appautosave'=>false,
				
		'required_password'=>true,
		'required_email'=>true,
		'required_organisation'=>false,
		'required_address'=>false,
		'required_city'=>false,
		'required_state'=>false,
		'required_postal'=>false,
		'required_country'=>false,
		'required_phone1'=>false,
				
	);

	if(Yii::app()->params['theme'] == 'default')
		unset(Yii::app()->params['theme']);

	if(!isset(Yii::app()->params[$name]))
		return $default_params[$name];

	else
		return Yii::app()->params[$name];
}

/**
 * This is the shortcut to Yii::app()->user.
 */
function user()
{
	return Yii::app()->user;
}


function JavascriptFile($filename)
{
	echo CHtml::scriptFile($filename);
}

function Javascript($javascript)
{
	echo "<script>$javascript</script>";
}

function JavascriptReady($javascript)
{
	echo "<script>$(function(){ $javascript})</script>";
}

//////////////////////////////////////////////////////////////////////

// function currentPageColor1()
// {
// 	$object = getdbo('Object', getparam('id'));
// 	while($object)
// 	{
// 		if(!empty($object->ext->customcolor1))
// 			return $object->ext->customcolor1;
	
// 		$object = $object->parent;
// 	}

// 	return null;
// }

function currentPageColor2()
{
	$object = getdbo('Object', getparam('id'));
	while($object)
	{
		if(!empty($object->ext->customcolor2))
			return $object->ext->customcolor2;
	
		$object = $object->parent;
	}

	return null;
}

function currentPageHeader()
{
	$object = getdbo('Object', getparam('id'));
	while($object)
	{
		if(!empty($object->ext->customheader))
			return $object->ext->customheader;
	
		$object = $object->parent;
	}

	$server = getdbo('Server', 1);
	if($server)
		return $server->header;
		
	return null;
}

function currentPageIconset()
{
	$object = getdbo('Object', getparam('id'));
	while($object)
	{
		if(!empty($object->ext->customiconset) && $object->ext->customiconset != 'default')
		{
		//	debuglog("$object->name ($object->id) {$object->ext->customiconset}");
			return $object->ext->customiconset;
		}
		
		$object = $object->parent;
	}

	return param('iconset');
}

function currentPageTheme()
{
	$object = getdbo('Object', getparam('id'));
	while($object)
	{
		if(!empty($object->ext->customiconset) && $object->ext->customiconset != 'default')
		{
		//	debuglog("$object->name ($object->id) {$object->ext->customiconset}");
			return $object->ext->customiconset;
		}
		
		$object = $object->parent;
	}

	return param('theme');
}




