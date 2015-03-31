<?php

showAdminHeader(1);
require('data.php');

echo CHtml::cssFile('/extensions/jqplot/jquery.jqplot.css');

JavascriptFile("/extensions/jqplot/jquery.jqplot.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.dateAxisRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.barRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.highlighter.js");

JavascriptFile("/sansspace/modules/tracking/recordsession/toolbar.js");

$extraparams = '';
echo "<h2>Record Sessions</h2>";

if($sessionid)
{
	$extraparams .= "&sessionid=$sessionid";
	$session = getdbo('Session', $sessionid);

	echo "<table class='dataGrid'>";
	echo "<tr><td width=100>Session ID:</td><td>{$session->id}</td></tr>";
	echo "<tr><td>User:</td><td>".l($session->user->name,
		array('user/update','id'=>$session->user->id))."</td></tr>";

	echo "<tr><td>Client:</td><td>";
	echo l($session->client->remotename, array('client/update','id'=>$session->client->id));

	echo "</td></tr>";
	echo "<tr><td>Platform:</td><td>$session->platform</td></tr>";
	echo "<tr><td>Date:</td><td>".datetoa($session->starttime)."</td></tr>";
	echo "<tr><td>Duration:</td><td>".sectoa($session->duration)."</td></tr>";
	echo"</table><hr><br>";

	JavascriptReady("$('#boxfilters').hide();");
}

////////////////////////////////////////////////////////////////////////////////////

echo "<div id='boxfilters'>";

echo "<span style='display: inline-block; width: 50px;'>Date:</span>";
$semester_objects = getdbolist('Semester', '1 order by starttime desc');

$semester_table = CHtml::listData($semester_objects, 'id', 'name');
$semester_table[0] = 'Semester';

foreach($semester_objects as $semester)
	JavascriptReady("SansspaceRecordSessionToolbar.addSemester($semester->id, '$semester->starttime', '$semester->endtime')");

$semester = getCurrentSemester();

echo CHtml::dropDownList('semester', $semester->id, $semester_table,
	array('onchange'=>'SansspaceRecordSessionToolbar.semesterChanged()'));

$currentyear = intval(date('Y'));

$year_table = array();
for($i = 0; $i < 6; $i++)
	$year_table[$currentyear-$i] = ' '.$currentyear-$i;

$year_table[0] = 'Year';

echo CHtml::dropDownList('year', $year, $year_table,
	array('onchange'=>'SansspaceRecordSessionToolbar.yearChanged()'));

echo CHtml::dropDownList('month', $month, $month_table,
	array('onchange'=>'SansspaceRecordSessionToolbar.monthChanged()'));

JavascriptReady("SansspaceRecordSessionToolbar.addOther(1, '".date('Y-m-d H:i', time()-24*60*60)."', '".date('Y-m-d H:i', time())."')");
JavascriptReady("SansspaceRecordSessionToolbar.addOther(2, '".date('Y-m-d H:i', time()-48*60*60)."', '".date('Y-m-d H:i', time())."')");
JavascriptReady("SansspaceRecordSessionToolbar.addOther(3, '".date('Y-m-d', strtotime('-7 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceRecordSessionToolbar.addOther(4, '".date('Y-m-d', strtotime('-14 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceRecordSessionToolbar.addOther(5, '".date('Y-m-d', strtotime('-30 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceRecordSessionToolbar.addOther(6, '".date('Y-m-d', strtotime('-60 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceRecordSessionToolbar.addOther(7, '".date('Y-m-d', strtotime('-90 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceRecordSessionToolbar.addOther(8, '".date('Y-m-01', strtotime('-1 year'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceRecordSessionToolbar.addOther(9, '2007-01-01', '".date('Y-m-d', strtotime('+1 day'))."')");

echo CHtml::dropDownList('other', $other, $other_table,
	array('onchange'=>'SansspaceRecordSessionToolbar.otherChanged()'));

showDatetimePicker2('after', $semester->starttime, $after,
	"function(){SansspaceRecordSessionToolbar.dateChanged()}");

showDatetimePicker2('before', $semester->endtime, $before,
	"function(){SansspaceRecordSessionToolbar.dateChanged()}");

echo "<br>";

////////////////////////////////////////////////////////////////////////////////////////

echo "<span style='display: inline-block; width: 46px;'>Filters:</span>";
echo <<<END

<input type='text' name='searchusers' id='searchusers' size='30' class='sans-input'
	onblur="this.value==''?this.value='$searchusers':''"
	onclick="this.value=='$searchusers'?this.value='':''"
	value='$searchusers' />

<script>
$(function() {
	$('#searchusers').bind('keyup', function(event)
	{
		clearTimeout(this.searching);
		this.searching = setTimeout(function() {
			SansspaceRecordSessionToolbar.update();
		}, 1000);
	});
});

</script>
END;

echo "<br>";
echo "</div>";

///////////////////////////////////////////////////////////////////////////

echo "<br>";
InitMenuTabs('#tabs');

echo "<div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#tabs-1' onclick='SansspaceRecordSessionToolbar.initlog(\"$extraparams\");'>Log</a></li>";
echo "<li><a href='#tabs-2' onclick='SansspaceRecordSessionToolbar.initchart(\"$extraparams\");'>Chart</a></li>";
echo "</ul><br>";

JavascriptReady("if(window.location.hash == '#tabs-2')
	SansspaceRecordSessionToolbar.initchart('$extraparams');
	else SansspaceRecordSessionToolbar.initlog('$extraparams');");

echo "<div id='tabs-1'>";
echo "</div>";

echo "<div id='tabs-2'>";
echo CHtml::dropDownList('group', 0, $group_table,
	array('onchange'=>'SansspaceRecordSessionToolbar.update()'));

echo CHtml::dropDownList('scale', 0, $scale_table,
	array('onchange'=>'SansspaceRecordSessionToolbar.update()'));

echo CHtml::dropDownList('type', 0, $type_table,
	array('onchange'=>'SansspaceRecordSessionToolbar.update()'));

echo "</div>";
echo "</div>";

//////////////////////////////////////////////////////////////

$loading_image = mainimg('loading_white.gif');
echo "<div id='loading' style='margin-top: 200px; margin-left: 40%;
	margin-bottom: 300px;'>$loading_image</div>";

echo "<div id='statresults'></div>";










