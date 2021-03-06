<?php

define('CMDB_ENROLLSTATUS_NONE', 0);
define('CMDB_ENROLLSTATUS_STARTED', 1);
define('CMDB_ENROLLSTATUS_COMPLETED', 2);
define('CMDB_ENROLLSTATUS_PASSED', 3);
define('CMDB_ENROLLSTATUS_FAILED', 4);
define('CMDB_ENROLLSTATUS_CANCELLED', 5);
define('CMDB_ENROLLTYPE_USER', 1);
define('CMDB_ENROLLTYPE_GROUP', 2);
define('CMDB_ENROLLTYPE_ROLE', 3);
define('CMDB_DEFAULT_DOMAINID', 1);
define('CMDB_DOMAIN_SIMPLE', 0);
define('CMDB_DOMAIN_MSN', 1);
define('CMDB_DOMAIN_NTLM', 2);
define('CMDB_DOMAIN_DPA', 3);
define('CMDB_DOMAIN_NEGOTIATE', 4);
define('CMDB_DOMAIN_DIGEST', 5);
define('CMDB_DOMAIN_EXTERNAL', 6);
define('CMDB_USERSTATUS_ONLINE', 1);
define('CMDB_USERSTATUS_AWAY', 2);
define('CMDB_USERSTATUS_BUSY', 3);
define('CMDB_USERSTATUS_OFFLINE', 4);
define('CMDB_USERCODE_UNUSED', 1);
define('CMDB_USERCODE_USED', 2);
define('CMDB_USERCODE_EXPIRED', 3);
define('CMDB_USERCODE_REVOKED', 4);
define('FLV_INDEX_EXTENSION2', ".index2");
define('CMDB_OBJECTTRANSCODE_NONE', 0);
define('CMDB_OBJECTTRANSCODE_QUEUED', 1);
define('CMDB_OBJECTTRANSCODE_CURRENT', 2);
define('CMDB_OBJECTTRANSCODE_COMPLETE', 3);
define('CMDB_OBJECTTRANSCODE_NATIVE', 4);
define('CMDB_OBJECTTRANSCODE_QUEUED2', 5);
define('CMDB_OBJECTTRANSCODE_ERROR', 6);
define('CMDB_OBJECTTRANSCODE_INDEXING', 7);
define('CMDB_OBJECTTRANSCODE_QUEUED3', 8);
define('CMDB_OBJECTROOT_ID', 1);
define('CMDB_OBJECTTYPE_OBJECT', 0);
define('CMDB_OBJECTTYPE_FILE', 1);
define('CMDB_OBJECTTYPE_COURSE', 2);
define('CMDB_OBJECTTYPE_ACTIVITY', 3);
define('CMDB_OBJECTTYPE_LINK', 4);
define('CMDB_OBJECTTYPE_QUESTIONBANK', 5);
define('CMDB_OBJECTTYPE_FLASHCARD', 6);
define('CMDB_OBJECTTYPE_SURVEY', 7);
define('CMDB_OBJECTTYPE_LESSON', 8);
define('CMDB_OBJECTTYPE_QUIZ', 9);
define('CMDB_OBJECTTYPE_TEXTBOOK', 10);
define('CMDB_OBJECTENROLLTYPE_NONE', 1);
define('CMDB_OBJECTENROLLTYPE_AUTOUSER', 2);
define('CMDB_OBJECTENROLLTYPE_SELF', 3);
define('CMDB_OBJECTENROLLTYPE_APPROVAL', 4);
define('CMDB_OBJECTENROLLTYPE_AUTOSTUDENT', 5);
define('CMDB_OBJECTSCAN_NONE', 0);
define('CMDB_OBJECTSCAN_READY', 1);
define('CMDB_OBJECTSCAN_BUSY', 2);
define('CMDB_OBJECTSCAN_PENDING', 3);
define('CMDB_OBJECTSCAN_THUMBNAILS', 4);
define('CMDB_ALLRESOURCESNAME', "All Resources");
define('CMDB_LANGUAGECOURSESNAME', "Language Courses");
define('CMDB_PERSONALFOLDERNAME', "Personal Folders");
define('CMDB_FILETYPE_UNKNOWN', 0);
define('CMDB_FILETYPE_LINK', 1);
define('CMDB_FILETYPE_MEDIA', 2);
define('CMDB_FILETYPE_APPLICATION', 3);
define('CMDB_FILETYPE_DOCUMENT', 4);
define('CMDB_FILETYPE_URL', 5);
define('CMDB_FILETYPE_SOLOIST', 6);
define('CMDB_FILETYPE_INSTALL', 7);
define('CMDB_FILETYPE_TEXT', 8);
define('CMDB_FILETYPE_DVD', 9);
define('CMDB_FILETYPE_IMAGE', 10);
define('CMDB_FILETYPE_SWF', 11);
define('CMDB_FILETYPE_PDF', 12);
define('CMDB_FILETYPE_SRT', 13);
define('CMDB_FILETYPE_BOOKMARKS', 14);
define('CMDB_FILETYPE_LIVE', 16);
define('CMDB_ACTIVITYTYPE_NONE', 0);
define('CMDB_ACTIVITYTYPE_PLAY', 1);
define('CMDB_ACTIVITYTYPE_RECORD', 2);
define('CMDB_ACTIVITYTYPE_READ', 3);
define('CMDB_ACTIVITYTYPE_WRITE', 4);
define('CMDB_ACTIVITYTYPE_APPROVAL', 5);
define('CMDB_ACTIVITYTYPE_QUIZ', 6);
define('CMDB_ACTIVITYTYPE_LESSON', 7);
define('CMDB_COURSEACCESS_NONE', 0);
define('CMDB_COURSEACCESS_READ', 1);
define('CMDB_COURSEACCESS_WRITE', 2);
define('CMDB_QUIZEXPIRED_NONE', 0);
define('CMDB_QUIZEXPIRED_SUBMIT', 1);
define('CMDB_QUIZEXPIRED_IGNORE', 2);
define('CMDB_QUIZGRADING_NONE', 0);
define('CMDB_QUIZGRADING_HIGH', 1);
define('CMDB_QUIZGRADING_AVG', 2);
define('CMDB_QUIZGRADING_FIRST', 3);
define('CMDB_QUIZGRADING_LAST', 4);
define('CMDB_QUIZQUESTION_NONE', 0);
define('CMDB_QUIZQUESTION_LONGTEXT', 1);
define('CMDB_QUIZQUESTION_SELECT', 3);
define('CMDB_QUIZQUESTION_RECORD', 4);
define('CMDB_QUIZQUESTION_SHORTTEXT', 5);
define('CMDB_QUIZQUESTION_CLOZE', 6);
define('CMDB_QUIZQUESTION_MATCHING', 7);
define('CMDB_QUIZQUESTION_TRUE', 11);
define('CMDB_QUIZQUESTION_FALSE', 12);
define('CMDB_QUIZQUESTION_COMPARATIVE', 13);
define('CMDB_ENUMTYPE_NONE', 0);
define('CMDB_ENUMTYPE_NUMBER', 1);
define('CMDB_ENUMTYPE_LETTERUP', 2);
define('CMDB_ENUMTYPE_LETTERLOW', 3);
define('CMDB_ENUMTYPE_ROMANUP', 4);
define('CMDB_ENUMTYPE_ROMANLOW', 5);
define('CMDB_QUIZATTEMPT_NONE', 0);
define('CMDB_QUIZATTEMPT_STARTED', 1);
define('CMDB_QUIZATTEMPT_COMPLETED', 2);
define('CMDB_QUIZATTEMPT_PASSED', 3);
define('CMDB_QUIZATTEMPT_FAILED', 4);
define('CMDB_QUIZATTEMPT_CANCELLED', 5);
define('CMDB_QUIZCORRECTION_NONE', 0);
define('CMDB_QUIZCORRECTION_PASS', 1);
define('CMDB_QUIZCORRECTION_FAIL', 2);
define('CMDB_SURVEYTYPE_NONE', 0);
define('CMDB_SURVEYTYPE_TEXT', 1);
define('CMDB_SURVEYTYPE_SELECT', 2);
define('CMDB_SURVEYTYPE_RANK', 3);
define('CMDB_SURVEYTYPE_YESNO', 5);
define('CMDB_SURVEYTYPE_AGREEDIS', 6);
define('CMDB_BOOKMARKTYPE_PERSONAL', 0);
define('CMDB_BOOKMARKTYPE_COURSE', 1);
define('CMDB_BOOKMARKTYPE_RECORDING', 2);
define('CMDB_BOOKMARKTYPE_EVERYONE', 3);
define('CMDB_BOOKMARKTYPE_CONVERTED', 10);
define('CMDB_SESSIONSTATUS_UNKNOWN', 0);
define('CMDB_SESSIONSTATUS_CONNECTED', 1);
define('CMDB_SESSIONSTATUS_COMPLETE', 2);
define('CMDB_SESSIONSTATUS_NOLICENSE', 3);
define('CMDB_SESSIONSTATUS_ERROR', 4);
define('CMDB_FILESESSIONSTATUS_UNKNOWN', 0);
define('CMDB_FILESESSIONSTATUS_OPEN', 1);
define('CMDB_FILESESSIONSTATUS_COMPLETE', 2);
define('CMDB_FILESESSIONSTATUS_NOLICENSE', 3);
define('CMDB_FILESESSIONSTATUS_ERROR', 4);
define('CMDB_CHATTYPE_NONE', 0);
define('CMDB_EXPORTTYPE_SESSION', 1);
define('CMDB_EXPORTTYPE_FILESESSION', 2);
define('CMDB_EXPORTTYPE_RECORDSESSION', 3);
define('CMDB_EXPORTAUTOTYPE_24H', 1);
define('CMDB_EXPORTAUTOTYPE_MONTH', 2);
define('CMDB_EXPORTAUTOTYPE_SEMESTER', 3);
