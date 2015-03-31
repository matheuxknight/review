<?php

showNavigationBar($course->parent);
showObjectHeader($course);
showObjectMenu($course->object);

echo "<h3>Add a Roster File</h3>";
echo "<p>Select a roster file and upload it to populate this course enrollment.</p>";

$this->widget('UniForm');
ShowUploadHeader();

echo CUFHtml::beginForm(array('course/addusers', 'id'=>$course->id));
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Roster File', 'rosterfileid');
echo '<div class="miscInput"><span id="spanButtonPlaceholder"></span></div>';
echo "<p class='formHint2'>Select your roster file from your local drive.</p>";
echo CUFHtml::closeCtrlHolder();
echo '<div class="flash" id="fsUploadProgress"></div>';

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Field Delimiter', 'fielddelim');
echo CUFHtml::textField('fielddelim', ',', array('class'=>'textInput'));
echo "<p class='formHint2'>The character used to delimit fields. 
Example are a comma \",\" for csv or \"\\t\" for tabs.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::label('Line Delimiter', 'linedelim');
echo CUFHtml::textField('linedelim', '\n', array('class'=>'textInput'));
echo "<p class='formHint2'>The character used to delimit rows. 
It is usually \"\\n\" for newline.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');

showSubmitButton('Upload');
echo CUFHtml::endForm();

echo <<<END

<p>The file can be a text or a csv file and should contain one entry per line.<p>

<p>In the first scenario, each line must have a reference to a registered user 
in SANSSpace. It can be using the short login name OR the complete person's name. 
Optionally, each line can provide the role for that person in this course. 
If the role is not provided, it defaults to student.
</p>

Example:<br>
<pre>
Robert Jones,student
lisa
Mary Lewis,teacher
</pre>

<p>If your roster file contains user names that are not already registered
into SANSSpace, it will need to provide both the short login name AND the 
complete person's name. It is recommended to also provide an email address
for new users.
</p>

Example:<br>
<pre>
bob,Robert Jones,bob@school.edu,student
lisa,Lisa Brown,lisa@school.edu,student
mary,Mary Lewis,mary@school.edu,teacher
pete,Peter Wood,pete@school.edu,content
</pre>

<br>
END;



