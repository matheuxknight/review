<?php

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($cronjob);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1'>General</a></li>";
echo "<li><a href='#tabs-2'>Time</a></li>";
echo "<li><a href='#tabs-3'>Action</a></li>";
echo "</ul><br>";

//////////////////////////////////////////////////////////////////////

echo "<div id='tabs-1'>";

echo CUFHtml::openActiveCtrlHolder($cronjob, 'name');
echo CUFHtml::activeLabelEx($cronjob, 'name');
echo CUFHtml::activeTextField($cronjob, 'name', array('maxlength'=>200));
echo "<p class='formHint2'>Name of this cron job.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($cronjob, 'crontime');
echo CUFHtml::activeLabelEx($cronjob, 'crontime');
echo CUFHtml::activeTextField($cronjob, 'crontime', array('maxlength'=>200));
echo "<p class='formHint2'>Recurring time specification using the unix-like system syntax.
		Use the Time tab to modify. See this wiki page for more information:
		<a target='_blank' href='http://en.wikipedia.org/wiki/Cron'>http://en.wikipedia.org/wiki/Cron</a></p>";
echo CUFHtml::closeCtrlHolder();
	
echo CUFHtml::openActiveCtrlHolder($cronjob, 'enable');
echo CUFHtml::activeLabelEx($cronjob, 'enable');
echo CUFHtml::activeCheckBox($cronjob, 'enable', array('class'=>'miscInput'));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($cronjob, 'lastrun');
echo CUFHtml::activeLabelEx($cronjob, 'lastrun');
echo $cronjob->lastrun;
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo "</div>";

//////////////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";

$arrayDay = array(
	'*'=>'*', '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', 
	'5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9',
	'10'=>'10', '11'=>'11', '12'=>'12', '13'=>'13', '14'=>'14', 
	'15'=>'15', '16'=>'16', '17'=>'17', '18'=>'18', '19'=>'19',
	'20'=>'20', '21'=>'21', '22'=>'22', '23'=>'23', '24'=>'24',
	'25'=>'25', '26'=>'26', '27'=>'27', '28'=>'28', '29'=>'29',
	'30'=>'30', '31'=>'31',
);

$arrayMonth = array(
	'*'=>"*", 
	'1'=>"January",
	'2'=>"February",
	'3'=>"March",
	'4'=>"April",
	'5'=>"May",
	'6'=>"June",
	'7'=>"July",
	'8'=>"August",
	'9'=>"September",
	'10'=>"October",
	'11'=>"November",
	'12'=>"December");

$arrayWeekday = array(
	'*'=>"*", 
	'0'=>"Sunday",
	'1'=>"Monday",
	'2'=>"Tuesday",
	'3'=>"Wednesday",
	'4'=>"Thursday",
	'5'=>"Friday",
	'6'=>"Saterday");

$arrayCrontime = explode(" ", $cronjob->crontime);

echo CUFHtml::openActiveCtrlHolder($cronjob, "Minute");
echo CUFHtml::activeLabelEx($cronjob, "Minute");
echo CUFHtml::TextField("crontime[0]", $arrayCrontime[0], array('maxlength'=>4));
echo '<p class="formHint2">.</p>';
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($cronjob, "Hour");
echo CUFHtml::activeLabelEx($cronjob, "Hour");
echo CUFHtml::TextField("crontime[1]", $arrayCrontime[1], array('maxlength'=>4));
echo '<p class="formHint2">.</p>';
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($cronjob, "Day");
echo CUFHtml::activeLabelEx($cronjob, "Day");
echo CHtml::dropDownList("crontime[2]", $arrayCrontime[2], $arrayDay, array('class'=>'sans-combobox'));
echo '<p class="formHint2">.</p>';
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($cronjob, "Month");
echo CUFHtml::activeLabelEx($cronjob, "Month");
echo CHtml::dropDownList("crontime[3]", $arrayCrontime[3], $arrayMonth, array('class'=>'sans-combobox'));
echo '<p class="formHint2">.</p>';
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($cronjob, "Weekday");
echo CUFHtml::activeLabelEx($cronjob, "Weekday");
echo CHtml::dropDownList("crontime[4]", $arrayCrontime[4], $arrayWeekday, array('class'=>'sans-combobox'));
echo '<p class="formHint2">.</p>';
echo CUFHtml::closeCtrlHolder();

echo "</div>";

//////////////////////////////////////////////////////////////////////

echo "<div id='tabs-3'>";

echo CUFHtml::openActiveCtrlHolder($cronjob, 'url');
echo CUFHtml::activeLabelEx($cronjob, 'url');
echo CUFHtml::activeTextField($cronjob, 'url',array('maxlength'=>200));
echo "<p class='formHint2'>Type a url to be executed and/or enter php script code below.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($cronjob, 'phpcode');
echo CUFHtml::activeLabelEx($cronjob, 'phpcode');
echo CHtml::textArea('Cronjob[phpcode]', $cronjob->phpcode,
	array('style'=>'width: 70%;height: 10em;'));

echo CUFHtml::closeCtrlHolder();

echo "</div>";
echo "</div>";

echo CUFHtml::closeTag('fieldset');
showSubmitButton($update? 'Save': 'Create');
echo CUFHtml::endForm();






