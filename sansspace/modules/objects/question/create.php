<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

//echo "<h2>New Question</h2>";
$this->widget('UniForm');

echo <<<END
<style>
.myfields label, .myfields input
{
	display:inline-block;
}

.question_container:hover
{
	background-color: #E3F0F8;
}

</style>
END;

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($question);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels myfields'));

echo "<input name='QuizQuestion[answertype]' type='hidden'></input>";

echo "<div style='margin-left: 10px;width: 600px;'>";
echo "<p><u>Automatically graded questions:</u></p>";

show_create_item(CMDB_QUIZQUESTION_SHORTTEXT, "Short Text", "A short text answer validated against a predefined set of answers.");
show_create_item(CMDB_QUIZQUESTION_SELECT, "Multiple Choice", "The answer is a selection from a predefined set of answers.");
show_create_item(CMDB_QUIZQUESTION_MATCHING, "Matching", "Matches must be made from two lists of choices.");

show_create_item(CMDB_QUIZQUESTION_TRUE, "True", "A true/false question where the answer is true.");
show_create_item(CMDB_QUIZQUESTION_FALSE, "False", "A true/false question where the answer is false.");

echo "<br><hr style='display: block; width: 500px; height: 1px; border: 0; border-top: 1px solid #dfdfdf; margin: 0; padding: 0;'>";
echo "<p><u>Manually graded questions:</u></p>";

show_create_item(CMDB_QUIZQUESTION_LONGTEXT, "Long Text", "The answer is a long text also referred as an essay.");
show_create_item(CMDB_QUIZQUESTION_RECORD, "Simple Recording", "The answer is a simple audio/video recording.");
show_create_item(CMDB_QUIZQUESTION_COMPARATIVE, "Comparative Recording", "Use the comparative recorder to record the audio/video answer.");

echo "<br><hr style='display: block; width: 500px; height: 1px; border: 0; border-top: 1px solid #dfdfdf; margin: 0; padding: 0;'>";
echo "<p><u>Others:</u></p>";

show_create_item(CMDB_QUIZQUESTION_CLOZE, "Cloze", "This type is also referred as \"Fill in the blank\". It uses a special coding to create embedded sub-questions from a text.");
show_create_item(CMDB_QUIZQUESTION_NONE, "Description", "This is not a question as such, but a page with general instructions to read before going to the next question.");

echo "</div>";
echo CUFHtml::closeTag('fieldset');
showSubmitButton('Create');
echo CUFHtml::endForm();

/////////////////////////////////////////////////////////////////////////////

function show_create_item($id, $title, $description)
{
	echo "<div class='question_container' style='padding: 0px;'>";
	echo "<label for='QuizQuestion_answertype_$id' style='line-height:18px;width:550px;float:none;vertical-align:top;padding:5px;'>$title - ";
	echo "<span style='font-weight: normal;'>$description</span></label>";
	
	echo "<input id='QuizQuestion_answertype_$id' value='$id' 
		name='QuizQuestion[answertype]' class='sans-input' type='radio'>";

	echo "</div>";
}




