<?php

showAdminHeader(1);
require('data.php');

echo CHtml::cssFile('/extensions/jqplot/jquery.jqplot.css');

JavascriptFile("/extensions/jqplot/jquery.jqplot.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.dateAxisRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.barRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.highlighter.js");
JavascriptFile("/sansspace/modules/tracking/session/toolbar.js");

$extraparams = '';
$title = 'User Sessions';

if($sessionid)
{
	$extraparams .= "&sessionid=$sessionid";
	$title .= " $sessionid";
}

echo "<h2>$title</h2>";

////////////////////////////////////////////////////////////////////////////////////

echo "<span style='display: inline-block; width: 50px;'>Date:</span>";
$semester_objects = getdbolist('Semester', '1 order by starttime desc');

$semester_table = CHtml::listData($semester_objects, 'id', 'name');
$semester_table[0] = 'Semester';

foreach($semester_objects as $semester)
	JavascriptReady("SansspaceSessionToolbar.addSemester($semester->id, '$semester->starttime', '$semester->endtime')");

$semester = getCurrentSemester();

echo CHtml::dropDownList('semester', $semester->id, $semester_table,
	array('onchange'=>'SansspaceSessionToolbar.semesterChanged()'));

$currentyear = intval(date('Y'));

$year_table = array();
for($i = 0; $i < 6; $i++)
	$year_table[$currentyear-$i] = ' '.$currentyear-$i;

$year_table[0] = 'Year';

echo CHtml::dropDownList('year', $year, $year_table,
	array('onchange'=>'SansspaceSessionToolbar.yearChanged()'));

echo CHtml::dropDownList('month', $month, $month_table,
	array('onchange'=>'SansspaceSessionToolbar.monthChanged()'));

JavascriptReady("SansspaceSessionToolbar.addOther(1, '".date('Y-m-d H:i', time()-24*60*60)."', '".date('Y-m-d H:i', time())."')");
JavascriptReady("SansspaceSessionToolbar.addOther(2, '".date('Y-m-d H:i', time()-48*60*60)."', '".date('Y-m-d H:i', time())."')");
JavascriptReady("SansspaceSessionToolbar.addOther(3, '".date('Y-m-d', strtotime('-7 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceSessionToolbar.addOther(4, '".date('Y-m-d', strtotime('-14 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceSessionToolbar.addOther(5, '".date('Y-m-d', strtotime('-30 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceSessionToolbar.addOther(6, '".date('Y-m-d', strtotime('-60 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceSessionToolbar.addOther(7, '".date('Y-m-d', strtotime('-90 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceSessionToolbar.addOther(8, '".date('Y-m-01', strtotime('-1 year'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceSessionToolbar.addOther(9, '2007-01-01', '".date('Y-m-d', strtotime('+1 day'))."')");

echo CHtml::dropDownList('other', $other, $other_table,
	array('onchange'=>'SansspaceSessionToolbar.otherChanged()'));

showDatetimePicker2('after', $semester->starttime, $after,
	"function(){SansspaceSessionToolbar.dateChanged()}");

showDatetimePicker2('before', $semester->endtime, $before,
	"function(){SansspaceSessionToolbar.dateChanged()}");

echo "<br>";

//////////////////////////////////////////////////////////////////////////////////////////

$tempusers = empty($users)? $searchusers: $users;
$tempclients = empty($clients)? $searchclients: $clients;

echo "<span style='display: inline-block; width: 46px;'>Filters:</span>";
echo <<<END

<input type='text' name='searchusers' id='searchusers' size='30' class='sans-input'
	onblur="this.value==''?this.value='$searchusers':''"
	onclick="this.value=='$searchusers'?this.value='':''"
	value='$tempusers' />

<input type='text' name='searchclients' id='searchclients' size='20' class='sans-input'
	onblur="this.value==''?this.value='$searchclients':''"
	onclick="this.value=='$searchclients'?this.value='':''"
	value='$tempclients' />

<input type='text' name='searchplatforms' id='searchplatforms' size='20' class='sans-input'
	onblur="this.value==''?this.value='$searchplatforms':''"
	onclick="this.value=='$searchplatforms'?this.value='':''"
	value='$searchplatforms' />

<script>
$(function()
{
	$('#searchusers').bind('keyup', function(event)
	{
		clearTimeout(this.searching);
		this.searching = setTimeout(function() {
			SansspaceSessionToolbar.update();
		}, 1000);
	});

	$('#searchclients').bind('keyup', function(event)
	{
		clearTimeout(this.searching);
		this.searching = setTimeout(function() {
			SansspaceSessionToolbar.update();
		}, 1000);
	});

	$('#searchplatforms').bind('keyup', function(event)
	{
		clearTimeout(this.searching);
		this.searching = setTimeout(function() {
			SansspaceSessionToolbar.update();
		}, 1000);
	});

});

</script>
END;

echo "<br>";

///////////////////////////////////////////////////////////////////////////

echo "<br>";
InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1' onclick='SansspaceSessionToolbar.initlog(\"$extraparams\");'>Log</a></li>";
echo "<li><a href='#tabs-2' onclick='SansspaceSessionToolbar.initchart(\"$extraparams\");'>Chart</a></li>";
echo "</ul><br>";

JavascriptReady("if(window.location.hash == '#tabs-2')
	SansspaceSessionToolbar.initchart('$extraparams');
	else SansspaceSessionToolbar.initlog('$extraparams');");

echo "<div id='tabs-1'>";
echo "</div>";

echo "<div id='tabs-2'>";
echo CHtml::dropDownList('group', 0, $group_table,
	array('onchange'=>'SansspaceSessionToolbar.update()'));

echo CHtml::dropDownList('scale', 0, $scale_table,
	array('onchange'=>'SansspaceSessionToolbar.update()'));

echo "</div>";
echo "</div>";

//////////////////////////////////////////////////////////////

$loading_image = mainimg('loading_white.gif');
echo "<div id='loading' style='margin-top: 200px; margin-left: 40%;
	margin-bottom: 300px;'>$loading_image</div>";

echo "<div id='statresults'></div>";










