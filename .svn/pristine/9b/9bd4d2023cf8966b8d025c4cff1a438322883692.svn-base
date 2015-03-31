<?php

showAdminHeader(3);
echo "<h2>Admin Search</h2>";

showButtonHeader();
showButton('All', array('search'));
showButton('Deleted', array('search', 'param'=>'deleted'));
showButton('Orphan', array('search', 'param'=>'not parentid'));
showButton('Hidden', array('search', 'param'=>'hidden'));
showButton('Link', array('search', 'param'=>'linkid'));
showButton('Recordings', array('search', 'param'=>'recordings'));
showButton('Custom Permissions', array('search', 'param'=>'custompermission'));
showButton('Forum', array('search', 'param'=>'post'));
echo "</div>";

$param = isset($_GET['param'])? $_GET['param']: '';
echo <<<END

<br><br>
Extra database parameters: 
<input type='text' name='adminsearchinput' id='adminsearchinput' size='40' value='$param' />

<a id='adminsearchbutton'>Search</a>
<br><br>

<script>

$('#adminsearchinput').bind('keyup', function(e) {
	if(e.keyCode == '13') gotoadminsearch($('#adminsearchinput').val()); });
	
$('#adminsearchbutton').button()
.click(function(e) {gotoadminsearch($('#adminsearchinput').val())});

function gotoadminsearch(searchstring)
{
	window.location.href = '/admin/search&param='+encodeURI(searchstring);
}

</script>		
END;

showFolderContents("adminsearch&param=$param");



