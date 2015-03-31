<?php

showAdminHeader(4);
echo "<h3>Database Backup</h3>";

echo "<br>";
echo "<table class='dataGrid'>";

echo "<tr>";
echo "<th>Name</th>";
echo "<th>Options</th>";
echo "<th>Size</th>";
echo "<th>Date</th>";
echo "</tr>";

$res = @opendir(SANSSPACE_BACKUP);
if(!$res)
{
	mkdir(SANSSPACE_BACKUP);
	
	$res = @opendir(SANSSPACE_BACKUP);
	if(!$res) return;
}

$files = array();
while(($name = readdir($res)) !== false)
{
	if($name == '.' || $name == '..') continue;
	$filename = SANSSPACE_BACKUP."\\$name";
	
	$filetime = filemtime($filename);
	$filesize = filesize($filename);
	
	$files[$filetime] = array($name, $filetime, $filesize);
}

closedir($res);
ksort($files);

foreach($files as $file)
{
	echo "<tr class='ssrow'>";
	echo "<td><b>{$file[0]}</b></td>";
	
	echo "<td>";

	echo 
		CHtml::linkButton('Restore', array(
			'submit'=>'backup/restore',
			'params'=>array('backupname'=>$file[0]),
			'confirm'=>"Are you sure to restore {$file[0]}?")).' '.
	
		l('Download', array('download', 'backupname'=>$file[0])).' '.
			
		CHtml::linkButton('Delete', array(
			'submit'=>'backup/delete',
			'params'=>array('backupname'=>$file[0]),
			'confirm'=>"Are you sure to delete {$file[0]}?")).' '.
	
		"</td>";
		
	echo "<td>".itoa($file[2])."</td>";
	echo "<td>".date("F d Y H:i:s", $file[1])."</td>";
	
	echo "</tr>";
}

echo "</table>";
echo "<br/>";
echo "<br/>";

echo "Choose a backup file name below and click the Backup Now button  
to take a snapshot of the current database and store it on the server.<br><br>";

$backupname = 'backup-'.SANSSPACE_VERSION;
echo CUFHtml::beginForm('backup/backupnow', 'post');

echo "<div class='buttonHolder'>";
echo "<input type='text' name='backupname' value='$backupname'/> ";

echo CUFHtml::submitButton('Backup Now', array('id'=>'btnSubmit',
	'confirm'=>'Are you sure you want to backup the database now?',
));

echo "</div>";
echo CUFHtml::endForm();

echo "<script> $(function() {\$('#btnSubmit').button();	});	</script>";
echo "<script> $(function() {\$('a', '.buttonHolder').button();	}); </script>";


return;

//////////////////////////////////////////////////////////////////////////////////
//
//ShowUploadHeader();
//
//echo "<br>";
//echo "<br>";
//
//echo "To restore a database backup from an SQL file from your computer, click the 
//Select File button below to select your file and click on the Restore button to start
//the restore operation when you are ready.<br><br>";
//
//echo "Restoring a database can be a very long process depending of your database file size.
//Make sure nobody is connected before you start. After the database is restored, the 
//SANSSpace service will restart.<br><br><br>";
//
//echo CUFHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data'));
//
//echo '<div class="miscInput"><span id="spanButtonPlaceholder"></span></div>';
//echo '<div class="flash" id="fsUploadProgress"></div>';
//
//echo "<br><div class='buttonHolder'>";
//echo CUFHtml::submitButton('Restore Database', array(
//	'id'=>'btnSubmit',
//	'confirm'=>'Are you sure you want to restore this database and restart the SANSSpace service?',
//));
//
//echo "</div>";
//echo CUFHtml::endForm();
//
//echo "<script> $(function() {\$('#btnSubmit').button();	});	</script>";
//echo "<script> $(function() {\$('a', '.buttonHolder').button();	}); </script>";
//
//return;



/////////////////////////////////////////////////////////////////////////////

//echo "<h3>Database Statistics</h3>";
//
//echo "<table class='reportgrid1'>";
//echo "<tr>";
//echo "<th style='width:180px'>Database</th>";
//echo "<th>Totals</th>";
//echo "</tr>";
//
//echo "<tr><td>Total Registered Users:</td><td>";
//echo l(app()->db->createCommand("select count(*) from User")->queryScalar(), array('user/'));
//echo "</td></tr>";
//
//echo "<tr><td>Total Objects:</td><td>";
//echo app()->db->createCommand("select count(*) from Object")->queryScalar();
//echo "</td></tr>";
//
//echo "<tr><td>Total Files:</td><td>";
//echo app()->db->createCommand("select count(*) from Object where type=".CMDB_OBJECTTYPE_FILE)->queryScalar();
//echo "</td></tr>";
//
//echo "<tr><td>Total Courses:</td><td>";
//echo l(app()->db->createCommand("select count(*) from Object where type=".CMDB_OBJECTTYPE_COURSE)->queryScalar(), array('admin/courses'));
//echo "</td></tr>";
//
//$object = Object::model()->findByPk(CMDB_OBJECTROOT_ID);
//
//echo "<tr><td>Total Files Size:</td><td>";
//echo Itoa($object->size);
//echo " bytes</td></tr>";
//
//echo "<tr><td>Total Files Duration</td><td>";
//echo sectoa(round($object->duration/1000));
//echo "</td></tr>";
//
//
//echo "<tr><td>Total Client Computers:</td><td>";
//echo l(app()->db->createCommand("select count(*) from Client")->queryScalar(), array('client/'));
//echo "</td></tr>";
//
//echo "<tr><td>Total User Sessions:</td><td>";
//echo l(app()->db->createCommand("select count(*) from Session")->queryScalar(), array('session/'));
//echo "</td></tr>";
//
//echo "<tr><td>Total File Sessions:</td><td>";
//echo app()->db->createCommand("select count(*) from FileSession")->queryScalar();
//echo "</td></tr>";
//
//echo "</table>";
//echo "<br/>";



