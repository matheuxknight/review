<?php

require('data.php');
require('lib.php');
require('plot.php');

//debuglog($_SERVER['REQUEST_URI']);

//////////////////////////////////////////////////////////////////////

if(!$scale) $scale = autoSessionScale($totallength);
//$groupby = $groupby_table[$group];

if($build_table[$scale][0])
	$totallength = min($totallength, $build_table[$scale][0]);

$extraparams = "";
if(!empty($users))
	$extraparams .= " and (user.name like '%$users%' or user.logon like '%$users%' or user.custom1 like '%$users%')";

if($sessionid)
	$extraparams .= " and filesession.sessionid=$sessionid";

////////////////////////////////////////////////////////////////////////////////////

$series = new SessionPlotArray();

$objects = array();
if($group == 1)
{
	$categories = dbolist("select * from object where parentid=$objectid and type!=".CMDB_OBJECTTYPE_FILE);
	$series->addArray($categories, 'name');

	foreach($series->items as $s)
		$objects[$s] = getdbosql('Object', "parentid=$objectid and name='$s'");
}

else
	$series->addItem(null);

$data = array();
foreach($series->items as $s)
	$data[$s] = new SessionPlotArray();

$interval = $build_table[$scale][1];
$ticks = new SessionPlotArray();

$total = 0;
$counter = 0;

for($stime = $starttime; $stime < $starttime + $totallength;
	$stime = strtotime($interval, $stime))
{
	$counter++;

	$d1 = date("Y-m-d H:i", $stime);
	$d2 = date("Y-m-d H:i", strtotime($interval, $stime));

	$ticks->addItem($d1);

	if($group == 1)
	{
		foreach($series->items as $s)
		{
		//	debuglog($s);
			$object = $objects[$s];

			$params = "from filesession, user, vfile where ".
				"filesession.starttime + interval filesession.duration second >= '$d1' and ".
				"filesession.starttime < '$d2' and ".
				"filesession.userid=user.id and filesession.fileid=vfile.id and ".
				"vfile.parentlist like '%, $object->id, %'";

			if($type == 0)
				$count = dboscalar("select count(*) $params $extraparams");

			else
				$count = dboscalar("select sum(filesession.duration)/60/60 $params $extraparams");

			if($count == null) $count = 0;
			$data[$s]->addItem("['$d1', $count]");
		}

	}

	else
	{
		$params = "from filesession, user, vfile where ".
			"filesession.starttime + interval filesession.duration second >= '$d1' and ".
			"filesession.starttime < '$d2' and ".
			"filesession.userid=user.id and filesession.fileid=vfile.id and ".
			"vfile.parentlist like '%, $objectid, %'";

		if($type == 0)
			$count = dboscalar("select count(*) $params $extraparams");

		else
			$count = dboscalar("select sum(filesession.duration)/60/60 $params $extraparams");

		if($count == null) $count = 0;
		$data['unknown']->addItem("['$d1', $count]");
	}
}

$intervaltitle = $scale_table[$scale];
$totaldays = intval($totallength/60/60/24);

echo "<h3 style='padding-left: 240px; '>$title &#9679; From $after to $before &#9679; $totaldays days / $intervaltitle</h3>";
showSessionBarPlot($data, $series, $ticks);

///////////////////////////////////////////////////////////////////////

echo "<div id='plot_1' style='width:80%; height:360px;
	margin-top: 20px; margin-bottom: 20px; margin-left: 20px; '></div>";

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";



