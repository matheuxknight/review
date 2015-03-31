<?php

$this->pageTitle = "$course->name";
include '/sansspace/ui/lib/pageheader.php';

$appid = 'sansmediad';

echo <<<END
<style>
html
{
	height: 100%;
	overflow: hidden;
}

body
{
	height: 100%;
	margin: 0;
	padding: 0;
}

#$appid
{
	height: 100%;
}
</style>
		
<script>

var window_show_screen;
		
function start_show_screen(phpsessid)
{
	window_show_screen = window.open("/connect/showscreen?id="+phpsessid, "sans_course_chat_screen", 
		"width=1024,height=768,location=no,menubar=no,resizable=yes,status=yes,toolbar=no");
}

function stop_show_screen()
{
	window_show_screen.close();
}

</script>
		
</head>
<body>
END;


$getflash = mainimg('getflash.jpg');
$flashvars = "courseid=$course->id";

ShowApplication($flashvars, 'player', $appid, '100%');
JavascriptReady("RightClick.init('$appid');");

echo "</body></html>";








