<?php

function showAdminHeader($i)
{
	$adminoptions = getAdminOptions();

	echo "<p><b>";
	echo l("Admin", array('admin/'))." => {$adminoptions[$i]['title']} => ";
	foreach($adminoptions[$i]['options'] as $a)
		echo l($a['name'], $a['url']).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	echo "</b></p>";
}

function getAdminOptions()
{
	$result = array(

	array('title'=>'Site', 'options'=>array(

		array('name'=>'Config', 'url'=>array('server/config'),
			'description'=>'Configure site parameters.'),

		array('name'=>'Custom Tabs', 'url'=>array('tabmenu/'),
			'description'=>'Add custom tab menu items.'),

		array('name'=>'Semesters', 'url'=>array('semester/'),
			'description'=>'Configure the semesters used by this server.'),

		array('name'=>'Courses', 'url'=>array('admin/courses'),
			'description'=>'Show all courses.'),

	//	array('name'=>'Contacts', 'url'=>array('contact/'),
	//		'description'=>'Show the contact feedbacks entered by users.'),

	//	array('name'=>'Information', 'url'=>array('server/info'),
	//		'description'=>'Show the site system information (read only).'),

	//	array('name'=>'Aliases', 'url'=>array('alias/'),
	//		'description'=>'Manage url shortcut aliases.'),

	),),

	array('title'=>'Tracking', 'options'=>array(

		array('name'=>'Sessions', 'url'=>array('session/'),
			'description'=>'Users sessions reports.'),

		array('name'=>'File Sessions', 'url'=>array('filesession/'),
			'description'=>'File usage reports.'),

		array('name'=>'Record Sessions', 'url'=>array('recordsession/'),
			'description'=>'Recorder usage reports.'),

		array('name'=>'Custom', 'url'=>array('export/'),
			'description'=>'Manage custom report templates.'),

		array('name'=>'Clients', 'url'=>array('client/'),
			'description'=>'List all the computers that connected to this server.'),

	),),

	array('title'=>'Users', 'options'=>array(

		array('name'=>'Users', 'url'=>array('user/'),
			'description'=>'Manage users on this server.'),

		array('name'=>'Domains', 'url'=>array('domain/'),
			'description'=>'Configure the authentication domains used by this server.'),

		array('name'=>'Roster', 'url'=>array('roster/'),
			'description'=>'Manage and upload roster files.'),
			
//		array('name'=>'Fields', 'url'=>array('register/'),
//			'description'=>'Choose the required fields for user registration.'),

		array('name'=>'Roles', 'url'=>array('roles/'),
				'description'=>'Manage roles.'),

		array('name'=>'Permissions', 'url'=>array('permission/'),
			'description'=>'Manage permissions.'),

// 		array('name'=>'Shortcuts', 'url'=>array('shortcut/'),
// 			'description'=>'Manage shortcuts.'),

		array('name'=>'Enrollments', 'url'=>array('enroll/'),
			'description'=>'Manage enrollments.'),

	),),

	array('title'=>'Contents', 'options'=>array(

		array('name'=>'Transcodes', 'url'=>array('transcode/'),
			'description'=>'Manage the transcode templates used by this server.'),

		array('name'=>'Admin Search', 'url'=>array('admin/search'),
			'description'=>'Search Contents.'),

		array('name'=>'Folder Imports', 'url'=>array('import/'),
			'description'=>'Manage the folder imports used by this server.'),

	//	array('name'=>'Categories', 'url'=>array('category/'),
	//		'description'=>'Manage Categories.'),

	),),

	array('title'=>'Advanced', 'options'=>array(

		array('name'=>'Backup', 'url'=>array('backup/'),
			'description'=>'Backup and restore the database.'),

		array('name'=>'Cron Jobs', 'url'=>array('cronjob/'),
			'description'=>'Manage the cron jobs on this server.'),

	),),

	array('title'=>'System', 'adminonly'=>true, 'options'=>array(

		array('name'=>'Info', 'url'=>array('server/info'),
			'description'=>'Show the system settings.'),

// 		array('name'=>'License', 'url'=>array('server/license'),
// 			'description'=>'Set the server serial number.'),

		array('name'=>'Time Zone', 'url'=>array('server/timezone'),
			'description'=>'Set the server time zone.'),

		array('name'=>'Software Update', 'url'=>array('admin/maintenance'),
			'description'=>'Update information and restart service.'),

		array('name'=>'Restart Service', 'url'=>array('admin/restart'),
			'description'=>'Restart the SANSSpace service.'),

//		array('name'=>'Logs', 'url'=>array('admin/logs'),
//			'description'=>'View the server logs.'),

	),),

	array('title'=>'Network', 'adminonly'=>true, 'options'=>array(

		array('name'=>'Socket Bindings', 'url'=>array('server/bindings'),
			'description'=>'Manage TCP/IP socket bindings.'),

		array('name'=>'Certificates', 'url'=>array('certificate/'),
			'description'=>'Manage digital certificates for encrypted connections.'),

		array('name'=>'SMTP', 'url'=>array('server/smtp'),
			'description'=>'Configure the Simple Mail Transport Protocol connection.'),

	//	array('name'=>'WebDAV', 'url'=>array('site/webdav'),
	//		'description'=>'Manage the WebDAV interface.'),

	),),

	);

	if(	$_SERVER['SERVER_NAME'] == 'inside.sansspace.com' ||
	//	$_SERVER['SERVER_NAME'] == 'localhost' ||
		$_SERVER['SERVER_NAME'] == 'system.sansspace.com')
	{
		$result[0]['options'][] = array('name'=>'Hosts', 'url'=>array('sansspacehost/'),
			'description'=>'List of Sansspace installations.');

	//	$result[0]['options'][] = array('name'=>'Multisite', 'url'=>array('multisite/'),
	//		'description'=>'Multisite configuration.');
	}

// 	if($_SERVER['SERVER_NAME'] == 'localhost')
// 	{
// 		$result[0]['options'][] = array('name'=>'Debug', 'url'=>array('admin/debug'),
// 			'description'=>'.');
// 	}

	return $result;
}

//		array('name'=>'Relay', 'url'=>array('site/relay'),
//			'description'=>'Configure the network relay connection.'),

//		array('name'=>'Downloads', 'url'=>array('download/'),
//			'description'=>'Manage the download templates used by this server.'),



