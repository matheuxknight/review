<?php

echo "<h2>Online Users</h2>";

echo "<input type=checkbox id='show-guest'><label for='show-guest'>Show anonymous guests</label>";
echo "<br><br>";


echo "<div id='online_results'></div>";
echo "<br/>";

echo <<<END
<script>

var online_delay = 30000;
var online_timeout = 0;
var online_order = "duration";

$(function()
{
	$('#show-guest').change(function(e)
	{
		online_refresh();
	});

	online_refresh();
});

function online_ready(data)
{
	$('#online_results').html(data);

	clearTimeout(online_timeout);
	online_timeout = setTimeout(online_refresh, online_delay);
}

function online_refresh()
{
	var url = "/user/online_results"+
		"?order="+online_order+
		"&guest="+$('#show-guest').attr('checked');
	
	clearTimeout(online_timeout);
	$.get(url, '', online_ready);
}

function online_setorder(order)
{
	online_order = order;
	online_refresh();
}

function online_logoff(id)
{
	if(confirm('Are you sure you want to force this user to logout?'))
		window.location.href='/connection/forcelogout?id='+id;
}

</script>
END;









