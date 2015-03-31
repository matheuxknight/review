<?php

if($update)
	ShowUploadHeader();

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($roster);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>General</a></li>";
echo "<li><a href='#tabs-2'>Format</a></li>";
echo "<li><a href='#tabs-3'>Advanced</a></li>";
echo "<li><a href='#tabs-4'>Cron Job</a></li>";
echo "</ul><br>";

//////////////////////////////////////////////////////////////////////

echo "<div id='tabs-1'>";

echo CUFHtml::openActiveCtrlHolder($roster, 'name');
echo CUFHtml::activeLabelEx($roster,'name');
echo CUFHtml::activeTextField($roster,'name',array('maxlength'=>200));
echo "<p class='formHint2'>The name of this roster template</p>";
echo CUFHtml::closeCtrlHolder();

if($update)
{
	echo CUFHtml::openActiveCtrlHolder($roster, 'Upload File');
	echo CUFHtml::activeLabelEx($roster, 'Upload File');
	echo '<div class="miscInput"><span id="spanButtonPlaceholder"></span></div>';
	echo "<p class='formHint2'>Select a csv roster file from your computer and upload it to the server.</p>";
	echo CUFHtml::closeCtrlHolder();

	echo '<div class="flash" id="fsUploadProgress"></div>';
}

echo "</div>";
echo "<div id='tabs-2'>";

$example_array = str_getcsv($roster->example);

$entry = new RosterEntry;
$entry->parse($example_array, $roster);

echo "<p>This interface lets you define how your csv files will be processed for this template.
	You build each field using field variables from the input file. <b>$0</b> means the first field, <b>$1</b> the second and so on.
	</p>";

echo CUFHtml::openActiveCtrlHolder($roster, 'example');
echo CUFHtml::activeLabelEx($roster,'example');
echo CUFHtml::activeTextField($roster,'example',array('maxlength'=>200));
echo "<p class='formHint2'>Type or paste in a sample of a line of your csv file.
		This field is for your information only and is not used as such into the process.</p>";
echo CUFHtml::closeCtrlHolder();

echo "<table style='margin-left: 200px; font-weight: bold; '>";
foreach($example_array as $i=>$s)
	echo "<tr><td width='30' align='right'>\$$i</td><td>$s</td></tr>";

echo "</table>";

echo CUFHtml::openActiveCtrlHolder($roster, 'coursename');
echo CUFHtml::activeLabelEx($roster,'coursename');
echo CUFHtml::activeTextField($roster,'coursename',array('maxlength'=>200));
echo "<p class='formHint2'>The course name field is mandatory.<br>
	Sample: <b>$entry->coursename</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'languagename');
echo CUFHtml::activeLabelEx($roster,'languagename');
echo "<p class='formHint2'>The language computed from the course name and the language table.<br>
	Sample: <b>$entry->languagename</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'foldername');
echo CUFHtml::activeLabelEx($roster,'foldername');
echo CUFHtml::activeTextField($roster,'foldername',array('maxlength'=>200));
echo "<p class='formHint2'>Optional. If provided, another level of folders will be created
	between the language folder and courses as such.<br>
	Sample: <b>$entry->foldername</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'username');
echo CUFHtml::activeLabelEx($roster,'username');
echo CUFHtml::activeTextField($roster,'username',array('maxlength'=>200));
echo "<p class='formHint2'>This should be the complete user name. If ommited, 
		the userlogon will be used when creating new user accounts.<br>
	Sample: <b>$entry->username</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'userlogon');
echo CUFHtml::activeLabelEx($roster,'userlogon');
echo CUFHtml::activeTextField($roster,'userlogon',array('maxlength'=>200));
echo "<p class='formHint2'>The userlogon field is mandatory.<br>
	Sample: <b>$entry->userlogon</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'useremail');
echo CUFHtml::activeLabelEx($roster,'useremail');
echo CUFHtml::activeTextField($roster,'useremail',array('maxlength'=>200));
echo "<p class='formHint2'>Optional.<br>
	Sample: <b>$entry->useremail</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'userrole');
echo CUFHtml::activeLabelEx($roster,'userrole');
echo CUFHtml::activeTextField($roster,'userrole',array('maxlength'=>200));
$teacher = getdbosql('Role', "name='teacher'");
$student = getdbosql('Role', "name='student'");
echo "<p class='formHint2'>Optional. By default, user are enrolled as $student->description. 
		The value $student->description, $teacher->description and content can be used to specify roles.<br>
	Sample: <b>$entry->userrole</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'teachername');
echo CUFHtml::activeLabelEx($roster,'teachername');
echo CUFHtml::activeTextField($roster,'teachername',array('maxlength'=>200));
echo "<p class='formHint2'>Optional.<br>
	Sample: <b>$entry->teachername</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'teacherlogon');
echo CUFHtml::activeLabelEx($roster,'teacherlogon');
echo CUFHtml::activeTextField($roster,'teacherlogon',array('maxlength'=>200));
echo "<p class='formHint2'>Optional.<br>
	Sample: <b>$entry->teacherlogon</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'teacheremail');
echo CUFHtml::activeLabelEx($roster,'teacheremail');
echo CUFHtml::activeTextField($roster,'teacheremail',array('maxlength'=>200));
echo "<p class='formHint2'>Optional.<br>
	Sample: <b>$entry->teacheremail</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'customcourse');
echo CUFHtml::activeLabelEx($roster,'customcourse');
echo CUFHtml::activeTextField($roster,'customcourse',array('maxlength'=>200));
echo "<p class='formHint2'>Optional. A custom value from the csv file that you want to save in the sansspace database related to courses.
		It can be used later to export reports.<br>
	Sample: <b>$entry->customcourse</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'customuser');
echo CUFHtml::activeLabelEx($roster,'customuser');
echo CUFHtml::activeTextField($roster,'customuser',array('maxlength'=>200));
echo "<p class='formHint2'>Optional. A custom value from the csv file that you want to save in the sansspace database related to users.
		It can be used later to export reports.<br>
	Sample: <b>$entry->customuser</b></p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";
echo "<div id='tabs-3'>";

echo CUFHtml::openCtrlHolder();
echo CUFHtml::activeLabelEx($roster, 'domainid');
echo CUFHtml::activeDropDownList($roster, 'domainid', User::model()->domainOptions);
echo "<p class='formHint2'>Select a domain where new users will be associated with.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'hassemester');
echo CUFHtml::activeLabelEx($roster, 'hassemester');
echo CUFHtml::activeCheckBox($roster, 'hassemester', array('class'=>'miscInput'));
echo "<p class='formHint2'>Check this if your csv files contain the semester definition in the first line.
		The format should be: <b>Winter 2013, 02/08/2013,06/11/2013</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'skipfirst');
echo CUFHtml::activeLabelEx($roster, 'skipfirst');
echo CUFHtml::activeCheckBox($roster, 'skipfirst', array('class'=>'miscInput'));
echo "<p class='formHint2'>Check this if you want to skip the first line of your csv files in the case they 
		contain a header or the titles of the fields.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'languagetable');
echo CUFHtml::activeLabelEx($roster, 'languagetable');
echo CUFHtml::activeTextArea($roster, 'languagetable');
echo "<p class='formHint2'>This table is used to map course acronymes to language names. For example, 
		the table item <b>'SPAN'=>'Spanish'</b> will place the SPAN101 course into the Spanish language category.
		You can define as many items as needed separated by a comma.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'extracode');
echo CUFHtml::activeLabelEx($roster, 'extracode');
echo CUFHtml::activeTextArea($roster, 'extracode');
echo "<p class='formHint2'>Extra php code to preprocess each csv line.</p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

echo "<div id='tabs-4'>";

echo "<p>This page lets you define a cron job to process you csv files automatically. 
		Fill in the following parameters and click the Create Cron Job button to set time recurrence.</p>";

echo CUFHtml::openActiveCtrlHolder($roster, 'sourcefile');
echo CUFHtml::activeLabelEx($roster, 'sourcefile');
echo CUFHtml::activeTextField($roster, 'sourcefile');
echo "<p class='formHint2'>Specifies the location of you files. This can be a complete path to a folder or a 
		file pattern like this: <b>\\\\server\\share\\folder\\roster*.csv</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($roster, 'deleteafter');
echo CUFHtml::activeLabelEx($roster, 'deleteafter');
echo CUFHtml::activeCheckBox($roster, 'deleteafter', array('class'=>'miscInput'));
echo "<p class='formHint2'>If checked, sansspace will try to delete every file that has been successfully processed.</p>";
echo CUFHtml::closeCtrlHolder();

showButtonHeader();

$cronjob = getdbo('Cronjob', "id=$export->cronjobid");

if (!$cronjob)
{
	$cronname = "Roster $roster->name";
	if ($cronjob = getdbosql('Cronjob', "name='$cronname'"))
	{
		$roster->cronjobid = $cronjob->id;
		$roster->save();
	}
}

if($cronjob) showButton('Edit Cron Job', array('cronjob/update', 'id'=>$cronjob->id));
else showButton('Create Cron Job', array('roster/createcronjob', 'id'=>$roster->id));
echo "</div>";

echo "</div>";

echo "</div>";
echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

