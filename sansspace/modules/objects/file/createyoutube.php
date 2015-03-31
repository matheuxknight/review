<?php

$parent = getdbo('Object', getparam('id'));

showNavigationBar($parent->parent);
showObjectHeader($parent);
showObjectMenu($parent);

echo "<h2>Download Youtube Video</h2>";

if(isset($_POST['youtube_url']) && !empty($_POST['youtube_url']))
{
	$url = $_POST['youtube_url'];
	set_time_limit(0);
	
	preg_match('/v=([a-zA-Z0-9_\-]*)/', $url, $match);
	if(empty($match))
	{
		user()->setFlash('error', 'This is not a valid youtube url');
		controller()->goback();
		
		return;
	}
	
	$youtubeid = substr($match[1], 0, 32);
	parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=".$youtubeid), $info);
//	debuglog($info);
	
	$streams = $info['url_encoded_fmt_stream_map'];
	if(!$streams)
	{
		user()->setFlash('error', "Error {$info['errorcode']} - ".stripslashes($info['reason']));
		controller()->goback();
		
		return;
	}
	
	echo "Choose a format from the list below and click the download link. This may take several minutes depending on the video length.<br><br>";
	echo "<b>".stripslashes($info['title'])."</b><br><br>";
	
	$fmts = explode(',', $info['fmt_list']);
	$format = array();

	foreach($fmts as $fmt)
	{
		$tmp = explode('/', $fmt);
		$format[$tmp[0]] = $tmp[1];
	}
	
	echo "<div id='download_table'><table width='100%' class='dataGrid'>";
	echo "<tr>";
	echo "<th>Quality</th>";
	echo "<th>Dimension</th>";
	echo "<th>Type</th>";
	echo "<th></th>";
	echo "</tr>";
	
	$streams = explode(',', $streams);
	foreach($streams as $stream)
	{
		parse_str($stream, $data);
	//	debuglog($data);
	
		echo "<tr class='ssrow'>";
		echo "<td>{$data['quality']}</td>";
		echo "<td>{$format[$data['itag']]}</td>";
		echo "<td>".stripslashes($data['type'])."</td>";
		echo "<td><a href='javascript:download_file({$data['itag']})'>[Download]</a></td>";
		echo "</tr>";
	}
	
	echo "</table></div><br>";
	
	echo <<<END
<script>

function download_file(itag)
{
	$('#download_table').html('<br><br>Importing file, please wait...');
	window.location = "/file/downloadyoutube?id=$parent->id&youtubeid=$youtubeid&itag="+itag;
}

</script>

END;
}

else
{
	$this->widget('UniForm');
	
	echo CUFHtml::beginForm();
	echo CUFHtml::errorSummary($object);
	echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));
	
	echo CUFHtml::openActiveCtrlHolder($object, 'youtube_url');
	echo CUFHtml::activeLabelEx($object, 'URL');
	echo CUFHtml::textField('youtube_url', '', array('maxlength'=>200, 'class'=>'textInput'));
	echo "<p class='formHint2'>Paste the URL of the youtube video.</p>";
	echo CUFHtml::closeCtrlHolder();

	echo CUFHtml::closeTag('fieldset');
	showSubmitButton('Create');
	echo CUFHtml::endForm();
}

