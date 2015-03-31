<?php

function downloadYoutube($url, $filename)
{
	debuglog("downloadYoutube($url, $filename)");

	preg_match('/v=([a-zA-Z0-9_\-]*)/', $url, $match);
	if(empty($match)) return;
	
	$youtubeid = substr($match[1], 0, 32);
	debuglog("youtubeid $youtubeid");
	
	set_time_limit (0);
	
// 	$buffer = fetch_url($url);
// 	if(!$buffer) return false;
	
// 	// 2. extract file path from "video_id": " and from "t": "
// 	if( !preg_match('/"video_id": "(.*?)"/', $buffer, $match) ||
// 		!preg_match('/"t": "(.*?)"/', $buffer, $match1))
// 		return false;
		
// 	$video_id = $match[1];
// 	$t = $match1[1];
	
//	$download = "https://www.youtube.com/get_video?video_id=$video_id&fmt=$yformat&t=$t&asv=";
//	debuglog("download link $download");

	parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=".$youtubeid),$info);
	
	$streams = $info['url_encoded_fmt_stream_map'];
	if(!$streams)
	{
		debuglog($info, 5);		// look for $info['reason']
		return;
	}

	$streams = explode(',',$streams);
	
	foreach($streams as $stream)
	{
		parse_str($stream, $data);
		debuglog($data);
		
		if($data['type'] == 'video/x-flv')
		{
			$video = fopen($data['url'].'&signature='.$data['sig'],'r');
			$file = fopen($filename,'w');
			
			stream_copy_to_stream($video, $file);
			
			fclose($video);
			fclose($file);
		}
		
		// look for quality, type, url
	}
	
	exit;
	
	// 3. download the file to xxxxxx.mp4
	$data = file_get_contents_curl($download);
	file_put_contents($filename, $data);
	
// 	$infile = @fopen($download, "r");
// 	if(!$infile)
// 	{
// 		debuglog("failed to open $download");
// 		return false;
// 	}
	
// 	$outfile = @fopen($filename, "w");
// 	if(!$outfile)
// 	{
// 		debuglog("failed to open $outfile");
// 		return false;
// 	}

// 	while(!feof($infile))
// 	{
// 		$line = fread($infile, 32*1024);
// 		fwrite($outfile, $line);
// 	}

// 	fclose($infile);
// 	fclose($outfile);
	
	//echo $buffer; die;
	
	//preg_match('/<title>YouTube - (.*?)<\/title>/', $buffer, $match2);
// 	preg_match('/title="(.*?)" \/>/', $buffer, $match2);
	
// 	if(isset($match2[1]))
// 		return htmlspecialchars_decode($match2[1], ENT_QUOTES);
// 	else
// 		return $url; 
}






