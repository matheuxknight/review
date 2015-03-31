<?php

showNavigationBar($course->parent);
showObjectHeader($course);
showObjectMenu($course->object);

showButtonHeader();
showButton('New Question', array('create', 'id'=>$course->id));
showButton('Manage Questions', array('editor', 'id'=>$course->id));
echo "</div>";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($quiz);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($quiz, 'allowback');
echo CUFHtml::activeLabelEx($quiz, 'allowback');
echo CUFHtml::activeCheckBox($quiz, 'allowback');
$student = getdbosql('Role', "name='student'");
echo "<p class='formHint2'>If checked, {$student->description}s will be allowed to navigate back and forth between questions.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($quiz, 'allowvideo');
echo CUFHtml::activeLabelEx($quiz, 'allowvideo');
echo CUFHtml::activeCheckBox($quiz, 'allowvideo');
echo "<p class='formHint2'>If checked, {$student->description}s will be allowed to use their webcam for recordings.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Save');
echo CUFHtml::endForm();




