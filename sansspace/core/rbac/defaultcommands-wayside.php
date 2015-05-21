<?php

define('SSPACE_COMMAND_SEPARATOR', 0);

define('SSPACE_COMMAND_HOME', 1);
define('SSPACE_COMMAND_MY', 2);
define('SSPACE_COMMAND_RECORDER', 3);
define('SSPACE_COMMAND_CHAT', 4);
define('SSPACE_COMMAND_SEARCH', 5);
define('SSPACE_COMMAND_ADMIN', 7);

define('SSPACE_COMMAND_MY_COURSES', 11);
define('SSPACE_COMMAND_MY_FOLDERS', 12);
define('SSPACE_COMMAND_MY_REPORTS', 13);
define('SSPACE_COMMAND_MY_RESOURCES', 14);
define('SSPACE_COMMAND_MY_FAVORITES', 15);
define('SSPACE_COMMAND_MY_SETTINGS', 16);
define('SSPACE_COMMAND_MY_INBOX', 17);

define('SSPACE_COMMAND_USER_CREATE', 21);
define('SSPACE_COMMAND_USER_DELETE', 22);
define('SSPACE_COMMAND_USER_VIEW', 23);
define('SSPACE_COMMAND_USER_EDIT', 24);
define('SSPACE_COMMAND_USER_LOGAS', 25);
define('SSPACE_COMMAND_USER_FOLDER', 26);
define('SSPACE_COMMAND_USER_SESSION', 27);

define('SSPACE_COMMAND_OBJECT_CREATE', 31);
define('SSPACE_COMMAND_OBJECT_DELETE', 32);
define('SSPACE_COMMAND_OBJECT_VIEW', 33);
define('SSPACE_COMMAND_OBJECT_EDIT', 34);
define('SSPACE_COMMAND_OBJECT_BROWSE', 36);
define('SSPACE_COMMAND_OBJECT_IMPORTFOLDER', 37);

define('SSPACE_COMMAND_OBJECT_COPY', 38);
define('SSPACE_COMMAND_OBJECT_CUT', 39);
define('SSPACE_COMMAND_OBJECT_PASTE', 40);

define('SSPACE_COMMAND_OBJECT_CREATE_POST', 41);
define('SSPACE_COMMAND_OBJECT_CREATE_LESSON', 70);
define('SSPACE_COMMAND_OBJECT_CREATE_QUIZ', 74);

define('SSPACE_COMMAND_FILE_DELETE', 42);
define('SSPACE_COMMAND_FILE_VIEW', 43);
define('SSPACE_COMMAND_FILE_EDIT', 44);
define('SSPACE_COMMAND_FILE_DOWNLOAD', 45);
define('SSPACE_COMMAND_FILE_MODIFY', 46);
define('SSPACE_COMMAND_FILE_UPLOAD', 47);
define('SSPACE_COMMAND_FILE_RECORD', 48);
define('SSPACE_COMMAND_FILE_CAPTURE', 49);
define('SSPACE_COMMAND_FILE_INTERNET', 50);

define('SSPACE_COMMAND_COMMENT_CREATE', 51);
define('SSPACE_COMMAND_COMMENT_DELETE', 52);
define('SSPACE_COMMAND_COMMENT_EDIT', 53);
define('SSPACE_COMMAND_COMMENT_VIEW', 56);
define('SSPACE_COMMAND_FILE_TEXT', 54);
define('SSPACE_COMMAND_FILE_YOUTUBE', 55);

define('SSPACE_COMMAND_COURSE_CREATE', 61);
define('SSPACE_COMMAND_COURSE_DELETE', 62);
define('SSPACE_COMMAND_COURSE_VIEW', 63);
define('SSPACE_COMMAND_COURSE_EDIT', 64);
define('SSPACE_COMMAND_COURSE_ADDROSTER', 65);
define('SSPACE_COMMAND_COURSE_ADDUSERS', 66);
define('SSPACE_COMMAND_COURSE_RECORDINGS_TEACHER', 67);
define('SSPACE_COMMAND_COURSE_RECORDINGS_STUDENT', 76);
define('SSPACE_COMMAND_COURSE_REPORT_TEACHER', 68);
define('SSPACE_COMMAND_COURSE_REPORT_STUDENT', 69);
define('SSPACE_COMMAND_COURSE_EDITTEACHER', 161);
//define('SSPACE_COMMAND_COURSE_CREATETEACHER', 162);

define('SSPACE_COMMAND_COURSE_CHAT', 71);
define('SSPACE_COMMAND_ENROLL_ENROLL_SELF', 72);
define('SSPACE_COMMAND_ENROLL_UNENROLL_SELF', 73);
define('SSPACE_COMMAND_ENROLL_UNENROLL_COURSE', 77);
//define('SSPACE_COMMAND_OBJECT_RECENTS', 78);
define('SSPACE_COMMAND_COURSE_CONNECT', 79);

define('SSPACE_COMMAND_QUIZ_VIEW', 81);
define('SSPACE_COMMAND_QUIZ_EDIT', 82);
//define('SSPACE_COMMAND_QUIZ_RESULTS', 83);
define('SSPACE_COMMAND_QUIZ_ADD_QUESTIONS', 84);

define('SSPACE_COMMAND_QUESTION_CREATE_BANK', 85);
define('SSPACE_COMMAND_QUESTION_ADMIN', 86);
define('SSPACE_COMMAND_QUESTION_CREATE', 87);
define('SSPACE_COMMAND_QUESTION_EDIT', 89);
define('SSPACE_COMMAND_QUESTION_IMPORTMOODLE', 88);
define('SSPACE_COMMAND_QUESTION_COPY_QUESTIONS', 90);
define('SSPACE_COMMAND_QUESTION_DELETE_QUESTION', 91);
define('SSPACE_COMMAND_QUESTION_PREVIEW_QUESTION', 92);

define('SSPACE_COMMAND_OBJECT_CREATE_FLASHCARD', 103);
define('SSPACE_COMMAND_FLASHCARD_VIEW', 101);
define('SSPACE_COMMAND_FLASHCARD_EDIT', 102);

define('SSPACE_COMMAND_OBJECT_CREATE_SURVEY', 110);
define('SSPACE_COMMAND_SURVEY_VIEW', 111);
define('SSPACE_COMMAND_SURVEY_EDIT', 112);
define('SSPACE_COMMAND_SURVEY_CREATE', 113);
define('SSPACE_COMMAND_SURVEY_RESULTS', 115);

define('SSPACE_COMMAND_OBJECT_CREATE_TEXTBOOK', 120);
define('SSPACE_COMMAND_TEXTBOOK_ACCESSCODE', 122);
define('SSPACE_COMMAND_TEXTBOOK_UPLOAD', 123);
define('SSPACE_COMMAND_TEXTBOOK_ADDCODE', 124);
define('SSPACE_COMMAND_TEXTBOOK_ADDCOURSE', 125);

function RbacDefaultCommands()
{
	$commands = array(

		array(
			'id'=>SSPACE_COMMAND_HOME,
			'name'=>'My Learning Site',
			'description'=>'Tab Menu',
			'url'=>'my/',
			'roles'=>array(SSPACE_ROLE_USER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_MY,
			'name'=>'Announcement',
			'description'=>'Tab Menu',
			'url'=>'site/announcement',
			'roles'=>array(),
		),

		array(
			'id'=>SSPACE_COMMAND_RECORDER,
			'name'=>'Users',
			'description'=>'Tab Menu',
			'url'=>'user/',
			'roles'=>array(),
		),

		array(
			'id'=>SSPACE_COMMAND_CHAT,
			'name'=>'Permissions',
			'description'=>'Tab Menu',
			'url'=>'permission/',
			'roles'=>array(),
		),

		array(
			'id'=>SSPACE_COMMAND_ADMIN,
			'name'=>'Admin',
			'description'=>'Tab Menu',
			'url'=>'admin/',
			'roles'=>array(),
		),

		array(
			'id'=>SSPACE_COMMAND_SEARCH,
			'name'=>'Search site',
			'description'=>'Tab Menu',
			'url'=>'search/',
			'roles'=>array(),
		),

		//////////////////////////////////////////////////////////////////////////

		array(
			'id'=>SSPACE_COMMAND_MY_COURSES,
			'name'=>'My Courses',
			'description'=>'My SANSSpace',
			'url'=>'my/courses',
			'icon'=>'/{iconset}/courses.png',
			'roles'=>array(SSPACE_ROLE_USER),
		),

		array(
			'id'=>SSPACE_COMMAND_MY_FOLDERS,
			'name'=>'My Saved Work',
			'description'=>'My SANSSpace',
			'url'=>'my/folders',
			'icon'=>'/{iconset}/myfolders.png',
			'roles'=>array(SSPACE_ROLE_USER),
		),

		array(
			'id'=>SSPACE_COMMAND_MY_REPORTS,
			'name'=>'My Reports',
			'description'=>'My SANSSpace',
			'url'=>'my/reports',
			'icon'=>'/{iconset}/reports.png',
			'roles'=>array(SSPACE_ROLE_USER),
		),

		array(
			'id'=>SSPACE_COMMAND_MY_RESOURCES,
			'name'=>'Other Resources',
			'description'=>'My SANSSpace',
			'url'=>'my/locations',
			'icon'=>'/{iconset}/resources.png',
			'roles'=>array(SSPACE_ROLE_USER),
		),

		array(
			'id'=>SSPACE_COMMAND_MY_FAVORITES,
			'name'=>'My Favorites',
			'description'=>'My SANSSpace',
			'url'=>'my/favorites',
			'icon'=>'/{iconset}/favorites.png',
			'roles'=>array(SSPACE_ROLE_USER),
		),

		array(
			'id'=>SSPACE_COMMAND_MY_SETTINGS,
			'name'=>'My Settings',
			'description'=>'My SANSSpace',
			'url'=>'my/settings',
			'icon'=>'/{iconset}/settings.png',
			'roles'=>array(SSPACE_ROLE_USER),
		),

		array(
			'id'=>SSPACE_COMMAND_MY_INBOX,
			'name'=>'My Inbox',
			'description'=>'My SANSSpace',
			'url'=>'pm/',
			'icon'=>'/{iconset}/inbox.png',
			'roles'=>array(SSPACE_ROLE_USER),
		),

		/////////////////////////////////////////////////////////////////////////////////////

		array(
			'id'=>SSPACE_COMMAND_OBJECT_CREATE,
			'name'=>'New Folder',
			'description'=>'Folder',
			'title'=>'Create a new folder',
			'url'=>'object/create',
			'objecttype'=>true,
			'icon'=>'/images/base/newfolder.png',
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER),
		),

		array(
			'id'=>SSPACE_COMMAND_OBJECT_DELETE,
			'name'=>'Delete',
			'description'=>'Folder',
			'url'=>'object/delete',
			'objecttype'=>true,
			'icon'=>'/images/base/delete.png',
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER),
		),

		array(
			'id'=>SSPACE_COMMAND_OBJECT_VIEW,
			'name'=>'View Folder',
			'description'=>'Folder',
			'url'=>'object/',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_ALL),
		),

// 		array(
// 			'id'=>SSPACE_COMMAND_OBJECT_RECENTS,
// 			'name'=>'Show Recents',
// 			'description'=>'Folder',
// 			'url'=>'object/recents',
// 			'objecttype'=>true,
// 			'roles'=>array(SSPACE_ROLE_ALL),
// 		),

		array(
			'id'=>SSPACE_COMMAND_OBJECT_EDIT,
			'name'=>'Properties',
			'description'=>'Folder',
			'title'=>'Edit the object\'s properties',
			'url'=>'object/update',
			'objecttype'=>true,
			'icon'=>'/images/base/edit.png',
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_OBJECT_COPY,
			'name'=>'Copy',
			'description'=>'Folder',
			'url'=>'object/commandcopy',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_USER),
		),

		array(
			'id'=>SSPACE_COMMAND_OBJECT_CUT,
			'name'=>'Cut',
			'description'=>'Folder',
			'url'=>'object/commandcut',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER),
		),

		array(
			'id'=>SSPACE_COMMAND_OBJECT_PASTE,
			'name'=>'Paste',
			'description'=>'Folder',
			'url'=>'object/commandpaste',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER),
		),

		array(
			'id'=>SSPACE_COMMAND_OBJECT_BROWSE,
			'name'=>'Browse Server',
			'description'=>'File',
			'title'=>'Browse the server for contents to add to this folder',
			'url'=>'object/createlink',
			'objecttype'=>true,
			'icon'=>'/images/base/folders.png',
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_OBJECT_IMPORTFOLDER,
			'name'=>'Import Folder',
			'description'=>'Folder',
			'title'=>'Import a folder from the operating system storage.',
			'url'=>'object/importfolder',
			'icon'=>'/images/base/newfolder.png',
			'createitem'=>true,
			'roles'=>array(),
		),

		array(
			'id'=>SSPACE_COMMAND_OBJECT_CREATE_POST,
			'name'=>'New Forum Post',
			'description'=>'Folder',
			'title'=>'Create a new forum.',
			'url'=>'object/createforum',
			'objecttype'=>true,
			'icon'=>'/images/base/newfolder.png',
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_FORUM),
		),

		////////////////////////////////////////////////////////////////////////////////////////

		array(
			'id'=>SSPACE_COMMAND_FILE_UPLOAD,
			'name'=>'Upload Files',
			'description'=>'File',
			'title'=>'Upload files from your computer to this folder',
			'url'=>'file/upload',
			'objecttype'=>true,
			'icon'=>'/images/base/upload.png',
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER, SSPACE_ROLE_FORUM),
		),
			
		array(
			'id'=>SSPACE_COMMAND_FILE_RECORD,
			'name'=>'New Recording',
			'description'=>'File',
			'title'=>'Record a new audio/video file to this folder',
			'url'=>'recorder/record',
			'objecttype'=>true,
			'icon'=>'/images/base/record.png',
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER, SSPACE_ROLE_FORUM),
		),

		array(
			'id'=>SSPACE_COMMAND_FILE_CAPTURE,
			'name'=>'Screen Capture',
			'description'=>'File',
			'title'=>'Record a screen capture',
			'url'=>'recorder/screencapture',
			'objecttype'=>true,
			'icon'=>'/images/base/screen.png',
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_FILE_INTERNET,
			'name'=>'New Internet Link',
			'description'=>'File',
			'title'=>'Create a link to an internet resource',
			'url'=>'file/createinternet',
			'objecttype'=>true,
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_FILE_TEXT,
			'name'=>'New Text File',
			'description'=>'File',
			'title'=>'Create a text file in this folder',
			'url'=>'file/createtext',
			'objecttype'=>true,
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER, SSPACE_ROLE_FORUM),
		),
			
		array(
			'id'=>SSPACE_COMMAND_FILE_YOUTUBE,
			'name'=>'Import Youtube',
			'description'=>'File',
			'title'=>'Import a Youtube video to this folder',
			'url'=>'file/createyoutube',
			'objecttype'=>true,
			'createitem'=>true,
			'roles'=>array(),
		),
			
		array(
			'id'=>SSPACE_COMMAND_FILE_DELETE,
			'name'=>'Delete File',
			'description'=>'File',
			'url'=>'file/delete',
			'objecttype'=>true,
			'inherit'=>false,
			'icon'=>'/images/base/delete.png',
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER),
		),

		array(
			'id'=>SSPACE_COMMAND_FILE_VIEW,
			'name'=>'View File',
			'description'=>'File',
			'url'=>'file/',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_ALL),
		),

		array(
			'id'=>SSPACE_COMMAND_FILE_EDIT,
			'name'=>'File Properties',
			'description'=>'File',
			'title'=>'Edit the file\'s properties',
			'url'=>'file/update',
			'objecttype'=>true,
			'icon'=>'/images/base/edit.png',
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_FILE_DOWNLOAD,
			'name'=>'Download File',
			'description'=>'File',
			'title'=>'Download the file to your computer',
			'url'=>'file/download',
			'objecttype'=>true,
			'icon'=>'/images/base/download.png',
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER),
		),

		array(
			'id'=>SSPACE_COMMAND_FILE_MODIFY,
			'name'=>'Edit File',
			'description'=>'File',
			'title'=>'Edit the file',
			'url'=>'file/edit',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER),
		),

		////////////////////////////////////////////////////////////////////////////////////////

		array(
			'id'=>SSPACE_COMMAND_COMMENT_CREATE,
			'name'=>'Add Comment',
			'description'=>'Comment',
			'url'=>'comment/create',
			'objecttype'=>true,
			'icon'=>'/images/base/newcomment.png',
			'roles'=>array(SSPACE_ROLE_STUDENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_CONTENT, SSPACE_ROLE_FORUM),
		),

		array(
			'id'=>SSPACE_COMMAND_COMMENT_DELETE,
			'name'=>'Delete',
			'description'=>'Comment',
			'url'=>'comment/delete',
			'objecttype'=>true,
			'icon'=>'/images/base/delete.png',
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER),
		),

		array(
			'id'=>SSPACE_COMMAND_COMMENT_EDIT,
			'name'=>'Edit',
			'description'=>'Comment',
			'url'=>'comment/update',
			'objecttype'=>true,
			'icon'=>'/images/base/edit.png',
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_OWNER),
		),

		////////////////////////////////////////////////////////////////////////////////////////

		array(
			'id'=>SSPACE_COMMAND_COURSE_CREATE,
			'name'=>'New Course',
			'description'=>'Course',
			'title'=>'Create a new course in this folder',
			'url'=>'course/create',
			'objecttype'=>true,
			'icon'=>'/images/base/course.png',
			'createitem'=>true,
			'roles'=>array(),
		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_DELETE,
			'name'=>'Delete',
			'description'=>'Course',
			'url'=>'course/delete',
			'objecttype'=>true,
			'icon'=>'/images/base/delete.png',
			'roles'=>array(),
		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_VIEW,
			'name'=>'View',
			'description'=>'Course',
			'url'=>'course/',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_USER),
		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_EDIT,
			'name'=>'Properties',
			'description'=>'Course',
			'title'=>'Edit the course\'s properties',
			'url'=>'course/update',
			'icon'=>'/images/base/edit.png',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT),
		),

// 		array(
// 			'id'=>SSPACE_COMMAND_COURSE_CREATETEACHER,
// 			'name'=>'Create Course',
// 			'description'=>'Course',
// 			'title'=>'Edit the course\'s properties',
// 			'url'=>'course/createteacher',
// 			'objecttype'=>true,
// 			'icon'=>'/images/base/course.png',
// 			'createitem'=>true,
// 			'roles'=>array(SSPACE_ROLE_USER),
// 		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_EDITTEACHER,
			'name'=>'Edit Course',
			'description'=>'Course',
			'title'=>'Edit the course\'s properties',
			'url'=>'course/updateteacher',
			'icon'=>'/images/base/edit.png',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_ADDROSTER,
			'name'=>'Import Roster',
			'description'=>'Course',
			'title'=>'Use text roster file to add users to the course',
			'url'=>'course/addroster',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_ADDUSERS,
			'name'=>'Add/Enroll Students',
			'description'=>'Course',
			'title'=>'Enroll users to the course',
			'url'=>'course/addusers',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_RECORDINGS_TEACHER,
			'name'=>'Students\' Work',
			'title'=>'Show the students\' work',
			'description'=>'Course',
			'url'=>'course/recordings',
			'icon'=>'/{iconset}/myfolders.png',
			'objecttype'=>true,
			'inherit'=>true,
			'roles'=>array(SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_RECORDINGS_STUDENT,
			'name'=>'My Saved Work',
			'title'=>'Show my saved work for the course',
			'description'=>'Course',
			'url'=>'course/myrecordings',
			'icon'=>'/{iconset}/myfolders.png',
			'objecttype'=>true,
			'hideadmin'=>true,
			'roles'=>array(SSPACE_ROLE_STUDENT),
		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_REPORT_TEACHER,
			'name'=>'Students\' Reports',
			'description'=>'Course',
			'title'=>'Show the students\' reports',
			'url'=>'teacherreport/',
			'icon'=>'/{iconset}/reports.png',
			'objecttype'=>true,
			'inherit'=>true,
			'roles'=>array(SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_REPORT_STUDENT,
			'name'=>'My Report',
			'description'=>'Course',
			'title'=>'Show my report',
			'url'=>'studentreport/',
			'icon'=>'/{iconset}/reports.png',
			'objecttype'=>true,
			'hideadmin'=>true,
			'inherit'=>true,
			'roles'=>array(SSPACE_ROLE_STUDENT, SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_OBJECT_CREATE_LESSON,
			'name'=>'New Lesson',
			'title'=>'Create a new lesson',
			'description'=>'Folder',
			'url'=>'object/createlesson',
			'objecttype'=>true,
		//	'icon'=>'/images/base/course.png',
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_OBJECT_CREATE_QUIZ,
			'name'=>'New Quiz',
			'description'=>'Folder',
			'title'=>'Create a new quiz',
			'url'=>'object/createquiz',
			'objecttype'=>true,
		//	'icon'=>'/images/base/course.png',
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_CHAT,
			'name'=>'Chat',
			'description'=>'Course',
			'title'=>'Connect to the course\'s chat',
			'url'=>'chat/',
			'objecttype'=>true,
			'icon'=>'/{iconset}/chat.png',
			'inherit'=>true,
			'roles'=>array(SSPACE_ROLE_TEACHER, SSPACE_ROLE_STUDENT, SSPACE_ROLE_CONTENT),
		),

		array(
			'id'=>SSPACE_COMMAND_COURSE_CONNECT,
			'name'=>'Connect',
			'description'=>'Course',
			'title'=>'Connect to the course\'s synchronous workplace',
			'url'=>'connect/',
			'objecttype'=>true,
			'inherit'=>true,
			'icon'=>'/{iconset}/chat.png',
			'roles'=>array(SSPACE_ROLE_TEACHER, SSPACE_ROLE_STUDENT, SSPACE_ROLE_CONTENT),
		),

		array(
			'id'=>SSPACE_COMMAND_ENROLL_ENROLL_SELF,
			'name'=>'Self Enroll',
			'description'=>'Course',
			'title'=>'Enroll in the course',
			'url'=>'enroll/enroll',
			'objecttype'=>true,
			'icon'=>'/images/base/enroll.png',
			'roles'=>array(SSPACE_ROLE_USER),
		),

		array(
			'id'=>SSPACE_COMMAND_ENROLL_UNENROLL_SELF,
			'name'=>'Self Unenroll',
			'description'=>'Course',
			'title'=>'Unenroll from the course',
			'url'=>'enroll/unenroll',
			'objecttype'=>true,
			'icon'=>'/images/base/delete.png',
			'roles'=>array(SSPACE_ROLE_USER),
		),

		array(
			'id'=>SSPACE_COMMAND_ENROLL_UNENROLL_COURSE,
			'name'=>'Unenroll Users',
			'description'=>'Course',
			'title'=>'Unenroll from the course',
			'url'=>'enroll/deletecourse',
			'objecttype'=>true,
			'icon'=>'/images/base/delete.png',
			'roles'=>array(SSPACE_ROLE_TEACHER),
		),

		//////////////////////////////////////////////////////////////////////////

		array(
			'id'=>SSPACE_COMMAND_QUIZ_VIEW,
			'name'=>'Attempt Quiz',
			'description'=>'Quiz',
			'url'=>'quiz/',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_STUDENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_CONTENT),
		),

		array(
			'id'=>SSPACE_COMMAND_QUIZ_EDIT,
			'name'=>'Edit Quiz',
			'description'=>'Quiz',
			'url'=>'quiz/update',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_CONTENT),
		),

// 		array(
// 			'id'=>SSPACE_COMMAND_QUIZ_RESULTS,
// 			'description'=>'Quiz',
// 			'name'=>'Quiz Results',
// 			'url'=>'quiz/teacher',
// 			'objecttype'=>true,
// 			'roles'=>array(SSPACE_ROLE_TEACHER),
// 		),

		array(
			'id'=>SSPACE_COMMAND_QUIZ_ADD_QUESTIONS,
			'description'=>'Quiz',
			'name'=>'Add Questions',
			'url'=>'quiz/addquestions',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_CONTENT),
		),
			
		////////////////////////////////////////////////////////////////////////
		
		array(
			'id'=>SSPACE_COMMAND_QUESTION_CREATE_BANK,
			'name'=>'New Question Bank',
			'description'=>'Quiz',
			'url'=>'question/createbank',
			'objecttype'=>true,
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_QUESTION_ADMIN,
			'name'=>'List Questions',
			'description'=>'Quiz',
			'url'=>'question/admin',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_QUESTION_CREATE,
			'name'=>'New Question',
			'description'=>'Quiz',
			'url'=>'question/create',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_QUESTION_EDIT,
			'name'=>'Edit Question',
			'description'=>'Quiz',
			'url'=>'question/update',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_QUESTION_DELETE_QUESTION,
			'name'=>'Delete Question',
			'description'=>'Quiz',
			'url'=>'question/delete',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_QUESTION_PREVIEW_QUESTION,
			'name'=>'Preview Question',
			'description'=>'Quiz',
			'url'=>'question/preview',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),

		array(
			'id'=>SSPACE_COMMAND_QUESTION_IMPORTMOODLE,
			'name'=>'Import Moodle XML',
			'description'=>'Quiz',
			'url'=>'question/importmoodle',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_QUESTION_COPY_QUESTIONS,
			'name'=>'Copy Questions',
			'description'=>'Quiz',
			'title'=>'Copy questions from another bank',
			'url'=>'question/copyquestions',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_OBJECT_CREATE_FLASHCARD,
			'name'=>'New Flashcards',
			'description'=>'Flashcard',
			'url'=>'object/createflashcard',
			'objecttype'=>true,
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_FLASHCARD_VIEW,
			'name'=>'View Flashcards',
			'description'=>'Flashcard',
			'url'=>'flashcard/view',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_ALL),
		),
			
		array(
			'id'=>SSPACE_COMMAND_FLASHCARD_EDIT,
			'name'=>'Edit Flashcards',
			'description'=>'Flashcard',
			'url'=>'flashcard/admin',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_OBJECT_CREATE_SURVEY,
			'name'=>'New Survey',
			'description'=>'Survey',
			'url'=>'object/createsurvey',
			'objecttype'=>true,
			'createitem'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_SURVEY_VIEW,
			'name'=>'Take Survey',
			'description'=>'Survey',
			'url'=>'survey/view',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_STUDENT, SSPACE_ROLE_TEACHER, SSPACE_ROLE_CONTENT),
		),
			
		array(
			'id'=>SSPACE_COMMAND_SURVEY_EDIT,
			'name'=>'Edit Survey',
			'description'=>'Survey',
			'url'=>'survey/admin',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_SURVEY_CREATE,
			'name'=>'New Question',
			'description'=>'Survey',
			'url'=>'survey/create',
			'objecttype'=>true,
			'inherit'=>false,
			'roles'=>array(SSPACE_ROLE_CONTENT, SSPACE_ROLE_TEACHER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_SURVEY_RESULTS,
			'name'=>'View Results',
			'description'=>'Survey',
			'url'=>'survey/results',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_ALL),
		),
			
		array(
			'id'=>SSPACE_COMMAND_OBJECT_CREATE_TEXTBOOK,
			'name'=>'New Textbook',
			'description'=>'Textbook',
			'url'=>'object/createtextbook',
			'objecttype'=>true,
			'createitem'=>true,
			'roles'=>array(SSPACE_ROLE_CONTENT),
		),
			
		array(
			'id'=>SSPACE_COMMAND_TEXTBOOK_ACCESSCODE,
			'name'=>'Access Codes',
			'description'=>'Textbook',
			'url'=>'textbook/',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_CONTENT),
		),
			
		array(
			'id'=>SSPACE_COMMAND_TEXTBOOK_UPLOAD,
			'name'=>'Upload Code List',
			'description'=>'Textbook',
			'url'=>'textbook/upload',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_CONTENT),
		),
			
		array(
			'id'=>SSPACE_COMMAND_TEXTBOOK_ADDCODE,
			'name'=>'Add Code',
			'description'=>'Textbook',
			'url'=>'textbook/addstudentcode',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_USER),
		),
			
		array(
			'id'=>SSPACE_COMMAND_TEXTBOOK_ADDCOURSE,
			'name'=>'Add Course',
			'description'=>'Textbook',
			'url'=>'textbook/addteachercourse',
			'objecttype'=>true,
			'roles'=>array(SSPACE_ROLE_USER),
		),
			
	);
	
	return $commands;
}

function RbacFindDefaultCommands($id)
{
	$commands = RbacDefaultCommands();
	foreach($commands as $command)
	{
		if($command['id'] == $id)
			return $command;
	}
	
	return null;
}

function RbacDefaultCommandEquivalent()
{
	$commands = array(
		array(
			'id'=>SSPACE_COMMAND_COURSE_EDIT,
			'url'=>'permission/saveobject',
		),
			
		array(
			'id'=>SSPACE_COMMAND_COURSE_EDIT,
			'url'=>'permission/resetobject',
		),

		array(
			'id'=>SSPACE_COMMAND_FILE_VIEW,
			'url'=>'file/trackdoc',
		),

	);
	
	return $commands;
}




