<?php

$this->pageTitle = app()->name ." - ". $course->name;

setContextCourse($course->id);

showRoleBar($course);
showNavigationBar($course->parent);
showObjectHeader($course);
showObjectMenu($course->object);

$teachername = $course->getTeacherName();
$teacherrole = getdbosql('Role', "name='teacher'");

echo "<br><table>";

if(!empty($teachername))
{
	if(param('theme') == 'wayside')
		echo <<<end
<tr>
<td width=120 style='font-size:18px; line-height:1em;'>$teacherrole->description:</td>
<td style='font-size:18px; line-height:1em;'><b>$teachername</b></td></tr>
end;
	else
		echo <<<end
<tr>
<td>$teacherrole->description:</td>
<td><b>$teachername</b></td></tr>
end;
}

if($course->semester)
{
	echo "<tr><td>Semester:</td><td><b>{$course->semester->name}</b></td></tr>";
	echo "<tr><td>Starts:</td><td><b>{$course->semester->starttime}</b></td></tr>";
	echo "<tr><td>Ends:</td><td><b>{$course->semester->endtime}</b></td></tr>";
}

else if($course->usedate)
{
	$startArr = explode("-", $course->startdate);
	$endArr = explode("-", $course->enddate);
	
	$startInt = mktime(0, 0, 0, $startArr[1], $startArr[2], $startArr[0]);
	$endInt = mktime(23, 59, 59, $endArr[1], $endArr[2], $endArr[0]);
	
	if(time() < $startInt)
	 	echo "<tr><td>Starting:</td><td>$course->startdate</td></tr>";
	
	if(time() > $endInt)
		echo "<tr><td>Expired since:</td><td><b>$course->enddate</b></td></tr>";
}

echo "</table>";

echo processDoctext($course, $course->ext->doctext);
showFolderContents($course->id);

// if($course->usedate)
// {
// 	echo "<div id='toto'></div>";
// 	echo "<script type='text/javascript'>
// 			$('#toto').DatePicker({
// 				readOnly: true,
// 				flat: true,
// 				calendars: 3,
// 				mode: 'range',
// 				starts: 0,
// 				date: ['{$course->startdate}','{$course->enddate}'],
// 				current: '".nowDate(60*60*24*29)."'
// 			});
// 			</script>";
// 	echo "<br><br>";
// }

showObjectFooter($course);
showPreviousNext($course);
showObjectComments($course);

user()->setState('currentobject', $course->id);
user()->setState('currentversion', $course->version);

JavascriptReady("window.onbeforeunload = function(){
	$.ajax({url: '/object/leavepage?id=$course->id', async: false});}");

if(IsMobileEmbeded())
	SetAppHeaderColors();









