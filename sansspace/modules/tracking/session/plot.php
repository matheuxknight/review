<?php

function showSessionBarPlot($data, $series, $ticks)
{
	// set min and max
	foreach($data as $d)
		$stringdata .= $d->getArrays().', ';

	$stringdata = rtrim($stringdata, ', ');

	$stringseries = $series->getObjects('label');
	$stringticks = $ticks->getArrays();

//	debuglog($stringdata);
//	debuglog($stringseries);
//	debuglog($stringticks);

	$showlegend = count($series->items) == 1? 'false': 'true';

	echo <<<END
<script>
$(document).ready(function(){
	var plot1 = $.jqplot('plot_1', [$stringdata],
	{
		stackSeries: true,
		series: $stringseries,

		seriesDefaults: {renderer: $.jqplot.BarRenderer},
		axes: {xaxis: {renderer: $.jqplot.DateAxisRenderer}},

		legend: {
			show: $showlegend,
			location: 'e',
			placement: 'outside'
		},

		highlighter: {
			show: true,
			showMarker: false,
			sizeAdjust: 10
		},

		dum: 0
	});
});

</script>
END;
}

//////////////////////////////////////////////////////////////////////

// function showSessionPiePlot($sessions)
// {
// 	$string = arrayToPlotString($sessions);
// 	echo <<<END
// <script>
// $(document).ready(function(){
// var data = [
//     ['Heavy Industry', 12],['Retail', 9], ['Light Industry', 14],
//     ['Out of home', 16],['Commuting', 7], ['Orientation', 9]
//   ];

// 	var plot1 = $.jqplot('plot_1', [data], {
// 		seriesDefaults: {
// 			renderer:$.jqplot.PieRenderer,

// 			rendererOptions: {
// 				showDataLabels: true
//         	}
// 		},

// 		legend: {
// 			show: true,
// 			location: 'e'
// 		},

// 		dum: 0
// 	});
// });

// </script>
// END;
// }



// 	$('#plot_1').bind('jqplotDataClick', function(ev, seriesIndex, pointIndex, data) {
// 		$('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
// 		var d = parseInt(data);
// 		var starttime = new Date(d);
// 		var endtime = new Date(d+$intervallength*1000);
// 		window.location = "/session?after=" + starttime.format('yyyy-mm-dd') + "&before=" + endtime.format('yyyy-mm-dd');
// 	});


