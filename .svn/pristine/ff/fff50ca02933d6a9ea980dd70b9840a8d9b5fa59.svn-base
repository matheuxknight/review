<?php

function showListResult($id, $objects, $pages=null)
{
	if(!count($objects)) return;
	$format = user()->getState('layout');
	
	if($pages && $pages->pageCount > 1)
	{
		$currentPage = $pages->currentPage+1;
		echo "<font color=green>".count($objects)." / {$pages->itemCount} objects found. Page {$currentPage} of {$pages->pageCount}</font><br><br>";
		
		controller()->widget('CLinkPager', array('pages'=>$pages));
		echo "<br><br>";
	}
	
	switch($format)
	{
		case 'showdetail':
			showListFull($objects);
			break;
		
		case 'showmedium':
			showListDetails($id, $objects);
			break;
	
		case 'showsmall':
		default:
			showListIcons($objects);
			break;
	}
	
	if($pages && $pages->pageCount > 1)
	{
		echo "<br>";
		controller()->widget('CLinkPager', array('pages'=>$pages));
	
		echo <<<END
<script>
$(function()
{
	$('a', '.yiiPager').click(function()
	{
		var link = $(this).attr('href');
		var res = link.match(/page=\d+/);
		if(res)
		{
			res = res[0].match(/\d+/);
			currentpagenumber = res[0];
		}
		else
			currentpagenumber = 1;
		
		refreshContentPage();
		return false;
	});
});
</script>
END;
	}
}






