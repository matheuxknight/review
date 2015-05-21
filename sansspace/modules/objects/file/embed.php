<?php

include '/sansspace/ui/lib/pageheader.php';
echo "
<style>
html
{
	height: 100%;
	overflow: hidden;
}

video
{
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
}
</style></head><body>
<video controls>
  <source src='/contents/";echo $_REQUEST['id'];echo".mp4' type='video/mp4'>
Your browser does not support the video tag.
</video>	
</body>";




