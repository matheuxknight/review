<?php

//debuglog($_SERVER['REQUEST_URI']);

require('data.php');
$this->pageTitle = app()->name ." - ". $object->name;

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);
showUserHeader($user, $user->name);

if(!$enrollment)
{
	echo "<p>You are not enrolled into this course.</p>";
	return;
}

echo CHtml::cssFile('/extensions/jqplot/jquery.jqplot.css');

JavascriptFile("/extensions/jqplot/jquery.jqplot.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.dateAxisRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.barRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.highlighter.js");
JavascriptFile("/sansspace/modules/tracking/studentreport/toolbar.js");

//////////////////////////////////////////////////

echo "<h2>Grades</h2>";

showButton($semester->name, '', array('id'=>'buttonsemester'));

echo CHtml::dropDownList('month', '0', $month_table);
echo CHtml::dropDownList('other', '0', $other_table);

showDatetimePicker2('after', $semester->starttime);
showDatetimePicker2('before', $semester->endtime);

echo <<<END
<input type='text' name='searchfiles' id='searchfiles' size='30' class='sans-input'
	onblur="this.value==''?this.value='$searchfiles':''"
	onclick="this.value=='$searchfiles'?this.value='':''"
	value='$searchfiles' />

<script>
$(function()
{
	$('#searchfiles').bind('keyup', function(event)
	{
		clearTimeout(this.searching);
		this.searching = setTimeout(function() {
			SansspaceCourseStudent.update();
		}, 1000);
	});
});

</script>
END;

JavascriptReady("SansspaceCourseStudent.init($user->id, $object->id, '$semester->starttime', '$semester->endtime')");

JavascriptReady("
	if(window.location.hash == '#tabs-3')
		SansspaceCourseStudent.initchart();
	else if(window.location.hash == '#tabs-2')
		SansspaceCourseStudent.initlog();
	else if(window.location.hash == '#tabs-1' || window.location.hash == '')
		SansspaceCourseStudent.initsummary();");

echo '<br><br>';
InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1' onclick='SansspaceCourseStudent.initsummary();'>Summary</a></li>";
echo "<li><a href='#tabs-2' onclick='SansspaceCourseStudent.initlog();'>Detailed</a></li>";
echo "<li><a href='#tabs-3' onclick='SansspaceCourseStudent.initchart();'>Chart</a></li>";
echo "<li><a href='#tabs-6' onclick='SansspaceCourseStudent.initother();'>Saved Work</a></li>";
echo "<li><a href='#tabs-4' onclick='SansspaceCourseStudent.initother();'>Feedback</a></li>";

echo "</ul><br>";

///////////////////////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-1'>";
echo "</div>";

///////////////////////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-2'>";
echo "</div>";

///////////////////////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-3'>";

echo CHtml::dropDownList('scale', 0, $scale_table,
	array('onchange'=>'SansspaceCourseStudent.update()'));

echo CHtml::dropDownList('type', 0, $type_table,
	array('onchange'=>'SansspaceCourseStudent.update()'));

echo "</div>";

///////////////////////////////////////////////////////////////////////////////////////////

echo "<div id='tabs-4'>";
$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($enrollment);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

if(controller()->rbac->objectUrl($object, 'teacherreport'))
{
	echo CUFHtml::openActiveCtrlHolder($enrollment, 'roleid');
	echo CUFHtml::activeLabelEx($enrollment, 'roleid');
	echo CUFHtml::activeDropDownList($enrollment, 'roleid', Role::model()->courseData);
	echo "<p class='formHint2'>Choose the role for this user in this course.</p>";
	echo CUFHtml::closeCtrlHolder();
}

// echo CUFHtml::openActiveCtrlHolder($enrollment, 'status');
// echo CUFHtml::activeLabelEx($enrollment, 'status');
// echo CUFHtml::activeDropDownList($enrollment, 'status', CourseEnrollment::model()->statusOptions);
// $student = getdbosql('Role', "name='student'");
// echo "<p class='formHint2'>The $student->description status is normally updated automatically by sansspace.
// 	You can also modify it manually.</p>";
// echo CUFHtml::closeCtrlHolder();

if(controller()->rbac->objectUrl($object, 'teacherreport'))
{
	echo CUFHtml::openActiveCtrlHolder($enrollment, 'grade');
	echo CUFHtml::activeLabelEx($enrollment, 'grade');
	echo CUFHtml::activeTextField($enrollment, 'grade', array('maxlength'=>200));
	echo "<p class='formHint2'>.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($enrollment, 'description');
	echo CUFHtml::activeLabelEx($enrollment, 'description');
	echo CUFHtml::activeTextArea($enrollment, 'description',
		array('style'=>'width:70%; height:5em'));
	echo CUFHtml::closeCtrlHolder();
}
else
{
	echo CUFHtml::openActiveCtrlHolder($enrollment, 'grade');
	echo CUFHtml::activeLabelEx($enrollment, 'grade');
	echo CUFHtml::activeTextField($enrollment, 'grade', array('readonly'=>true));
	echo "<p class='formHint2'>.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($enrollment, 'description');
	echo CUFHtml::activeLabelEx($enrollment, 'description');
	echo CUFHtml::activeTextArea($enrollment, 'description',
			array('style'=>'width:70%; height:5em', 'readonly'=>true));
	echo CUFHtml::closeCtrlHolder();
}

echo CUFHtml::closeTag('fieldset');
if(controller()->rbac->objectUrl($object, 'teacherreport'))
	showSubmitButton('Save');
echo CUFHtml::endForm();

echo "</div>";

//////////////////////////////////////////////////////////////////

echo "<div id='tabs-5'>";

if($quizstatus)
{
	if(controller()->rbac->objectUrl($object, 'teacherreport'))
		showButton('Reset Quiz', array('quiz/resetstatus',
			'id'=>$object->id, 'userid'=>$user->id),
			array('confirm'=>'Are you sure you want to reset this user\'s quiz?'));

	echo CUFHtml::beginForm();
	echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

	echo CUFHtml::openActiveCtrlHolder($enrollment, 'status');
	echo CUFHtml::activeLabelEx($enrollment, 'status');
	echo CUFHtml::activeDropDownList($enrollment, 'status', CourseEnrollment::model()->statusOptions);
	echo "<p class='formHint2'>.</p>";
	echo CUFHtml::closeCtrlHolder();

	echo CUFHtml::openActiveCtrlHolder($quizstatus, 'started');
	echo CUFHtml::activeLabelEx($quizstatus, 'started');
	echo CUFHtml::activeTextField($quizstatus, 'started', array('maxlength'=>200));
	echo "<p class='formHint2'>.</p>";
	echo CUFHtml::closeCtrlHolder();

	if($enrollment->status >= CMDB_ENROLLSTATUS_COMPLETED)
	{
		echo CUFHtml::openActiveCtrlHolder($quizstatus, 'completed');
		echo CUFHtml::activeLabelEx($quizstatus, 'completed');
		echo CUFHtml::activeTextField($quizstatus, 'completed', array('maxlength'=>200));
		echo "<p class='formHint2'>.</p>";
		echo CUFHtml::closeCtrlHolder();
	}

	echo CUFHtml::openActiveCtrlHolder($quizstatus, 'duration');
	echo CUFHtml::activeLabelEx($quizstatus, 'duration');
	echo CUFHtml::activeTextField($quizstatus, 'duration', array('maxlength'=>200));
	echo "<p class='formHint2'>.</p>";
	echo CUFHtml::closeCtrlHolder();

	echo CUFHtml::openActiveCtrlHolder($quizstatus, 'currentquestion');
	echo CUFHtml::activeLabelEx($quizstatus, 'currentquestion');
	echo CUFHtml::activeTextField($quizstatus, 'currentquestion', array('maxlength'=>200));
	echo "<p class='formHint2'>.</p>";
	echo CUFHtml::closeCtrlHolder();

	echo CUFHtml::closeTag('fieldset');
	echo CUFHtml::endForm();

//		$questioncount = QuizQuestion::model()->count("quizid={$object->id}");
//		echo "<tr><td>Progress:</td><td><b>".
//			"{$quizstatus->currentquestion}/{$questioncount}</b></td></tr>";
}
echo "</div>";

/////////////////////////////////////////////////////////

echo "<div id='tabs-6'>";
//showTableSorter('maintable-2');
showTableSorter('maintable-recording', '{headers: {0: {sorter: false}, 4: {sorter: false}}}');

echo "<thead class='ui-widget-header'><tr>";
echo "<th></th>";
echo "<th>Recorded File</th>";
echo "<th>Duration</th>";
//echo "<th>Size</th>";
echo "<th>Created</th>";
echo "<th></th>";
echo "<th>Master File</th>";
echo "<th>Duration</th>";
echo "</tr></thead><tbody>";

$totalduration = 0;
$totalsize = 0;

$courseid = getContextCourseId();
$folder = userRecordingFolder($object, $user, $courseid);
if($folder)
{
	$fileList = getdbolist('VFile', "parentid=$folder->id");
	foreach($fileList as $file)
	{
		echo "<tr class='ssrow'>";
	
		echo '<td width=24>'.objectImage($file, 18).'</td>';
		echo '<td style="font-weight: bold;">';
		showObjectMenuContext($file);
		echo '</td>';
		
		echo "<td nowrap>".sectoa($file->duration/1000)."</td>";
	//	echo '<td>'.Itoa($file->size).'</td>';
		
		echo '<td nowrap>'.datetoa($file->created).'</td>';
		
		echo '<td width=24>'.objectImage($file->original, 18).'</td>';
		echo '<td style="font-weight: bold;">';
		if($file->original) showObjectMenuContext($file->original);
		echo '</td>';
		
		echo "<td nowrap>".sectoa($file->original->duration/1000)."</td>";
	
		echo "</tr>";
	
		$totalduration += $file->duration/1000;
		$totalsize += $file->size;
	}
}

echo "</tbody><tr>";
echo "<th></th>";
echo "<th>Total: ".count($fileList)."</th>";
echo "<th>".sectoa($totalduration)."</th>";
echo "<th></th>";
echo "<th></th>";
echo "<th></th>";
echo '<td></td>';
echo "</tr>";

echo "</table>";
echo "</div>";

echo "</div>";

//////////////////////////////////////////////////////////////////////////////////////////

$loading_image = mainimg('loading_white.gif');
echo "<div id='loading' style='margin-top: 100px; margin-left: 40%;
margin-bottom: 300px;'>$loading_image</div>";

echo "<div id='statresults'></div>";

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
