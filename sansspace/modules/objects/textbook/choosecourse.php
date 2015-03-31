<?php

$textbook = $code->object;
$listcount = getdbocount('VCourse', "parentid=$code->objectid");

echo "<h2>Choose my course</h2>";
echo "Courses available for this code: <b>$code->code</b><br>";

echo "<table width='100%' class='sstitle'><tr>";
echo "<td width=56>";
echo objectImage($textbook);
echo "</td>";
echo "<td>$textbook->name</td>";
echo "</tr></table>";

echo CUFHtml::label('Search: ', '').' ';
echo CUFHtml::textField('course_search_input', '', array('class'=>'textInput', 'maxlength'=>200));

echo "(Course, Teacher, School, City, State, ZIP Code, or Country)<br><br>";

echo <<<end

<div id='show_results'>$listcount matches</div>

<script>
$(function()
{
//	$.get('/textbook/choosecourse_results?code=$code->code', '', function(data)
//	{
//		$('#show_results').html(data);
//	});

	$('#course_search_input').bind('keyup', function(event)
	{
		var searchstring = $('#course_search_input').val();
		if(searchstring == '') return;
		
		$.get('/textbook/choosecourse_results?code=$code->code&search='+searchstring, '', function(data)
		{
			$('#show_results').html(data);
		});
	})
});

function doenrollment(code, courseid)
{
	if(confirm("Are you sure you want to enroll into this course? This action cannot be undone."))
		window.location.href='/textbook/studentenroll?code='+code+'&courseid='+courseid;
}

</script>
end;







