<?php

showAdminHeader(5);
echo "<h2>Server Information</h2>";

echo "<script> $(function() {\$('a', '.buttonHolder').button();	}); </script>";

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Info</a></li>";
echo "<li><a href='#tabs-2'>Maintenance</a></li>";
echo "<li><a href='#tabs-3'>Extensions</a></li>";
echo "</ul><br>";

echo "<div id='tabs-1'>";

echo "These fields are for your information only. They can't be changed from the web 
interface. You need to connect to the server console to do so.";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($server);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($server, 'version');
echo CUFHtml::activeLabelEx($server, 'software version');
echo CUFHtml::activeTextField($server, 'version', array('readonly'=>true));
echo "<p class='formHint2'>Version of the SANSSpace binary core engine.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, '');
echo CUFHtml::activeLabelEx($server, 'site id');
echo CUFHtml::textField('database', SANSSPACE_SITENAME, array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'license_concurrent');
echo CUFHtml::activeLabelEx($server, 'license_concurrent');
echo CUFHtml::activeTextField($server, 'license_concurrent', array('readonly'=>true));
echo "<p class='formHint2'>The number of allowed concurrent users on the server. This refers to the old sansspace licensing scheme.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'license_total');
echo CUFHtml::activeLabelEx($server, 'license_total');
echo CUFHtml::activeTextField($server, 'license_total', array('readonly'=>true));
echo "<p class='formHint2'>Total number of different users allowed to connect to sansspace for the current semester. 
		This refers to the new sansspace licensing scheme for new installations.</p>";
echo CUFHtml::closeCtrlHolder();

$license_used = dboscalar("select count(*) from user where used>'$semester->starttime'");

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('License Used', '', array('class'=>'miscInput'));
echo CUFHtml::textField('', $license_used, array('readonly'=>true, 'class'=>'textInput'));
echo "<p class='formHint2'>Number of users that used sansspace or were enrolled so far in the semester.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, 'license_endtime');
echo CUFHtml::activeLabelEx($server, 'license_endtime');
echo CUFHtml::activeTextField($server, 'license_endtime', array('readonly'=>true));
echo "<p class='formHint2'>Licence expiration date.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, '');
echo CUFHtml::activeLabelEx($server, 'database server');
echo CUFHtml::textField('database', SANSSPACE_DBHOST, array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>Database server currently used.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, '');
echo CUFHtml::activeLabelEx($server, 'database name');
echo CUFHtml::textField('database', SANSSPACE_DBNAME, array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>Database name currently used.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, '');
echo CUFHtml::activeLabelEx($server, 'Install Folder');
echo CUFHtml::textField('database', SANSSPACE_INSTALL, array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>SANSSpace binary folder.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, '');
echo CUFHtml::activeLabelEx($server, 'site folder');
echo CUFHtml::textField('database', SANSSPACE_HTDOCS, array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>Site folder currently used.</p>";
echo CUFHtml::closeCtrlHolder();

//echo CUFHtml::openActiveCtrlHolder($server, '');
//echo CUFHtml::activeLabelEx($server, 'temp folder');
//echo CUFHtml::textField('database', SANSSPACE_TEMP, array('class'=>'textInput', 'readonly'=>true));
//echo "<p class='formHint2'>Temporary folder currently used.</p>";
//echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, '');
echo CUFHtml::activeLabelEx($server, 'content folder');
echo CUFHtml::textField('database', SANSSPACE_CONTENT, array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>Content folder currently used to store media files.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($server, '');
echo CUFHtml::activeLabelEx($server, 'cache folder');
echo CUFHtml::textField('database', SANSSPACE_CACHE, array('class'=>'textInput', 'readonly'=>true));
echo "<p class='formHint2'>Cache folder currently used to store media file transcodings.</p>";
echo CUFHtml::closeCtrlHolder();

//echo CUFHtml::openActiveCtrlHolder($server, 'localname');
//echo CUFHtml::activeLabelEx($server,'localname');
//echo CUFHtml::activeTextField($server,'localname', array('maxlength'=>200, 'readonly'=>true));
//echo "<p class='formHint2'>Local name of this server.</p>";
//echo CUFHtml::closeCtrlHolder();
//
//echo CUFHtml::openActiveCtrlHolder($server, 'localip');
//echo CUFHtml::activeLabelEx($server,'localip');
//echo CUFHtml::activeTextField($server,'localip', array('maxlength'=>200, 'readonly'=>true));
//echo "<p class='formHint2'>Local IP of this server.</p>";
//echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
echo CUFHtml::endForm();

echo "</div>";

/////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";
echo '<br>'.l('Fix Database', '/internal/updatedatabase').'<br>';
echo "</div>";

/////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-3'>";

echo '<br>'.l('PHP Version Info', array('admin/php')).'<br>';

echo '<br>'.l('XCache Cacher', '/extensions/xcache/cacher/index.php').'<br>';
echo '<br>'.l('XCache Diagnosis', '/extensions/xcache/diagnosis/index.php').'<br>';

echo "</div>";






