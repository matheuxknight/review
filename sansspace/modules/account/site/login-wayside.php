<?php

echo <<<end
<script type="text/javascript">
	$(document).ready(function() 
{
	$('#popup').dialog({ autoOpen: false, modal: true, width: '620', dialogClass:'modalpopup' })
	$('#popuplink').click(function(){ $('div#popup').dialog('open'); });
})
</script>
<div id="popup" title="Registering for an account">
    <p class='error' style='font-size:18px; padding:10px' autofocus>If you have never seen this page, you will need to sign up for a new username and password. If you are unable to access an account you already created, use the forgot your password link on the log in page.</p>
    <p style='font-size:14px; text-align:center'><iframe width=480 height=360 frameborder=0 seamless src='http://reviewlearningsite.waysidepublishing.com/file/embed?id=18087'></iframe></p>
</div>
end;

// if(IsMobileDevice())
// {
// echo "<div class='login'>";
// echo "<main class='container'>";
// echo "<h1>Under Construction</h1>";
// echo "<h4>Mobile Device User<br>You are attempting to access the Learning Site from a mobile device. Mobile devices are not supported at this time. We are currently developing a free app for mobile device users. Visit waysidepublishing.com for updates about the release of the Learning Site app.</h4>";
// //echo "<h4>Feel free to access the Learning Site from any popular browser on your Desktop, or Laptop Computer.</h4>";
// echo "<div style='margin-top:-30px' class='row'>";
// echo "<div class='col-md-7'>";
// echo "<div class='row'>";
// echo "<div class='col-md-5'>";
// echo "<p style='text-align:center'>Don't have an account?<br>Create one today!</p>";
// echo "<a href='' class='btn btn-primary btn-lg btn-block'>Sign Up</a>";
// echo "</div>";
// echo "<div class='col-md-7'>";
// echo "<div class='jumbotron'>";
// echo "<form action='/' method='post'>";
// echo "<div class='form-group'>";
// echo "<input type='text' class='form-control' name='LoginForm[username]' id='LoginForm_username' placeholder='username' readonly>";
// echo "</div>";
// echo "<div class='form-group'>";
// echo "<input type='password' class='form-control' name='LoginForm[password]' id='LoginForm_password' placeholder='password' readonly>";
// echo "</div>";
// echo "<div class='checkbox'>";
// echo "<label>";
// echo "<input name='LoginForm[rememberMe]' id='ytLoginForm_rememberMe' type='checkbox'> remember me";
// echo "</label>";
// echo "</div>";
// echo "<div class='arrow-down-shadow'></div>";
// echo "<div class='arrow-down'></div>";
// echo "<a href='' class='btn btn-primary btn-lg btn-block'>Log In</a>";
// echo "</form>";
// echo "</div>";
// echo "<p>";
// echo "<a class='password-reset' href=''>Forgot your password?</a>";
// echo "</p></div></div></div></div><p>";
// echo "Looking for the Legacy Learning Site? <a href='http://legacyreviewlearningsite.waysidepublishing.com'>Click here.</a><br>";
// echo "<em class='fa fa-question-circle'></em> Need help? Contact us at";
// echo "<a href='mailto:support@waysidepublishing.com'> support@waysidepublishing.com</a></p>";
// echo "</main>";
// echo "</div>";
// }

// else
{
echo "<div class='login'>";
echo "<main class='container'>";
echo "<div style='float:right; margin-top:15px'><a href='javascript:void(0)' id='popuplink'><em class='fa fa-question-circle'></em></a>  Don't have an account? ";
echo "<a href='/site/register'>Sign up today!</a></div>";
echo "<h1 style='margin-top:40px'>Start Here</h1>";
echo "<div class='row' style='margin-top:10px'>";
echo "<div class='col-md-7'>";
echo "<div class='row' id='loginbox'>";
echo "<div class='col-md-8' id='loginbox' style='width: 80%'>";
echo "<div class='jumbotron'>";
echo "<form action='/' method='post'>";
echo "<div class='form-group'>";
echo "<input type='text' class='form-control' name='LoginForm[username]' id='LoginForm_username' placeholder='username'>";
echo "</div>";
echo "<div class='form-group'>";
echo "<input type='password' class='form-control' name='LoginForm[password]' id='LoginForm_password' placeholder='password'>";
echo "</div>";
echo "<div class='checkbox'>";
echo "<label>";
echo "<input name='LoginForm[rememberMe]' id='ytLoginForm_rememberMe' type='checkbox'> remember me";
echo "</label>";
echo "</div>";
echo "<div class='arrow-down-shadow'></div>";
echo "<div class='arrow-down'></div>";
echo "<input id='btnSubmit' name='yt0' value='Log In' type='submit' class='btn btn-primary btn-lg btn-block'>";
echo "</form>";
echo "</div>";
echo "<p>";
echo "<a class='password-reset' href='/site/forgot'>Forgot your username or password?</a>";
echo "</p></div></div></div></div><p>";
//echo "Looking for the Legacy Learning Site? <a href='http://legacyreviewlearningsite.waysidepublishing.com'>Click here.</a><br>";
echo "<a href='mailto:support@waysidepublishing.com'><em class='fa fa-question-circle'></em></a> Need help? Contact us at";
echo "<a href='mailto:support@waysidepublishing.com'> support@waysidepublishing.com</a></p>";
echo "</main>";
echo "</div>";
}

