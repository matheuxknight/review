<?php

echo "<h2>User Generation</h2>";

////////////////////////////////////////////////////////////////////////////////////

$semester_objects = getdbolist('Semester', '1 order by starttime desc');
$semester_table = CHtml::listData($semester_objects, 'id', 'name');

//$semester_table = Semester::model()->options;

foreach($semester_objects as $semester)
	JavascriptReady("SansspaceSessionToolbar.addSemester($semester->id, '$semester->starttime', '$semester->endtime')");

$semester = getCurrentSemester();

$lvl_table = array(1 =>
	"1- Low",
	"2- Medium",
	"3- Heavy"
);

echo CUFHtml::beginForm('usergen/simulate', 'post');
echo <<<END

 	Name: <input type='text' name='nameField' id='nameField' size='30' class='sans-input'
	onblur="this.value==''?this.value='$searchusers':''"
	onclick="this.value=='$searchusers'?this.value='':''"
	value='$tempusers' />
	
	<br>
	<br>
	
	Number: <input type='text' name='numberField' id='numberField' size='15' class='sans-input'
	onblur="this.value==''?this.value='$searchusers':''"
	onclick="this.value=='$searchusers'?this.value='':''"
	value='$tempusers' />
	<br>
	<br>
END;

echo "Activity level: ";
echo CHtml::dropDownList('lvl', $year, $lvl_table);

echo"<br> <br>";
echo "Semester: ";
echo CHtml::dropDownList('semester', $semester->id, $semester_table,
	array('onchange'=>'SansspaceSessionToolbar.semesterChanged()'));

echo <<<END
	<br>
	<br>
	
 	Course: <input type='text' name='courseField' id='courseField' size='30' class='sans-input'
	onblur="this.value==''?this.value='$searchusers':''"
	onclick="this.value=='$searchusers'?this.value='':''"
	value='$tempusers' />
	
END;

echo "<br>";
echo "<br>";
echo CUFHtml::submitButton('Generate Now', array('id'=>'btnSubmit',
));

echo CUFHtml::endForm();










