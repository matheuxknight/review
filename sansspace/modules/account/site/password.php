<?php

$this->pageTitle=Yii::app()->name . ' Forgot Password';

echo '<h2>Change Password</h2>';
echo "<p>Welcome back {$user->name},<br><br>You can change your password below.</p>";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($form);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($form, 'password');
echo CUFHtml::activeLabelEx($form, 'password');
echo CUFHtml::activePasswordField($form, 'password', array('maxlength'=>200));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($form, 'confirm_password');
echo CUFHtml::activeLabelEx($form, 'confirm_password');
echo CUFHtml::activePasswordField($form, 'confirm_password', array('maxlength'=>200));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Submit');
echo CUFHtml::endForm();


