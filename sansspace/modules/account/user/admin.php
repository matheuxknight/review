<?php

showAdminHeader(2);
echo "<h2>Manage Users</h2>";
$searchtitle = '';

showButtonHeader();
showButton('All Users', array('admin'));
showButton('New User', array('create'));
showButtonPost('Delete Unenrolled Students', 
	array('submit'=>array('deleteunenrolled'),'confirm'=>'Are you sure you want to delete all unenrolled users?'));

echo <<<END
&nbsp;
<input type='text' name='search-user' id='search-user' size='40' class='sans-input'
	onblur="this.value==''?this.value='$searchtitle':''"
	onclick="this.value=='$searchtitle'?this.value='':''"
	style='margin-bottom: 0;'
	value='$searchtitle' />
END;

// $userroles = Role::model()->listOptions;

echo "</div>";

InitMenuTabs('#tabs');

echo "<br><div id='tabs' style='display:none;'><ul>";
echo "<li><a href='#results'>All</a></li>";
echo "<li><a href='#results'>Students</a></li>";
echo "<li><a href='#results'>Teachers</a></li>";
echo "<li><a href='#results'>Content Managers</a></li>";
echo "<li><a href='#results'>Admins</a></li>";
echo "<li><a href='#results'>Network Admins</a></li>";

echo "</ul>";

echo "<br>";
echo "<div id='results'>";
$this->renderPartial('results', array('users'=>$users, 'pages'=>$pages));
echo "</div>";

echo "</div>";

echo <<<END
<script>

var pagenumber = 1;

$(function()
{
	$("#tabs").tabs({
		activate: function(event, ui)
		{
			pagenumber = 1;
			refreshUserPage();
		}
	});

	$('#search-user').bind('keyup', function(event)
	{
		var self = this;

		clearTimeout(self.searching);
		self.searching = setTimeout(function()
		{
			pagenumber = 1;
			refreshUserPage();
		}, 500);
	})

});

function refreshUserPage()
{
	var searchstring = $('#search-user').val();
	if(searchstring == '$searchtitle')
		searchstring = '';

	var roletab = $('#tabs').tabs("option", "active");
	$.get("/user/loadresults"+
		"&search="+searchstring+
		"&roletab="+roletab+
		"&page="+pagenumber,
		"", function(data)
	{
		$('#results').html(data);
	});
}

</script>

END;





