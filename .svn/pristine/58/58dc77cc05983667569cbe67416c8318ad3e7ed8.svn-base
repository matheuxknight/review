<?php

$downloadlink = l(mainimg('16x16_bottom.png'), 
	array('usercsv', 
		'Name'=>$user->name,
		'Logon'=>$user->logon,
		'Email'=>$user->email,
		'Role'=>$user->role,
		'Domain'=>$user->domain,
		'Created'=>$user->created,
		'Last'=>$user->accessed,
	), 
	array('title'=>'Download CSV', 'target'=>'_blank'));


$currentPage = $pages->currentPage+1;
echo "<font color=green>".count($users)." / {$pages->itemCount} users found. Page {$currentPage} of {$pages->pageCount}</font>&nbsp;&nbsp;$downloadlink<br><br>";

$this->widget('CLinkPager', array('pages'=>$pages));
if($pages->pageCount > 1) echo "<br><br>";

showTableSorter('maintable', '{headers: {7: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th width=20></th>";
echo "<th>Name</th>";
echo "<th>Logon</th>";
echo "<th>Email</th>";
//echo "<th>Custom</th>";
//echo "<th>Role</th>";
//echo "<th>Domain</th>";
echo "<th>Created</th>";
echo "<th>Last Online</th>";
echo "<th>Course Status</th>";
if(param('theme')=='wayside')
	echo "<th>Exempt Status</th>";
echo "<th>Delete User</th>";
echo "</tr></thead><tbody>";

foreach($users as $model)
{
	echo "<tr class='ssrow'>";
	echo "<td>".userImage($model, 18)."</td>";

	echo "<td style='font-weight: bold;'>";
	showUserMenuContext($model, array('user/update', 'id'=>$model->id));
	echo "</td>";

	echo "<td>$model->logon</td>";
	echo "<td>$model->email</td>";
//	echo "<td>$model->roleText</td>";
//	echo "<td>$model->custom1</td>";
//	echo "<td>{$model->domain->name}</td>";

	echo "<td nowrap>".datetoa($model->created)."</td>";
	echo "<td nowrap>".datetoa($model->accessed)."</td>";

	//$count = dboscalar("select count(*) from CourseEnrollment where userid=$model->id");
	//$count = dboscalar("select count(*) from ObjectEnrollment where userid=$model->id");
	//$count = $form->courseCount;
	
	$count = $model->enrolled;	
	
	echo "<td>$count</td>";

	if(param('theme')=='wayside')
		echo "<td>$model->exempt</td>";

	echo "<td style='text-align:center'>";
	echo l(mainimg('16x16_delete.png'), '#', array('id'=>"delete_user_{$model->id}"));

	echo <<<END
<script>$(function(){ $('#delete_user_{$model->id}').click(function(){
	if(confirm('Are you sure you want to delete this user {$object->name}?'))
		jQuery.yii.submitForm(this, '',{'command':'delete','id':'$model->id'});
	return false;});});</script>
END;

	echo "</td>";

	echo "</tr>";
}

echo "</tbody></table>";

echo "<br>";
$this->widget('CLinkPager', array('pages'=>$pages));

echo <<<END
<script>
$(function()
{
	$('a', '.yiiPager').click(function()
	{
		var link = $(this).attr('href');
		var res = link.match(/page=\d+/);
		if(res)
		{
			res = res[0].match(/\d+/);
			pagenumber = res[0];
		}
		else
			pagenumber = 1;

		refreshUserPage();
		return false;
	});
});
</script>
END;




