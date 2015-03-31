<?php

echo <<<END
<script>
		
$(function()
{
	var w = window.open("/connect/show?id=$course->id", "sans_course_chat", 
		"width=1024,height=600,location=no,menubar=no,resizable=yes,status=yes,toolbar=no");

	if(w) setTimeout(function(){ window.history.go(-1);}, 1000);
});

</script>
END;









