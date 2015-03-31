<?php

require('data.php');

$at = strtotime($after);
$bt = strtotime($before);

$days = round(($bt - $at)/60/60/24);

$as = strftime("%A %B %d %Y", $at);
$bs = strftime("%A %B %d %Y", $bt);

$downloadlink = l(mainimg('16x16_bottom.png'),
	array('summarycsv',
		'id'=>$objectid,
		'after'=>$after,
		'before'=>$before,
	),
	array('title'=>'Download CSV', 'target'=>'_blank'));

echo "Summary for the $days days period between $as and $bs.&nbsp;&nbsp;$downloadlink<br><br>";

/////////////////////////////////////////////////////////////////////////////

$listparent = array($object->id);

$tmp = dbocolumn("select linkid from object where parentlist like '%, $object->id, %' and type=".CMDB_OBJECTTYPE_LINK);
$listparent = array_unique(array_merge($listparent, $tmp));

$parent = $object;
while($parent && $parent->model)
{
	$tmp = dbocolumn("select linkid from object where parentid = $parent->id and type=".CMDB_OBJECTTYPE_LINK);
	$listparent = array_unique(array_merge($listparent, $tmp));

	$parent = $parent->parent;
}

$tmp = dbocolumn("select id from object where parentid=$object->id and recordings");
$listparent = array_unique(array_merge($listparent, $tmp));

$tmp = dbocolumn("select id from object where parentid=$object->id and recordings");
$listparent = array_unique(array_merge($listparent, $tmp));

$stringparent = '0';
foreach($listparent as $id)
	$stringparent .= " or vfile.parentlist like '%, $id, %'";

/////////////////////////////////////////////////////////////////////////////

$extraparams = '';
if(!empty($files))
	$extraparams .= " and vfile.name like '%$files%'";

$criteria = new CDbCriteria;
$criteria->condition = "courseenrollment.objectid=$object->id";
$listuser = CourseEnrollment::model()->with('role', 'user')->findAll($criteria);

showTableSorter('maintable', '{headers: {0: {sorter: false}, 8: {sorter: false}}}');

echo "<thead class='ui-widget-header'><tr>";
echo "<th width=20></th>";
echo "<th>User</th>";
echo "<th>ID</th>";
echo "<th>Views</th>";
echo "<th>Time</th>";
echo "<th>Record</th>";
//echo "<th>Status</th>";
echo "<th>Grade</th>";
echo "<th>Role</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

$totalopen = 0;
$totalplay = 0;
$totalrecord = 0;

foreach($listuser as $model)
{
	echo "<tr class='ssrow'>";
	echo "<td>".userImage($model->user, 18)."</td>";

	echo "<td style='font-weight: bold;'>";
	echo l($model->user->name, array('studentreport/', 'id'=>$object->id,
		'userid'=>$model->userid, 'after'=>$after, 'before'=>$before));
	echo "</td>";

	echo "<td>$user->custom1</td>";
	
	$recordtime = getRecordTime($object, $model->user);

	$params = "select count(*), sum(filesession.duration) from filesession, user, vfile where ".
		"filesession.starttime + interval filesession.duration second >= '$after' and ".
		"filesession.starttime < '$before' and ".
		"filesession.userid=user.id and filesession.fileid=vfile.id and ".
		"($stringparent) and user.id={$model->user->id} $extraparams";

	$row = dborow($params);
	$opencount = $row['count(*)'];
	$playtime = $row['sum(filesession.duration)'];

	$totalopen += $opencount;
	$totalplay += $playtime;
	$totalrecord += $recordtime;

	echo "<td>$opencount</td>";
	echo "<td>".sectoa($playtime)."</td>";

	$courseid = getContextCourseId();
	$folder = userRecordingFolder($object, $model->user, $courseid);
	echo "<td>".sectoa($recordtime)."</td>";

//	echo "<td>{$model->statusText}</td>";
	echo "<td>{$model->grade}</td>";

	echo "<td>{$model->role->description}</td>";
	echo "<td>";

	echo l(mainimg('16x16_delete.png'), '#', array('id'=>"delete_enrollment_{$model->id}"));
	
	echo <<<END
<script>$(function(){ $('#delete_enrollment_{$model->id}').click(function(){
	if(confirm('Are you sure you want to unenroll this user {$object->name}?'))
		jQuery.yii.submitForm(this, '/enroll/deletecourse?id=$model->id',{});
	return false;});});</script>
END;
	
	echo "</td>";
	echo "</tr>";
}

echo "</tbody>";
echo "<tr class='ssrow'>";
echo "<th></th>";
echo "<th><b>Total: ".count($listuser)."</b></th>";

echo "<th></th>";
echo "<th>$totalopen</th>";
echo "<th>".sectoa($totalplay)."</th>";
echo "<th>".sectoa($totalrecord)."</th>";
echo "<th></th>";
echo "<th></th>";

echo "<th></th>";
echo "<th></th>";

echo "</tr>";
echo "</table>";

$output = '';
Yii::app()->getClientScript()->render($output);
echo $output;



