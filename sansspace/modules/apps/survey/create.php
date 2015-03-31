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
echo CUFHtml::errorSummary($survey);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels myfields'));

echo "<input name='Survey[answertype]' type='hidden'></input>";
echo "<div style='margin-left: 10px;width: 600px;'>";

show_create_item(CMDB_SURVEYTYPE_SELECT, "Multiple Choice", "The answer is a selection from a predefined set of answers.");
show_create_item(CMDB_SURVEYTYPE_RANK, "Rank Order", "Rank item options from 1 to x.");
show_create_item(CMDB_SURVEYTYPE_TEXT, "Text", "A text answer.");
show_create_item(CMDB_SURVEYTYPE_YESNO, "Yes/No", "A yes/no question.");
show_create_item(CMDB_SURVEYTYPE_AGREEDIS, "Agree/Disagree", "An agree/disagree question.");
show_create_item(CMDB_SURVEYTYPE_NONE, "Description", "This is not a question as such, but a page with general instructions to read before going to the next question.");

echo "</div>";
echo CUFHtml::closeTag('fieldset');
showSubmitButton('Create');
echo CUFHtml::endForm();

/////////////////////////////////////////////////////////////////////////////

function show_create_item($id, $title, $description)
{
	echo "<div class='question_container' style='padding: 0px;'>";
	echo "<label for='Survey_answertype_$id' style='line-height:18px;width:550px;float:none;vertical-align:top;padding:5px;'>$title - ";
	echo "<span style='font-weight: normal;'>$description</span></label>";
	
	echo "<input id='Survey_answertype_$id' value='$id' 
		name='Survey[answertype]' class='sans-input' type='radio'>";

	echo "</div>";
}




