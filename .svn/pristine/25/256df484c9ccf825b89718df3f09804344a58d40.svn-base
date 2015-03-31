<?php

showAdminHeader(2);
echo "<h2>Global Roles</h2>";

showButtonHeader();
echo "</div><br>";

echo "<table class='dataGrid2'>";
echo "<thead class='ui-widget-header'><tr>";

echo "<th>Role</th>";
echo "<th>Tag</th>";

echo "</tr></thead><tbody>";
echo CUFHtml::beginForm();

$roles = getdbolist('Role', "id > 2 and type like '%user%' order by name");
foreach($roles as $role)
{
	echo "<tr class='ssrow'>";
	echo "<td><b>$role->name</b></td>";
	echo "<td>";
	echo CUFHtml::activeTextField($role, "description[$role->id]", array('maxlength'=>200));
	echo "</td>";
	echo "</tr>";
}

echo "<tbody></table>";
echo "<br/>";

showSubmitButton('Save');
echo CUFHtml::endForm();

