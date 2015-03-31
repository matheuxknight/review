<?php

echo '<b>Compose your message and click send.</b>';
$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($pm);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

if($pm->togroupid)
{
	$pm->togroup = getdbo('Object',$pm->togroupid);
	//Object::model()->findByPk($pm->togroupid);
	
	echo CUFHtml::openCtrlHolder();
	echo CUFHtml::activeLabelEx($pm, 'togroupid');
	echo CUFHtml::textField('To Group', $pm->togroup->name, 
		array('maxlength'=>200, 'readonly'=>true));
	echo "<p class='formHint2'>.</p>";
	echo CUFHtml::closeCtrlHolder();
	
	echo CHtml::activeHiddenField($pm, 'togroupid');
}

else
{
	$usernames = '';
	$userlist = explode(';', $pm->touserid);
	foreach($userlist as $userid)
	{
		$userid = trim($userid);
		if(empty($userid)) continue;
		
		$user = getdbo('User', $userid);
		//User::model()->findByPk($userid);
		if($user)
			$usernames .= $user->name.'; ';
	}

	echo CUFHtml::openCtrlHolder();
	echo CUFHtml::activeLabelEx($pm, 'touserid');
	showAutocompleteUser('PrivateMessage_touserid', $usernames);
	echo CHtml::activeHiddenField($pm, 'touserid');
	echo "<p class='formHint2'>Start typing the name of the user you want to send a message to and select from the drop-down box.</p>";
	echo CUFHtml::closeCtrlHolder();
}

echo CUFHtml::openActiveCtrlHolder($pm, 'name');
echo CUFHtml::activeLabelEx($pm, 'name');
echo CUFHtml::activeTextField($pm, 'name', array('maxlength'=>200));
echo "<p class='formHint2'>Enter the subject of your message.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($pm, 'doctext');
echo CUFHtml::activeTextArea($pm, 'doctext');
showAttributeEditor($pm, 'doctext', 240, 'custom1');
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openCtrlHolder();
echo CUFHtml::activeLabelEx($pm, 'draft');
echo CUFHtml::activeCheckBox($pm, 'draft', array('class'=>'miscInput'));
echo "<p class='formHint2'>Check this box to only save your message in your Draft box. 
The message will not be sent.</p>";
echo CUFHtml::closeCtrlHolder();
	
//echo CUFHtml::openCtrlHolder();
//echo CUFHtml::activeLabelEx($pm, 'smtp');
//echo CUFHtml::activeCheckBox($pm, 'smtp', array('class'=>'miscInput'));
//echo "<p class='formHint2'>Check this box to also send an SMTP email to user(s).</p>";
//echo CUFHtml::closeCtrlHolder();
	
echo CUFHtml::closeTag('fieldset');
showSubmitButton('Send');
echo CUFHtml::endForm();

