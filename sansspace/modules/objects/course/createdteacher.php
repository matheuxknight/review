<?php

echo "<main class='error' style='width:780px'><h2>Congratulations!</h2>";
echo "<h4>Your course has been successfully created, and you are ready to use your Learning Site.</h4>";

echo "<div style='text-align:center; margin-top:16px'>";
echo "<a href='/course?id=$course->id'>";
echo "<input style='margin-right:5px' id='btnSubmit' type='Submit' class='submitButton ui-button ui-widget ui-corner-all ui-state-default' value='Go to your course' role='button' aria-disabled='false'>";
echo "</a>";

echo "<a href='/textbook/addteachercourse'>";
echo "<input style='margin-left:5px' id='btnSubmit' type='Submit' class='submitButton ui-button ui-widget ui-corner-all ui-state-default' value='Create another course' role='button' aria-disabled='false'>";
echo "</a>";
echo "</div>";
echo "</main>";






