<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($export);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>Format</a></li>";
echo "<li><a href='#tabs-3'>Cron Job</a></li>";
echo "</ul><br>";

//////////////////////////////////////////////////////////////////////

echo "<div id='tabs-1'>";

echo CUFHtml::openActiveCtrlHolder($export, 'name');
echo CUFHtml::activeLabelEx($export,'name');
echo CUFHtml::activeTextField($export,'name', array('maxlength'=>200));
echo "<p class='formHint2'>The name of this custom report template.</p>";
echo CUFHtml::closeCtrlHolder();

$exporttypes = array(
	CMDB_EXPORTTYPE_SESSION=>'Session', 
	CMDB_EXPORTTYPE_FILESESSION=>'File Session', 
	CMDB_EXPORTTYPE_RECORDSESSION=>'Record Session', 
);

echo CUFHtml::openActiveCtrlHolder($export, 'type');
echo CUFHtml::activeLabelEx($export, 'type');
echo CUFHtml::activeDropDownList($export, 'type', $exporttypes);
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($export, 'titleformat');
echo CUFHtml::activeLabelEx($export,'titleformat');
echo CUFHtml::activeTextField($export,'titleformat', array('maxlength'=>200));
echo "<p class='formHint2'>Type in the title line separated with comma. 
		Example: <b>File,User,Start Time,Duration</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($export, 'dataformat');
echo CUFHtml::activeLabelEx($export,'dataformat');
echo CUFHtml::activeTextField($export,'dataformat', array('maxlength'=>200));
echo "<p class='formHint2'>The data format separated with comma. Valids are: <br><b>
	\$user.id, \$user.name, \$user.logon, \$user.email, \$user.custom<br>
	\$file.id, \$file.name, \$file.parentid, \$file.parentname, \$file.duration<br>
	\$course.id, \$course.name, \$course.parentid, \$course.parentname, \$course.custom<br>
	\$time.start, \$time.end, \$time.duration<br>
	</b></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($export, 'timeformat');
echo CUFHtml::activeLabelEx($export,'timeformat');
echo CUFHtml::activeTextField($export,'timeformat', array('maxlength'=>200));
echo "<p class='formHint2'>The time format. Example: <b>Y-m-d H:i:s</b></p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

echo "<div id='tabs-3'>";

$autotypes = array(
	CMDB_EXPORTAUTOTYPE_24H=>'Last 24 hours',
	CMDB_EXPORTAUTOTYPE_MONTH=>'Current Month',
	CMDB_EXPORTAUTOTYPE_SEMESTER=>'Current Semester',
);

echo CUFHtml::openActiveCtrlHolder($export, 'autotype');
echo CUFHtml::activeLabelEx($export, 'autotype');
echo CUFHtml::activeDropDownList($export, 'autotype', $autotypes);
echo "<p class='formHint2'>The date range of the generated report.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($export, 'targetfile');
echo CUFHtml::activeLabelEx($export, 'targetfile');
echo CUFHtml::activeTextField($export, 'targetfile');
echo "<p class='formHint2'>Type in the complete path of the generated file. Example: <b>c:\\temp\\report-\$date.csv</b></p>";
echo CUFHtml::closeCtrlHolder();

showButtonHeader();

$cronjob = getdbo('Cronjob', "id=$export->cronjobid");

if (!$cronjob)
{
	$cronname = "Export $export->name";
	if ($cronjob = getdbosql('Cronjob', "name='$cronname'"))
	{
		$export->cronjobid = $cronjob->id;
		$export->save();
	}
}

if($cronjob) showButton('Edit Cron Job', array('cronjob/update', 'id'=>$cronjob->id));
else showButton('Create Cron Job', array('export/createcronjob', 'id'=>$export->id));
echo "</div>";

echo "</div>";

echo "</div>";
echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();

