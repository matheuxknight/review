<?php

function showPageHeader()
{
	echo "<div class='sansspace-header'>";

	if(param('theme') != 'wayside')
		echo mainimg('sansspace-stamped-logo.png', '',
			array('width'=>'128', 'style'=>'padding: 0px; float: right;'));

 	$customheader = currentPageHeader();
	if(!empty($customheader))
		echo $customheader;
	
	showTopHeaderMenu();

	echo "<div style='clear:both'></div>";
	echo "</div>";
	
	$color = param('topback');
	JavascriptReady("$('.sansspace-header').css('background', '$color');");
}

function showTopHeaderMenu()
{
	$user = getUser();
	echo "<div id='headermenu'> ";

	if(IsMobileDevice() && !IsMobileEmbeded())
	{
// 		$returnurl = preg_replace('/&.*$/', '', $_SERVER['REQUEST_URI']);
		
// 		$appheadcolor = param('appheadercolor');
// 		$appheadback = param('appheaderback');
// 		$customcolor2 = currentPageColor2();
		
// 		if(!empty($customcolor2))
// 			$appheadback = $customcolor2;
			
// 		$flashvars = 
// 			"&headercolor=".preg_replace('/#/', '0x', $appheadcolor).
// 			"&headerback=".preg_replace('/#/', '0x', $appheadback).
// 			"&maincolor=".preg_replace('/#/', '0x', param('appmaincolor')).
// 			"&mainback=".preg_replace('/#/', '0x', param('appmainback')).
// 			"&mainalpha=".preg_replace('/#/', '0x', param('appmainalpha')).
// 			"&slidercolor=".preg_replace('/#/', '0x', param('appslidercolor')).
// 			"&phpsessid=".session_id().
// 			"&returnurl=".getFullServerName().$returnurl.
// 			"&servername=".$_SERVER['HTTP_HOST'].
// 			"&connect=".getPlayerConnect().
// 			"&connectrtmpt=".getPlayerConnectRtmpt().
// 			"&connecthttp=".getFullServerName().
// 			"&autosave=".param('appautosave').
// 			"&bookmarkprefix=".param('bookmarkprefix');
		
// 		$mode = 'browser';
// 		echo "<a href='javascript:window.location=\"sansspace:mode=$mode&$flashvars\"'>Mobile App</a> | ";

		echo "<a href='/site/startmobileapp'>Mobile App | </a>";
	}
	
	if(param('linkname1') != '' && param('linkurl1') != '')
		echo l(param('linkname1'), param('linkurl1'), array('target'=>'_blank'))." | ";

	if(param('linkname2') != '' && param('linkurl2') != '')
		echo l(param('linkname2'), param('linkurl2'), array('target'=>'_blank'))." | ";

//	echo l("Contact us", array('site/contact'))." | ";

	if(user()->isGuest)
	{
//		echo "<a href='http://www.sansinc.com/communities/' target='_blank'>Community</a> | ";
		if(param('theme') != 'wayside')
		{
			if(param('allowregister'))
				echo l("Register", array('site/register'))." | ";
			
			if(controller()->identity->casdomain)
			{
				if(controller()->identity->casdomain->casexclusive)
					echo l("Login", array('site/cas'));
				else
				{
					echo l("CAS", array('site/cas'))." | ";
					echo l("Login", array('site/login'));
				}
			}
			else
				echo l("Login", array('site/login'));
		}
	}
	else
	{
//		if(strstr($_SERVER['SERVER_NAME'], 'sansspace.com'))
//		{
//			echo "<a href='http://www.sansinc.com/communities/' target='_blank'>Community</a> | ";
//		}
		
// 		else
// 		{
// 			$title = param('title');
			
// 			$ident = base64_encode("$user->name,$user->email,$title");
// 			$params = "http://community.sansspace.com/?communityident=$ident";
		
// 			echo "<a href='#' id='community_button'>Community</a> | ";
// 			JavascriptReady("$('#community_button').click(function(e){window.open('$params', '_blank');});");
// 		}
		
		if(controller()->rbac->globalAdmin())
			echo l("Who's Online", array('user/online'), array('id'=>'whos_online'))." | ";
		
		echo l("Logout ($user->name)", array('site/logout'));
	}

	echo "</div>";
	
	$color = param('linkcolor');
	
	JavascriptReady("$('#headermenu>a').css('color', '$color')");
	JavascriptReady("$('#headermenu').css('color', '$color')");
}

function showSearchBox()
{
	if(!controller()->rbac->globalUrl('search', '')) return;
	$url = isset($_GET['r'])? $_GET['r']: '';

	$searchtitle = 'Search site';
	if(isset($_GET['q']))
		$searchvalue = XssFilter($_GET['q']);
	else
		$searchvalue = $searchtitle;

	echo "<div id='searchbox'>";

	echo "<input type='text' id='searchinput' class='sans-input' ".
		"onblur=\"this.value==''?this.value='$searchtitle':''\"
		onclick=\"this.value=='$searchtitle'?this.value='':''\"
		value='$searchvalue' />";

	echo "<a id='searchbutton'>Search</a>";
	echo "</div>";

	echo "<script>
	$('#searchinput').bind('keyup', function(e) {
		if(e.keyCode == '13') gotosearch($('#searchinput').val()); });
	$('#searchbutton').button({
		icons:{primary: 'ui-icon-search'}, text: false})
	.click(function(e) {gotosearch($('#searchinput').val());});
	function gotosearch(searchstring) {
		window.location.href = '/site/search&s='+encodeURI(searchstring);}
	</script>";
}

function showLoginBox()
{
	if(!user()->isGuest) return;
	if(!param('quicklogin')) return;
	if(controller()->id == 'site' && controller()->action->id == 'login') return;
	
	echo <<<END

<div class='tabmenuright'>
<form action="/" method="post">

<b>User Name:</b>
<input type="text" class="sans-input" size="12"
	name="LoginForm[username]" id="LoginForm_username" >

<b>Password:</b>
<input type="password" class="sans-input" size="12"
	name="LoginForm[password]" id="LoginForm_password" >
			
<label style='font-weight: normal' for="ytLoginForm_rememberMe">Remember me</label>
<input type="checkbox" name="LoginForm[rememberMe]" id="ytLoginForm_rememberMe" >
<input type=submit id='btnSubmit' name='yt0' style="height: 27px;" value="Login">

END;
	echo "</form></div>";
	
//	$color = param('linkcolor');
//	JavascriptReady("$('.tabmenuright').css('color', '$color')");
	
	JavascriptReady("$('#btnSubmit').button();");
	JavascriptReady("$('#LoginForm_username').focus();");
}





