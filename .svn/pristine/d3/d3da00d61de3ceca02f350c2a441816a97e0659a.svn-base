<?php

echo"<h2>SANSSpace Hosts</h2>";

InitMenuTabs('#tabs-properties');

echo <<<END

<div id='tabs-properties' style='display:none;'><ul>
<li><a href='#tabs-1' onclick='refresh_licenses();'>Licenses</a></li>
<li><a href='#tabs-2' onclick='refresh_demo();'>Demo</a></li>
<li><a href='#tabs-3' onclick='refresh_sans();'>SANS</a></li>
</ul><br>

<div id='tabs-1'></div>
<div id='tabs-2'></div>
<div id='tabs-3'></div>
<div id='admin_results'></div>

<script>

var admin_delay = 30000;
var admin_timeout = 0;
var admin_order = "customername";
var admin_refresh = refresh_licenses;

$(function()
{
	admin_refresh();
});

function refresh_licenses()
{
	admin_refresh = refresh_licenses;
	var url = "/sansspacehost/licenses_results?order="+admin_order;

	clearTimeout(admin_timeout);
	$.get(url, '', admin_ready);
}
		
function refresh_demo()
{
	admin_refresh = refresh_demo;
	var url = "/sansspacehost/demo_results?order="+admin_order;

	clearTimeout(admin_timeout);
	$.get(url, '', admin_ready);
}

function refresh_sans()
{
	admin_refresh = refresh_sans;
	var url = "/sansspacehost/sans_results?order="+admin_order;

	clearTimeout(admin_timeout);
	$.get(url, '', admin_ready);
}

function admin_ready(data)
{
	$('#admin_results').html(data);

	clearTimeout(admin_timeout);
	admin_timeout = setTimeout(admin_refresh, admin_delay);
}

function admin_setorder(order)
{
	admin_order = order;
	admin_refresh();
}

function admin_delete(id)
{
	if(confirm("Are you sure you want to delete this host from the list?"))
		window.location = "/sansspacehost/delete?id="+id;
}

function admin_flag(id)
{
	if(confirm("Are you sure you want to update this host to the latest version?"))
		window.location = "/sansspacehost/flag?id="+id;
}


</script>
END;





