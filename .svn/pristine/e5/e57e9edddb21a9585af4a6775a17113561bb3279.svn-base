<?php

$this->pageTitle=Yii::app()->name . ' Forgot Password';

echo '<h2>Username and Password Retrieval</h2>';
echo "<h4 style='color:#ec4546'>Legacy Learning Site User: Your Legacy Site log in information will not work on the new Learning Site. You will need to sign up for a new username and password by clicking \"Sign up today!\" on the home page.</h4>";

echo '<p> If you already have an account on the Learning Site, but forgot your username and/or password, type in either your username or your email address in the fields below, enter the verification code, and click the Submit button.';
echo '</br>You will then receive an email with your username and instructions on how to reset your password if needed.</p>';

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($form);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($form, 'name');
echo CUFHtml::activeLabelEx($form, 'name', array('label'=>'Username'));
echo CUFHtml::activeTextField($form, 'name', array('maxlength'=>200));
echo "<p class='formHint2'>Your username on the Learning Site.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($form, 'email');
echo CUFHtml::activeLabelEx($form, 'email');
echo CUFHtml::activeTextField($form, 'email', array('maxlength'=>200));
echo "<p class='formHint2'>Or, the email address you used to register your account.</p>";
echo CUFHtml::closeCtrlHolder();

if(extension_loaded('gd'))
{
	echo CUFHtml::openActiveCtrlHolder($form, 'verifyCode');
	echo CUFHtml::activeLabel($form, 'verifyCode', array('label'=>'Enter code on right:'));
	echo CUFHtml::activeTextField($form, 'verifyCode');
	echo "<p class='formHint2'>Enter the letters as they are shown in the image below.
		Letters are not case-sensitive.</p>";
	echo CUFHtml::closeCtrlHolder();

	echo "<div style='float: right; width:35%;'>";
	$this->widget('CCaptcha');
	echo "</div>";
}

echo CUFHtml::closeTag('fieldset');
showSubmitButton('Submit');
echo CUFHtml::endForm();

echo "<br><br><br><br><br><br><br><br><br><br>";
echo "<footer>";
echo "<div class='container'>";
echo "<div class='row' style='max-width:910px'>";
echo "<div class='col-md-8' style='margin-top:10px;float:left;width:auto'>";
echo "<p class='footer-contact'>";
echo "<em class='fa fa-question-circle'></em> Need help? <a id='contactlink' class='contactlink' href='mailto:support@waysidepublishing.com'>Contact us.</a></p>";
echo "<p7>Copyright &#169; 2010-2014 <a href='http://www.waysidepublishing.com' style='text-decoration:none'  target='_blank'>Wayside Publishing.</a> All Rights Reserved.<br>Audios, videos, and visual materials are copyright protected and may not be downloaded without permission from <a href='http://www.waysidepublishing.com' style='text-decoration:none'  target='_blank'>Wayside Publishing.</a><br>";
echo <<<end
<br>
</p7></div><div style="max-width:40px"></div>
          <div class="col-md-3 powered-by" style="width:201px;padding-left:0px">
            <p style="margin-top:-4px">
                Powered by
            </p>
           <img style="padding-top:10px" src="/contents/16826.png" alt="Sansspace logo">
           <img style="margin-left:0px;margin-top:-2px" src="/contents/17884.png">
          </div>
        </div> <!-- .row -->
      </div> <!-- .container -->
    </footer>  
end;
