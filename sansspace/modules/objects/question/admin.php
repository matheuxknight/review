<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

echo CUFHtml::label('Search: ', '');
echo CUFHtml::textField('bank_search_input', '', array('class'=>'textInput', 'maxlength'=>200));

echo "<div id='admin_results'></div>";

echo <<<end
<script>

$(function()
{
	$.get('/question/admin_results?id=$object->id', '', function(data)
	{
		$('#admin_results').html(data);
	});

	$('#bank_search_input').bind('keyup', function(event)
	{
		var searchstring = $('#bank_search_input').val();
		$.get('/question/admin_results?id=$object->id&search='+searchstring, '', function(data)
		{
			$('#admin_results').html(data);
		});
	})

})

function delete_question(id)
{
	if(confirm('Are you sure you want to delete this question?'))
		window.location.href='/question/delete?id='+id;
}

</script>
end;







