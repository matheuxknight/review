<?php

require('data.php');
$this->pageTitle = app()->name ." - ". $object->name;

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

echo CHtml::cssFile('/extensions/jqplot/jquery.jqplot.css');

JavascriptFile("/extensions/jqplot/jquery.jqplot.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.dateAxisRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.barRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.highlighter.js");
JavascriptFile("/sansspace/modules/tracking/teacherreport/toolbar.js");

//$teacher = getdbosql('Role', "name='teacher'");
echo "<h2>Grades</h2>";

showButton($semester->name, '', array('id'=>'buttonsemester'));

echo CHtml::dropDownList('month', $month, $month_table);
echo CHtml::dropDownList('other', $other, $other_table);

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
			SansspaceCourseTeacher.update();
		}, 1000);
	});
});

</script>
END;

//showButton('Add Users', array('course/addusers', 'id'=>$object->id), array('id'=>'buttonaddstudent'));

JavascriptReady("SansspaceCourseTeacher.init($object->id, '$semester->starttime', '$semester->endtime')");

JavascriptReady("
	if(window.location.hash == '#tabs-3')
		SansspaceCourseTeacher.initchart();
	else if(window.location.hash == '#tabs-2')
		SansspaceCourseTeacher.initlog();
	else
		SansspaceCourseTeacher.initsummary();");

echo '<br><br>';
InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1' onclick='SansspaceCourseTeacher.initsummary();'>Summary</a></li>";
echo "<li><a href='#tabs-2' onclick='SansspaceCourseTeacher.initlog();'>Detailed</a></li>";
echo "<li><a href='#tabs-3' onclick='SansspaceCourseTeacher.initchart();'>Chart</a></li>";
echo "</ul><br>";

echo "<div id='tabs-1'>";
echo "</div>";

echo "<div id='tabs-2'>";
echo "</div>";

echo "<div id='tabs-3'>";

//echo CHtml::dropDownList('group', 0, $group_table,
//	array('onchange'=>'SansspaceCourseTeacher.update()'));

echo CHtml::dropDownList('scale', 0, $scale_table,
	array('onchange'=>'SansspaceCourseTeacher.update()'));

echo CHtml::dropDownList('type', 0, $type_table,
	array('onchange'=>'SansspaceCourseTeacher.update()'));

echo "</div>";

echo "</div>";

//////////////////////////////////////////////////////////////////////////////////////////

$loading_image = mainimg('loading_white.gif');
echo "<div id='loading' style='margin-top: 100px; margin-left: 40%;margin-bottom: 300px;'>
	$loading_image</div>";

echo "<div id='statresults'></div>";

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";




