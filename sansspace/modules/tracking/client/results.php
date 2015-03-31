<?php

$currentPage = $pages->currentPage+1;
echo "<font color=green>".count($clients)." / {$pages->itemCount} clients found. Page {$currentPage} of {$pages->pageCount}</font><br><br>";

$this->widget('CLinkPager', array('pages'=>$pages));
if($pages->pageCount > 1) echo "<br><br>";

showTableSorter('maintable', '{headers: {4: {sorter: false}}}');
echo "<thead class='ui-widget-header'><tr>";
echo "<th>Computer Name</th>";
echo "<th>IP Address</th>";
echo "<th>Last</th>";
echo "</tr></thead><tbody>";

foreach($clients as $model)
{
	echo "<tr class='ssrow'>";
	echo "<td style='font-weight: bold;'>".
		l("{$model->remotename}", array('update', 'id'=>$model->id))."</td>";
	echo "<td>{$model->remoteip}</td>";
	echo "<td nowrap>".datetoa($model->session->starttime)."</td>";
	echo "</tr>";
}

echo "</tbody></table>";

echo "<br>";
$this->widget('CLinkPager', array('pages'=>$pages));

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
		
		refreshClientPage();
		return false;
	});
});
</script>
END;




