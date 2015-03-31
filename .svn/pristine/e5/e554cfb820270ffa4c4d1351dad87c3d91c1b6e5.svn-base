<?php

showRoleBar($object);
showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

echo CUFHtml::label('Search: ', '').' ';
echo CUFHtml::textField('code_search_input', '', array('class'=>'textInput', 'maxlength'=>200)).' ';

echo button('Upload Code List', array('upload', 'id'=>$object->id)).' ';
echo button('Delete All', "javascript:delete_all_code();").' ';

echo <<<end

<div id='show_results'></div>
<script>

$(function()
{
	$.get('/textbook/show_results?id=$object->id', '', function(data)
	{
		$('#show_results').html(data);
	});

	$('#code_search_input').bind('keyup', function(event)
	{
		var searchstring = $('#code_search_input').val();
		$.get('/textbook/show_results?id=$object->id&search='+searchstring, '', function(data)
		{
			$('#show_results').html(data);
		});
	})

})

function select_status(status)
{
	var searchstring = $('#code_search_input').val();
	$.get('/textbook/show_results?id=$object->id&search='+searchstring+'&status='+status, '', function(data)
	{
		$('#show_results').html(data);
	});
}

function delete_code(id)
{
	if(confirm('Are you sure you want to delete this code?'))
		window.location.href='/textbook/deletecode?id='+id;
}

function delete_all_code()
{
	if(confirm('Are you sure you want to delete all codes?'))
		window.location.href='/textbook/deleteallcode?id=$object->id';
}

</script>

end;



