<?php

showAdminHeader(0);
echo "<h2>Manage Contacts</h2>";

showButtonHeader();
showButton('Edit Contact Page', array('edit'));
echo "</div>";
echo "<br>";

showTableSorter('maintable', '{headers: {4: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Name</th>";
echo "<th>Subject</th>";
echo "<th>Email</th>";
echo "<th>Created</th>";
echo "<th></th>";
echo "</tr></thead><tbody>";

foreach($contactList as $n=>$model)
{
	echo "<tr class='ssrow'>";
	echo "<td style='font-weight: bold;'>".
		l(h($model->name), array('update', 'id'=>$model->id))."</td>";
	echo "<td>$model->subject</td>";
	echo "<td>$model->email</td>";
	echo "<td nowrap>".datetoa($model->created)."</td>";
	echo "<td>";
	echo CHtml::linkButton(mainimg('16x16_delete.png'), array(
		'submit'=>'',
		'params'=>array('command'=>'delete', 'id'=>$model->id),
		'confirm'=>"Are you sure to delete {$model->name}?"));
	echo "</td>";
	echo "</tr>";
}

echo "</tbody></table>";


