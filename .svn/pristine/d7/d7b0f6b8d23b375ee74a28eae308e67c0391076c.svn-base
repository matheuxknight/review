<?php

showAdminHeader(1);

echo "<h2>Manage Clients</h2>";
$searchtitle = 'Search clients';

showButtonHeader();
showButton('All Clients', array('admin'));

echo <<<END
&nbsp;
<input type='text' name='search' id='search' size='40' class='sans-input'
	onblur="this.value==''?this.value='$searchtitle':''"
	onclick="this.value=='$searchtitle'?this.value='':''"
	value='$searchtitle' />
END;
echo "</div>";

echo "<br>";
echo "<div id='results'>";
$this->renderPartial('results', array('clients'=>$clients, 'pages'=>$pages));
echo "</div>";

echo <<<END
<script>
$(function()
{
	$('#search').bind('keyup', function(event)
	{
		var self = this;
	
		clearTimeout(self.searching);
		self.searching = setTimeout(function()
		{
			refreshClientPage();
		}, 500);
	})
	
});

var currentpagenumber = 1;

function refreshClientPage()
{
	$('#search').addClass('ui-autocomplete-loading');
	
	var searchstring = $('#search').val();
	if(searchstring == '$searchtitle')
		searchstring = '';
	
	$.get("/client/loadresults"+
		"&search="+searchstring+
		"&page="+currentpagenumber,
		"", function(data)
	{
		$('#search').removeClass('ui-autocomplete-loading');
		$('#results').empty();
		$('#results').append(data);
	});
}

</script>

END;



