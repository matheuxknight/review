<?php
echo "<h2>Edit Semester</h2>";

showButtonHeader();
showButton('All Semesters', array('admin'));
showButton('New Semester', array('create'));
showButton('Bump Semester', array('bump', 'id'=>$semester->id));
showButtonPost('Delete Semester', array('submit'=>array('delete','id'=>$semester->id),'confirm'=>'Are you sure?'));
showButton('Semester Courses', array('admin/courses', 'semesterid'=>$semester->id));
echo "</div>";

echo $this->renderPartial('_form', array(
	'semester'=>$semester,
	'update'=>true,
));

