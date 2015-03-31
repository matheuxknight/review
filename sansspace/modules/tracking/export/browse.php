<?php

include "data.php";
JavascriptFile("/sansspace/modules/tracking/export/toolbar.js");

showAdminHeader(1);
echo "<h2>Custom Template $export->name</h2>";

showButtonHeader();
showButton('All Templates', array('admin'));
showButton('New Template', array('create'));
showButton('Edit Template', array('update', 'id'=>$export->id));
showButtonPost('Delete Template', array('submit'=>array('delete','id'=>$export->id),'confirm'=>'Are you sure?'));
echo "</div><br>";

JavascriptReady("SansspaceCustomExportToolbar.init($export->id);");

echo "<span style='display: inline-block; width: 50px;'>Date:</span>";
$semester_objects = getdbolist('Semester', '1 order by starttime desc');

$semester_table = CHtml::listData($semester_objects, 'id', 'name');
$semester_table[0] = 'Semester';

foreach($semester_objects as $semester)
	JavascriptReady("SansspaceCustomExportToolbar.addSemester($semester->id, '$semester->starttime', '$semester->endtime')");

$semester = getCurrentSemester();

echo CHtml::dropDownList('semester', $semester->id, $semester_table,
		array('onchange'=>'SansspaceCustomExportToolbar.semesterChanged()'));

$currentyear = intval(date('Y'));

$year_table = array();
for($i = 0; $i < 6; $i++)
	$year_table[$currentyear-$i] = ' '.$currentyear-$i;

$year_table[0] = 'Year';

echo CHtml::dropDownList('year', $year, $year_table,
	array('onchange'=>'SansspaceCustomExportToolbar.yearChanged()'));

echo CHtml::dropDownList('month', $month, $month_table,
	array('onchange'=>'SansspaceCustomExportToolbar.monthChanged()'));

JavascriptReady("SansspaceCustomExportToolbar.addOther(1, '".date('Y-m-d H:i', time()-24*60*60)."', '".date('Y-m-d H:i', time())."')");
JavascriptReady("SansspaceCustomExportToolbar.addOther(2, '".date('Y-m-d H:i', time()-48*60*60)."', '".date('Y-m-d H:i', time())."')");
JavascriptReady("SansspaceCustomExportToolbar.addOther(3, '".date('Y-m-d', strtotime('-7 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceCustomExportToolbar.addOther(4, '".date('Y-m-d', strtotime('-14 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceCustomExportToolbar.addOther(5, '".date('Y-m-d', strtotime('-30 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceCustomExportToolbar.addOther(6, '".date('Y-m-d', strtotime('-60 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceCustomExportToolbar.addOther(7, '".date('Y-m-d', strtotime('-90 days'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceCustomExportToolbar.addOther(8, '".date('Y-m-01', strtotime('-1 year'))."', '".date('Y-m-d', strtotime('+1 day'))."')");
JavascriptReady("SansspaceCustomExportToolbar.addOther(9, '2007-01-01', '".date('Y-m-d', strtotime('+1 day'))."')");

echo CHtml::dropDownList('other', $other, $other_table,
	array('onchange'=>'SansspaceCustomExportToolbar.otherChanged()'));

showDatetimePicker2('after', $semester->starttime, $after,
	"function(){SansspaceCustomExportToolbar.dateChanged()}");

showDatetimePicker2('before', $semester->endtime, $before,
	"function(){SansspaceCustomExportToolbar.dateChanged()}");

echo "<br>";

////////////////////////////////////////////////////////////////////////////////////////

if(!$objectid) $objectid = 1;
$object = getdbo('Object', $objectid);

echo "<span style='display: inline-block; width: 46px;'>Filters:</span>";
echo <<<END

<input type='text' name='searchusers' id='searchusers' size='30' class='sans-input'
	onblur="this.value==''?this.value='$searchusers':''"
	onclick="this.value=='$searchusers'?this.value='':''"
	value='$searchusers' />

<!--input type='text' name='objectname' id='objectname' size='30' class='sans-input'
	value='$object->name' title='Select Object'
	onclick="onShowObjectBrowser(0, true, true, 'objectid', 'objectname', $object->id, '$object->name', selectObject);" />

<input type='hidden' name='objectid' id='objectid' value='$object->id' /-->

<script>
$(function() {
	$('#searchusers').bind('keyup', function(event)
	{
		clearTimeout(this.searching);
		this.searching = setTimeout(function() {
			SansspaceCustomExportToolbar.update();
		}, 1000);
	});
});

function selectObject(selectedid, selectedname)
{
	SansspaceCustomExportToolbar.update();
}

</script>
END;

echo "<br>";

//////////////////////////////////////////////////////////////

$loading_image = mainimg('loading_white.gif');
echo "<div id='loading' style='margin-top: 200px; margin-left: 40%;
margin-bottom: 300px;'>$loading_image</div>";

echo "<div id='statresults'></div>";



