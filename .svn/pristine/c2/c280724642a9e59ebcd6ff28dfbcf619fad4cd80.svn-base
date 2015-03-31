<?php

$this->pageTitle = Yii::app()->name . ' Login';
echo "<h2>SANSSpace Login</h2>";

$server = getdbo('Server', 1);
if($server && !empty($server->accessdenied)) echo "<div style='width: 640px;'>$server->accessdenied</div>";

echo '<p style="width: 640px;">Enter your credential information below to authenticate yourself and gain
access to the resources on this site.</p>';

echo <<<END

<div class="sans-login-container">

<table><tr>
<td valign=top><img style="padding-top: 10px;" src=/images/base/login.png></td>
<td width=20></td>
<td><form action="/" method="post">

<p class="sans-login-prompt">User Name:</p>
<p class="sans-login-prompt">
<input type="text" class="sans-input" size="26" style="margin-left: 0"
	name="LoginForm[username]" id="LoginForm_username" ></p>
			
<p class="sans-login-prompt">Password</p>
<p class="sans-login-prompt">
<input type="password" class="sans-input" size="26" style="margin-left: 0"
	name="LoginForm[password]" id="LoginForm_password" ></p>
			
<label for="ytLoginForm_rememberMe">Remember me</label>
<input type="checkbox" name="LoginForm[rememberMe]" id="ytLoginForm_rememberMe" ><br><br>

<input type=submit id='btnSubmit' name='yt0' value="Login" >

</form></td></tr></table><br><br>

END;

JavascriptReady("$('#btnSubmit').button();");
JavascriptReady("$('#LoginForm_username').focus();");

if(param('allowregister'))
{
	echo l('Create an account', array('site/register')).'<br>';
}

echo l('I forgot my password', array('site/forgot')).'<br>';

if(controller()->identity->casdomain)
	echo l('Central Authentication Service (CAS)', array('site/cas')).'<br>';






