<?php

echo "<h2>Edit Cron Job</h2>";

showButtonHeader();
showButton('All Jobs',array('admin'));
showButton('New Job', array('create'));
showButtonPost('Run Job', array('submit'=>array('runnow','id'=>$cronjob->id),'confirm'=>'Are you sure you want to run this job now?'));
showButtonPost('Delete Job', array('submit'=>array('delete','id'=>$cronjob->id),'confirm'=>'Are you sure you want to delete this job?'));

$export = getdbosql('Export', "cronjobid='$cronjob->id'");
if ($export)
{
	showButton('Edit Export', array('export/update', 'id'=>$export->id));
}

else
{	$roster = getdbosql('Roster', "cronjobid='$cronjob->id'");
	if ($roster)
	{
		showButton('Edit Roster', array('roster/update', 'id'=>$roster->id));
	}
}
	

echo "</div>";

echo $this->renderPartial('_form', array(
		'cronjob'=>$cronjob,
		'update'=>true,
));

