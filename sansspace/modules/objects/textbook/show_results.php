<?php

$search = getparam('search');
if($search == 0) $search = '';

$status = getparam('status');

$unused = getdbocount('UserCode', "objectid=$object->id and code like '%$search%' and status=".CMDB_USERCODE_UNUSED);
$used = getdbocount('UserCode', "objectid=$object->id and code like '%$search%' and status=".CMDB_USERCODE_USED);
$expired = getdbocount('UserCode', "objectid=$object->id and code like '%$search%' and status=".CMDB_USERCODE_EXPIRED);
$revoked = getdbocount('UserCode', "objectid=$object->id and code like '%$search%' and status=".CMDB_USERCODE_REVOKED);

echo "<table class='dataGrid2'>";
echo "<thead class='ui-widget-header'><tr>";
echo "<th width=80>Total</th>";
echo "<th width=80>Unused</th>";
echo "<th width=80>Used</th>";
echo "<th width=80>Expired</th>";
echo "<th>Revoked</th>";
echo "</tr></thead><tbody>";
echo "<tr>";

$total = $unused + $used + $expired + $revoked;

$sunused = CMDB_USERCODE_UNUSED;
$sused = CMDB_USERCODE_USED;
$sexpired = CMDB_USERCODE_EXPIRED;
$srevoked = CMDB_USERCODE_REVOKED;

echo "<td><a href='javascript:select_status(0)'>$total</a></td>";
echo "<td><a href='javascript:select_status($sunused)'>$unused</a></td>";
echo "<td><a href='javascript:select_status($sused)'>$used</a></td>";
echo "<td><a href='javascript:select_status($sexpired)'>$expired</a></td>";
echo "<td><a href='javascript:select_status($srevoked)'>$revoked</a></td>";

echo "</tr>";
echo "</tbody></table><br>";

if(!isset($_GET['search'])) return;

if($status)
	$list = getdbolist('UserCode', "objectid=$object->id and code like '%$search%' and status=$status");
else
	$list = getdbolist('UserCode', "objectid=$object->id and code like '%$search%'");

if(empty($list)) return;

showTableSorter('maintable');
echo "<thead class='ui-widget-header'><tr>";
echo "<th width=200>Code</th>";
echo "<th width=100>Status</th>";
echo "<th width=160>Activated</th>";
echo "<th>User</th>";
echo "<th>Course</th>";
echo "</tr></thead><tbody>";

foreach($list as $code)
{
	$username = $code->userid? $code->user->name: '';
	$coursename = $code->courseid? $code->course->name: '';
	
	$userurl = $code->userid? "/user/update?id={$code->user->id}": '';
	$courseurl = $code->courseid? "/course?id={$code->course->id}": '';
	
	echo "<tr>";
	echo "<td><b><a href='/textbook/updatecode?id=$code->id'>$code->code</a></b></td>";
	echo "<td>$code->statusText</td>";
	echo "<td>$code->started</td>";
	echo "<td><a href='$userurl'>$username</a></td>";
	echo "<td><a href='$courseurl'>$coursename</a></td>";
	echo "</tr>";
}

echo "</tbody></table>";




