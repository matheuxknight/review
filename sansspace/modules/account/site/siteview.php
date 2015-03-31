<?php

function showHomeItem($page)
{
	echo "<div class=ssbox>";
	echo "<div class=header>";
	echo l($page->name, array('object/show', 'id'=>$page->id));
	echo "<p class=subheader>Last updated ".datetoa($page->updated)."</p>";
	echo "</div>";

	echo "<div class='smallcontent'>";
	echo getHomeTeaser($page);

	echo "</div><!-- sscontent -->";
	echo "</div><!-- ssbox -->";
}

function getHomeTeaser($page)
{
	if(empty($page->ext->doctext)) return "";
	
	$pos = strpos($page->ext->doctext, '<!-- pagebreak -->');
	if($pos)
	{
		$text = substr($page->ext->doctext, 0, $pos);
		return $text.CHtml::link(" [more...]", array('object/show', 'id'=>$page->id));
	}
	
	if(strlen($page->ext->doctext) < 500)
		return $page->ext->doctext;
	
	$pos = strpos($page->ext->doctext, '</p>');
	while($pos != 0 && $pos < 400)
		$pos = strpos($page->ext->doctext, '</p>', $pos + 4);
	
	if(!$pos)
	{
		$text = strip_tags($page->ext->doctext);
		$text = substr($text, 0, 400);
		return $text.CHtml::link(" [more...]", array('object/show', 'id'=>$page->id));
	}
	
	$text = substr($page->ext->doctext, 0, $pos + 4);	// keep trailing </p>
	return $text.CHtml::link(" [more...]", array('object/show', 'id'=>$page->id));
}



