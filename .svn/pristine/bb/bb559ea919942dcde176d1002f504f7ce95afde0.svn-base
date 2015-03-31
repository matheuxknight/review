<?php

require('data.php');
require('lib.php');
require('plot.php');

//debuglog($_SERVER['REQUEST_URI']);

//////////////////////////////////////////////////////////////////////

if(!$scale) $scale = autoSessionScale($totallength);
$groupby = $groupby_table[$group];

if($build_table[$scale][0])
	$totallength = min($totallength, $build_table[$scale][0]);

$extraparams = '';
if(!empty($users))
	$extraparams .= " and (user.name like '%$users%' or user.logon like '%$users%' or user.custom1 like '%$users%')";

if(!empty($clients))
	$extraparams .= " and (client.remotename like '%$clients%' or client.remoteip like '%$clients%')";

if(!empty($platforms))
	$extraparams .= " and session.platform like '%$platforms%'";

////////////////////////////////////////////////////////////////////////////////////

if(isset($groupby['session']))
	$categories = dbolist("select distinct {$groupby['session']} as category from session ".
	"group by {$groupby['session']}");

else if(isset($groupby['client']))
{
	$categories = array();
	$categories[0] = array();
	$categories[0]['category'] = $location_table[0];
	$categories[1] = array();
	$categories[1]['category'] = $location_table[1];
}

else
{
	$categories = array();
	$categories[0] = array();
	$categories[0]['category'] = 'unknown';
}

////////////////////////////////////////////////////////////////////////////////////

$series = new SessionPlotArray();
$series->addArray($categories, 'category');

$data = array();
foreach($series->items as $serie)
	$data[$serie] = new SessionPlotArray();

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

	$ticks->addItem($d1);	// use month name if monthly, not used

	$standardparams = "from session, client, user where ".
		"session.starttime + interval session.duration second >= '$d1' and ".
		"session.starttime < '$d2' and ".
		"client.id = session.clientid and user.id = session.userid";

	if(isset($groupby['session']))
	{
		$groupbystring = $groupby['session'];

		$list = dbolist("select count(*) as count, $groupbystring as category ".
			"$standardparams $extraparams group by $groupbystring");
	}

	else if(isset($groupby['client']))
	{
		$groupbystring = $groupby['client'];

		$list = dbolist("select count(*) as count, $groupbystring as netlocal ".
				"$standardparams $extraparams group by $groupbystring");

		for($i = 0; $i < count($list); $i++)
			$list[$i]['category'] = $location_table[$list[$i]['netlocal']];
	}

	else
		$list = dbolist("select count(*) as count $standardparams $extraparams");

	foreach($list as $l)
	{
		$cat = $l['category'];
		if(!$cat || empty($cat)) $cat = 'unknown';

		$data[$cat]->addItem("['$d1', {$l['count']}]");
		$total += $l['count'];
	}

	foreach($data as $d)
	{
		if(count($d->items) < $counter)
			$d->addItem("['$d1', 0]");
	}
}

$intervaltitle = $scale_table[$scale];
$totaldays = intval($totallength/60/60/24);

echo "<h3 style='padding-left: 240px; '>$title &#9679; From $after to $before &#9679; $totaldays days / $intervaltitle</h3>";
showSessionBarPlot($data, $series, $ticks);

///////////////////////////////////////////////////////////////////////

echo "<div id='plot_1' style='width:80%; height:360px;
	margin-top: 20px; margin-bottom: 20px; margin-left: 20px; '></div>";

//echo "<p>Total sessions: $total</p>";

// showButtonHeader();

// echo "<button>Previous</button>";
// echo "<button>Next</button>";

// echo "</div>";
// echo "<script>$(function(){ $('button', '.buttonwrapper').button();});</script>";

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";



