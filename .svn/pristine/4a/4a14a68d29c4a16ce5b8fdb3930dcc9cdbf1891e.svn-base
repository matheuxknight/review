<?php

function atosec($s)
{
	$b = preg_match('/(\d+):(\d+):(\d+)/', $s, $matches);
	if(!$b)
	{
		$b = preg_match('/(\d+):(\d+)/', $s, $matches);
		if(!$b) return intval($s);
	}
	
	if(isset($matches[3]))
		return $matches[1]*60*60+$matches[2]*60+$matches[3];
	else
		return $matches[1]*60+$matches[2];
}


function GetMonthString($n)
{
	$timestamp = mktime(0, 0, 0, $n, 1, 2005);
	return date("F", $timestamp);
}

function datetoa($d)
{
	if(!param('useshortdate'))
		return $d;
		
	if(!$d) return '';
	
	$t = wp_mktime($d);
	$e = time() - $t;
	
	$table = array(
					// limit         divider
		array('year',  60*60*24*365, 60*60*24*365),
		array('month', 60*60*24*60,  60*60*24*30),
		array('week',  60*60*24*14,  60*60*24*7),
		array('day',   60*60*24*2,   60*60*24),
		array('hour',  60*60*2,      60*60),
		array('min',   60*2,         60),
		array('sec',   0,            1),
	);
	
	foreach($table as $r)
	{
		if($e >= $r[1])
		{
			$res = floor($e/$r[2]) . " " . $r[0] . (($e/$r[2])>=2?"s":""). " ago";
			break;
		}
	}
	
	return "<span title='$d'>$res</span>";
}

function sectoa($i)
{
//	if($i < (60*60))
//		return sprintf("%d:%02d", $i%(60*60)/60, $i%60);
//	else
		return sprintf("%d:%02d:%02d", $i/(60*60), $i%(60*60)/60, $i%60);
}

function Itoa($i)
{
	$s = '';
	if($i >= 1024*1024*1024)
		$s = round(floatval($i)/1024/1024/1024, 1) ."G";
	else if($i >= 1024*1024)
		$s = round(floatval($i)/1024/1024, 1) ."M";
	else if($i >= 1024)
		$s = round(floatval($i)/1024, 1) ."K";
	else
		$s = round(floatval($i), 1);
	
	return $s;
}

function Itoa2($i)
{
	$s = '';
	if($i >= 1000*1000)
		$s = round(floatval($i)/1000/1000, 1) ."m";
	else if($i >= 1000)
		$s = round(floatval($i)/1000, 1) ."k";
	else
		$s = round(floatval($i), 1);
	
	return $s;
}

function YesNo($b)
{
	if($b) return 'Yes';
	else return '';
}

function Booltoa($b)
{
	if($b)
		return mainimg('green-check.png');
}

function precision($n, $p)
{
	if($p < 0) return 0;

	$temp = pow(10, $p);
	return round($n * $temp) / $temp;
}

///////////////////////////////////////

function wp_mktime($_timestamp = '')
{
    if($_timestamp)
    { 
        $_split_datehour = explode(' ',$_timestamp); 
        $_split_data = explode("-", $_split_datehour[0]); 
        $_split_hour = explode(":", $_split_datehour[1]); 

        return mktime ($_split_hour[0], $_split_hour[1], $_split_hour[2], $_split_data[1], $_split_data[2], $_split_data[0]); 
    } 
} 

function now()
{
	return date("Y-m-d H:i:s");
}

function nowDate($offset=0)
{
	$t = time() + $offset;
	return date("Y-m-d", $t);
}

function removeExtension($strName) 
{
	$ext = strrchr($strName, '.'); 
	if($ext !== false) 
		$strName = substr($strName, 0, -strlen($ext)); 
	return $strName; 
}

function getExtension($strName) 
{
	$ext = strrchr($strName, '.');
	return strtolower($ext);
}

function isFileExtensionIn($filename, $extensions)
{
	$ext = strrchr($filename, '.');
	if(in_array($ext, $extensions))
		return true;
	return false;		
}

///////////////////////////////////////

function setFlag($flags, $flag, $value = true)
{
	if($value)
		$flags |= $flag;
	else
		$flags &= ~$flag;
	
	return $flags;
}

function clearFlag($flags, $flag)
{
	return setFlag($flags, $flag, false);
}

function getFlag($flags, $flag)
{
	if($flags & $flag)
		return true;
	else
		return false;
}

function sanitizeObjectname($objectname)
{
	// remove underscore
	$objectname = preg_replace('/_/', ' ', $objectname);
	
	// make 1 -> 01, 2 -> 02
//	$objectname = preg_replace('/(^| )([0-9])($| |\.)/', '${1}0${2}${3}', $objectname);
	
	return $objectname;
}

function sanitize_name($string = '', $is_filename = FALSE)
{
	$string = preg_replace('/[^\w\-'. ($is_filename ? '~_\.' : ''). ']+/u', '-', $string);
	return mb_strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
}	

function strip_cdata($string) 
{ 
	preg_match_all('/<!\[cdata\[(.*?)\]\]>/is', $string, $matches); 
	return str_replace($matches[0], $matches[1], $string); 
} 

function array_trim($ar)
{
	foreach($ar as $key=>$val)
		if(empty($ar[$key]))
			unset($ar[$key]);

	return $ar;
}

///////////////////////


function processDoctext($object, $doctext)
{
	$result = $doctext;
	
	$count = preg_match_all('/\[sansspace:([a-z]+) "([a-zA-Z0-9\.\-_ ]+)"\]/', 
		$result, $matches);
		
	for($i = 0; $i < $count; $i++)
	{
		switch($matches[1][$i])
		{
			case 'image':
				$f = getdbosql('VFile',"parentid=$object->id and name='{$matches[2][$i]}'");
				if($f)
				{
					$replace = l(img(fileUrl($f), '', array('width'=>'450')), 
						objectUrl($f)).'<br>';
						
					if(!$localpath)
						$replace .= mainimg('menudot.png', '', array('width'=>16)).' '.
						l("<b>$f->name</b>", objectUrl($f));
											
					$pattern = preg_replace('/\[/', '\\[', $matches[0][$i]);
					$pattern = preg_replace('/\]/', '\\]', $pattern);
					$result = preg_replace("/$pattern/", $replace, $result);
				}
				break;

			case 'link':
				$o = getdbosql('Object',"parentid=$object->id and name='{$matches[2][$i]}'");
				if($o && !$localpath)
				{
					$pattern = preg_replace('/\[/', '\\[', $matches[0][$i]);
					$pattern = preg_replace('/\]/', '\\]', $pattern);
					$result = preg_replace("/$pattern/", 
						l("<b>$o->name</b>", objectUrl($o)), $result);
				}
				break;
				
			case 'media':
				$f = getdbosql('VFile',"parentid=$object->id and name='{$matches[2][$i]}'");
				if($f && !$localpath)
				{
					$miniplayer = getMiniPlayer($f).
						mainimg('menudot.png', '', array('width'=>16)).' '.
						l("<b>$f->name</b>", fileUrl($f));
					
					$pattern = preg_replace('/\[/', '\\[', $matches[0][$i]);
					$pattern = preg_replace('/\]/', '\\]', $pattern);
					$result = preg_replace("/$pattern/", $miniplayer, $result);
				}
				break;
		}
	}
	
	/////////////////////////////
	
	$count = preg_match_all('/\[sansspace:([a-z]+) ([a-zA-Z0-9\.\-_ ]+)\]/', 
		$result, $matches);
		
	for($i = 0; $i < $count; $i++)
	{
		switch($matches[1][$i])
		{
			case 'image':
				$f = getdbosql('VFile',"id='{$matches[2][$i]}'");
				//VFile::model()->find("id='{$matches[2][$i]}'");
				if($f)
				{
					$replace = l(img(fileUrl($f), '', array('width'=>'450')), 
						objectUrl($f)).'<br>';
						
					if(!$localpath)
						$replace .= mainimg('menudot.png', '', array('width'=>16)).' '.
						l("<b>$f->name</b>", objectUrl($f));
					
					$pattern = preg_replace('/\[/', '\\[', $matches[0][$i]);
					$pattern = preg_replace('/\]/', '\\]', $pattern);
					$result = preg_replace("/$pattern/", $replace, $result);
				}
				break;
				
			case 'link':
				$o = getdbosql('Object',"id='{$matches[2][$i]}'");
				//Object::model()->find("id={$matches[2][$i]}");
				if($o && !$localpath)
				{
					$pattern = preg_replace('/\[/', '\\[', $matches[0][$i]);
					$pattern = preg_replace('/\]/', '\\]', $pattern);
					$result = preg_replace("/$pattern/", 
						l("<b>$o->name</b>", objectUrl($o)), $result);
				}
				break;
				
			case 'media':
				$f = getdbosql('VFile',"id='{$matches[2][$i]}'");
				//VFile::model()->find("id='{$matches[2][$i]}'");
				if($f && !$localpath)
				{
					$miniplayer = getMiniPlayer($f).
						mainimg('menudot.png', '', array('width'=>16)).' '.
						l("<b>$f->name</b>", objectUrl($f));
										
					$pattern = preg_replace('/\[/', '\\[', $matches[0][$i]);
					$pattern = preg_replace('/\]/', '\\]', $pattern);
					$result = preg_replace("/$pattern/", $miniplayer, $result);
				}
				break;
		}
	}
	
	if(!empty($result))
		$result = '<br>'.$result.'<br>';
		
	return $result;
}

function strip_tags_content($text, $tags = '', $invert = FALSE)
{
  preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
  $tags = array_unique($tags[1]);
    
  if(is_array($tags) AND count($tags) > 0) {
    if($invert == FALSE) {
      return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    else {
      return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
    }
  }
  elseif($invert == FALSE) {
    return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
  }
  return $text;
}

//////////////////////////////

function my_array_search($param, $needle, $haystack)
{
	foreach($haystack as $item)
	{
		if($item[$param] == $needle)
			return true;
	}

	return false;
}

function my_array_sort($object, $key='name', $reverse=false)
{
	for($i = count($object) - 1; $i >= 0; $i--) 
	{ 
		$swapped = false; 
		for($j = 0; $j < $i; $j++) 
		{ 
			if(
				(
					isset($object[$j]->$key) && 
					isset($object[$j + 1]->$key) &&

					$reverse? 
						$object[$j]->$key < $object[$j + 1]->$key:
						$object[$j]->$key > $object[$j + 1]->$key
				) ||
				 
				(isset($object[$j]->$key) && !isset($object[$j + 1]->$key))
			)
			{
				$tmp = $object[$j]; 
				$object[$j] = $object[$j + 1];       
				$object[$j + 1] = $tmp; 
				$swapped = true; 
			} 
		} 
		
		if(!$swapped) return $object; 
	}
}

function my_array_sort2($object, $key='name', $reverse=false)
{
	for($i = count($object) - 1; $i >= 0; $i--) 
	{ 
		$swapped = false; 
		for($j = 0; $j < $i; $j++) 
		{ 
			if(
				(
					isset($object[$j][$key]) && 
					isset($object[$j + 1][$key]) &&

					$reverse? 
						$object[$j][$key] < $object[$j + 1][$key]:
						$object[$j][$key] > $object[$j + 1][$key]
				) ||
				 
				(isset($object[$j][$key]) && !isset($object[$j + 1][$key]))
			)
			{
				$tmp = $object[$j]; 
				$object[$j] = $object[$j + 1];       
				$object[$j + 1] = $tmp; 
				$swapped = true; 
			} 
		} 
		
		if(!$swapped) return $object; 
	}
}




