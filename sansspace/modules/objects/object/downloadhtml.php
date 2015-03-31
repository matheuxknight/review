<?php

echo <<<END
		
<script type='text/javascript'>
function goback()
{
	history.go(-1);
}
	
$(function()
{
	window.open('/object/objecthtml&id=$object->id', '_blank');
	setTimeout("goback()", 500);
});
</script>
	
END;
