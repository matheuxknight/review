<?php

showNavigationBar($object->parent);
showObjectHeader($object);
showObjectMenu($object);

$backcolor = param('appmainback');

$container_top = '34px';
$ismobile = 0;

if(IsMobileEmbeded())
{
	$ismobile = 1;
	$container_top = '0px';

	$prot = '';
	$agent = $_SERVER['HTTP_USER_AGENT'];
	
	if(preg_match('/android/i', $agent))
		$prot = 'unknown:/';
}

echo '<br>';

$flashvars = "surveyid=$object->id";
ShowApplication($flashvars, 'survey', 'sansmediad', 480);

echo <<<END

<div id="htmlcontainer"></div>

<style>
#htmlcontainer
{
	position: absolute;
	top: 0px;
	left: 0px;
	right: 20px;
	height: auto;
	padding: 10px;
	display: block;
	z-index: 100;
	overflow-y: hidden;
	display: none;
	background-color: white;
}

</style>

<script>

function setSurveyFlashHeight(height)
{
	if($ismobile)
	{
		$('#htmlcontainer').height(height);
	}
	
	else
	{
		getFlashObject('sansmediad').height = height;
//		$(window).scrollTop(0);
	}
}

function loadHtmlContainer(url)
{
	if(!$ismobile)
	{
		var pos = $('#sansmediad').position();
		pos.top += 24;
			
		$('#htmlcontainer').offset(pos);
	}
	else
	{
		$('html').css('overflow', 'hidden');
	}

	$('#htmlcontainer').show();

	$.ajax({
		url: url,
		async: false
	}).success(htmlcontainer_ready);
}

function reportcontainer_height(hh, wh)
{
	if($ismobile)
	{
		var ret = new Object;
		
		ret['method'] = 'reportSurveyHtmlHeight';
		ret['hh'] = hh;
		ret['wh'] = wh;
		
		document.location = '$prot' + JSON.stringify(ret);
	}
	else
		getFlashObject("sansmediad").reportSurveyHtmlHeight(hh, wh);
}

function htmlcontainer_ready(data)
{
	$('#htmlcontainer').empty();
	$('#htmlcontainer').height('auto');
	$('#htmlcontainer').html(data);

	setTimeout(function()
	{
		var htmlcontainer_height = $('#htmlcontainer').height();
		reportcontainer_height(htmlcontainer_height, $(window).height());
	}, 100);
}

///////////////////////////////////////////////////////////////////////////////////////

function showSurveyHtml()
{
	$('#htmlcontainer').show();
}

function hideSurveyHtml()
{
	$('#htmlcontainer').hide();
}

// special case for text answer

function saveSurveyAnswerText(surveyid)
{
	var obj = $('#survey_answer_text');
	var value = $('#survey_answer_text').elrte('val');

	value = encodeURIComponent(value);
	
//	$.get('/survey/saveanswer?id='+surveyid+'&answertext='+value, '', saveSurveyAnswerText_ready);
	$.ajax({
		url: '/survey/saveanswer?id='+surveyid+'&answertext='+value,
		async: false
	}).success(saveSurveyAnswerText_ready);
}

function saveSurveyAnswerText_ready(data)
{
	if($ismobile)
	{
		var ret = new Object;
		ret['method'] = 'reportSurveyAnswerText';
		document.location = '$prot' + JSON.stringify(ret);
	}
	else
		getFlashObject("sansmediad").reportSurveyAnswerText();
}
		
//////////////////////////////////////////////////

function getFlashObject(movieName)
{
	var isIE = navigator.appName.indexOf('Microsoft') != -1;
	return (isIE) ? window[movieName] : document[movieName];
}

</script>

END;






