<?php

// function RbacFilterException2($url)
// {
// 	$controller = substr($url, 0, strpos($url, '/'));
// 	$action = substr($url, strpos($url, '/')+1);
	
// 	return RbacFilterException($controller, $action);
// }

function RbacFilterException($controller, $action)
{
	if(getparam('internaluser') == 'system') return true;
	if(strstr($action, 'internal')) return true;
	if(strstr($action, 'result')) return true;

	switch($controller)
	{
		case 'xml':
		case 'simplexml':
		case 'html':
		case 'bookmark':
		case 'internal':
		case 'login':
		case 'connection':
	//	case 'role':
			return true;

		case 'quiz':
	//	case 'question':
		case 'favorite':
		case 'chat':
		case 'pm':		// TODO: HERE: permissions for show=id
		case 'report':
		case 'my':
		case 'survey':
		case 'flashcard':
			if(user()->isGuest)
				return false;

			return true;

		case 'recorder':
			if(user()->isGuest)
				return false;
			
			if($action == 'record') return false;
			return true;
				
		case 'file':
			if(	$action == 'saverecording' ||
				$action == 'newrecording' ||
				$action == 'record' && !isset($_GET['id']))
				return true;
			break;

		case 'user':
			if(	$action == 'recover' ||
				$action == 'online' ||
				$action == 'menuuser' ||
				$action == 'autoCompleteLookup' ||
				$action == 'autoCompleteLookup2')
				return true;
			break;

		case 'course':
			if($action == 'chat') return true;
			if($action == 'createteacher') return true;
			break;

		case 'object':
			if(	$action == 'autoCompleteObject' ||
			$action == 'autoCompleteObject2' ||
			$action == 'autoCompleteCourse' ||
			$action == 'autoCompleteCourseActivity' ||
			$action == 'headobjectbrowser' ||
			$action == 'listobjectbrowser' ||
			$action == 'leavepage' ||
			$action == 'setorder' ||
			$action == 'autoCompletePage')
				return true;
			break;

		case 'site':
			if($action != 'config') return true;
			break;
			
		case 'sansspacehost':
			switch($action)
			{
				case 'version':
				case 'download':
				case 'ping':
				case 'ping2':
				case 'pingmaster':
					return true;
			}
			
			break;

		case 'textbook':
			if($action == 'studentenroll') return true;
			break;
			
	}
	
	return false;
}
