<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

$folderid = $object->id;
$foldername = $object->name;

$quiz = getdbo('Quiz', $object->id);
if($quiz->bank)
{
	$folderid = $quiz->bank->id;
	$foldername = $quiz->bank->name;
}

echo "<h3>Add Questions</h3>";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Question Bank', '');
echo CUFHtml::hiddenField('bankid');
echo CUFHtml::textField('bankid_xx', '', array('class'=>'textInput', 'readonly'=>true));
JavascriptReady("onShowObjectBrowser(0, false, true,
	'bankid', 'bankid_xx', $folderid, '$foldername', bankFileSelected);");
echo "<p class='formHint2'>.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Search', '');
echo CUFHtml::textField('bank_search_input', '', array('class'=>'textInput', 'maxlength'=>200));
echo CUFHtml::closeCtrlHolder();

echo "<div id='bank_results'></div>";

echo "<br>&nbsp;&nbsp;";
echo CHtml::checkBox("all_objects_selector", false);
echo "&nbsp;&nbsp;Select All";

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Add');
echo CUFHtml::endForm();

echo <<<end

<script>

$(function()
{
	$('#bank_search_input').bind('keyup', function(event)
	{
		var searchstring = $('#bank_search_input').val();
		var selectedid = $('#bankid').val();
		
		$.get('/quiz/bank_results?id='+selectedid+'&search='+searchstring, '', function(data)
		{
			$('#bank_results').html(data);
		});
	});

	$('#all_objects_selector').change(function(e)
	{
		var selected = this.checked;
		$('.all_objects_select').attr('checked', selected);
	});
})

function bankFileSelected(selectedid, selectedname)
{
	$.get('/quiz/bank_results?id='+selectedid+'&quizid=$quiz->quizid', '', function(data)
	{
		$('#bank_results').html(data);
	});
}

</script>

end;





