<?php

function showJumbotron($title, $id, $url, $icon)
{
	$iconset = param('iconset');
	$icon = "/images/iconset/$iconset/$icon";
	
echo <<<end
<a href="$url">
	<div class="jumbotron" id="$id" style='text-align:center; line-height:179px;'>
		<img src="$icon" style="width:150px; vertical-align:center; margin-top:-38px" />
		<h2 style='text-align:left; font-size:28px'>$title</h2>
	</div>
</a>
end;
}

$user = getUser();
$server = getdbo('Server', 1);

if(param('mysansspacetiles'))
{

echo <<<end
<main id='mls-container' class="container">
	<div id='mls-user'>
		<h3 id='mls-user-name' class='error h2'>
			<a href='/my/settings' class='course-reg-link'>
end;
	echo $user->firstname;
	echo "<br>";
	echo $user->lastname;
	echo "</a>";
	echo "</h3>";
	echo "<a href='/my/settings' class='course-reg-link'>";
	echo userImage($user, 100);
	echo "</a>";
	echo "</div>";

	if(controller()->rbac->globalAdmin())
	{
		echo "
			<h4 align='right' class='error popup-text-header-upper'>
				<a href='/textbook/addstudentcode' class='course-reg-link' >
					<font class='course-reg-font'>Enroll in my course</font>
				</a>
				<a class='popup' title='Enroll in my course' href='javascript:void(0)' onclick='showVideo(this)' data='http://learningsite.waysidepublishing.com/file/embed?id=18089'>
					<em class='fa fa-question-circle popup-question'></em>
				</a>
			</h4>
			<h4 align='right' class='error popup-text-header-lower'>
				<a href='/textbook/addteachercourse' class='course-reg-link'>
					<font class='course-reg-font'>Create my course</font>
				</a>
				<a class='popup'   title='Create my course' href='javascript:void(0)' onclick='showVideo(this)' data='http://learningsite.waysidepublishing.com/file/embed?id=18088'>
					<em class='fa fa-question-circle popup-question'></em>
				</a>
			</h4>
		";
	}
	
	else
	{
		if(controller()->rbac->globalStudent())
			echo "
				<h4 align='right' class='error popup-text-header' >
					<a href='/textbook/addstudentcode' class='course-reg-link' >
						<font class='course-reg-font' >Enroll in my course</font>
					</a>
					<a class='popup' title='Enroll in my course' href='javascript:void(0)' onclick='showVideo(this)' data='http://learningsite.waysidepublishing.com/file/embed?id=18089' >
						<em class='fa fa-question-circle popup-question'></em>
					</a>
				</h4>";
		
		if(controller()->rbac->globalTeacher())
			echo "
				<h4 align='right' class='error popup-text-header'>
					<a href='/textbook/addteachercourse' class='course-reg-link' >
						<font class='course-reg-font'>Create my course</font>
					</a>	
					<a class='popup' title='Create my course' href='javascript:void(0)' onclick='showVideo(this)' data='http://learningsite.waysidepublishing.com/file/embed?id=18088'>
						<em class='fa fa-question-circle popup-question'></em>
					</a>
				</h4>";
	}
	
echo "<div class='row'>";
	echo "<div class='col-md-7'>";
	$iconset = param('iconset');
	$icon = "/images/iconset/$iconset/mycourses.png";
	
	echo <<<end
	<div class="jumbotron" id="my-courses"><div class="row">
		<a href='/my/courses' style='color:white;'>
			<div class="col-md-3" style="float:left">
					<img id='course-img' src="$icon" />
			</div>
		</a>
		<div id='course-list'>
			<ul>
end;
	$objects = objectList('mycourses');
	$coursecount = 1;
	foreach($objects as $n=>$object){
		$expired = false;
		if($object->usedate){
			$startArr = explode("-", $object->startdate);
			$endArr = explode("-", $object->enddate);
	
			$startInt = mktime(0, 0, 0, $startArr[1], $startArr[2], $startArr[0]);
			$endInt = mktime(23, 59, 59, $endArr[1], $endArr[2], $endArr[0]);
			if(time() > $endInt){
				$expired = true;}
		}
		if($coursecount <= 6 && !$expired){
			echo '<li>'.l($object->name, array('object/show', 'id'=>$object->id), array('style'=>'color: white')).'</li>';
		}
		if($coursecount == 7)
			echo "<a href='/my/courses' style='color:white'><li style='color:white'>(Click to View More Courses)</li></a>";
		$coursecount++;
	}
	echo <<<end
			</ul>
		</div>
	</div>
			<a href='/my/courses'>
				<h2 id='course-block'>Courses</h2>
			</a>
		</div>
	</div>
	<div class='col-md-5'>
end;
		showJumbotron("Grades", "my-reports", "/my/reports", "myreports.png");
	echo <<<end
	</div>
</div> <!-- .row -->
<div class='row'>
	<div class='col-md-4'>
		<a href="/my/folders">
			<div class="jumbotron" id="my-saved-work" >
				<img class='block-img' src="/images/iconset/wayside/myfolders1.png" />
				<h2 class='block-title'>My Files</h2>
			</div>
		</a>
	</div>
	<div class='col-md-4'>
		<a href="/pm">
			<div class="jumbotron" id="my-inbox" >
				<img class='block-img' src="/images/iconset/wayside/myinbox.png" />
				<h2 class='block-title'>Inbox</h2>
			</div>
		</a>
	</div>
	<div class='col-md-4'>
		<a href="/my/settings">
			<div class="jumbotron" id="settings">
				<img class='block-img' src="/images/iconset/wayside/mysettings.png" />
				<h2 class='block-title'>Settings</h2>
			</div>
		</a>
	</div>
</div> <!-- .row -->
</main>
end;
}

else
{
	echo "<h2>Welcome {$user->name}</h2>";
	echo "$server->mymessage";

	$commands = RbacCommandMyTable();
	
	echo "<div class='col1'>";
	foreach($commands as $n=>$id)
	{
		$command = getdbo('Command', $id);
		if(!controller()->rbac->globalAccess($command))
			continue;
	
	 	if($n == round(count($commands)/2))
	 		echo "</div><div class='col2'>";
	
		showMyItem($command);
	//	echo "<br>";
	}
	
	echo "</div>";
	echo "<div style='clear:both'></div>";
}

////////////////////////////////////////////////////////////////////

function showMyItem($command)
{
	$user = getUser();
	
	echo "<table cellspacing=0 cellpadding=0 width='100%' class='ssitem'
		style='padding: 6px; '><tr>";
	
	echo "<td width=10>";
	echo "</td>";
	
	echo "<td width=64 valign=top>";
	echo l($command->getImage(48), array($command->url));
	echo "</td>";
	
	if($command->id == SSPACE_COMMAND_MY_INBOX)
	{
		$count = getdbocount('PrivateMessage', "touserid=$user->id and not recv and not draft");
		//PrivateMessage::model()->count("touserid=$user->id and not recv and not draft");
		if($count) $command->name .= " ($count)";
	}
	
	echo "<td id='object_{$object->id}_parent' valign=top>";
	echo l($command->name, array($command->url));
	
	echo "<div class='small'>";
	$objects = null;
	
	switch($command->id)
	{
		case SSPACE_COMMAND_MY_COURSES:
			$objects = objectList('mycourses');
			break;

		case SSPACE_COMMAND_MY_RESOURCES:
			$objects = objectList('mylocations');
			break;

		case SSPACE_COMMAND_MY_FOLDERS:
			$objects = objectList('myfolders');
			break;

		case SSPACE_COMMAND_MY_REPORTS:
			$objects = objectList('mycourses');

			foreach($objects as $n=>$object)
			{
				if($n != 0) echo " &#9679; ";
				echo l(h($object->name), array('studentreport/', 'id'=>$object->id));
			}

			$objects = null;
			break;

		case SSPACE_COMMAND_MY_INBOX:
			echo l("Send a Message", array('pm/create'));

			break;

		case SSPACE_COMMAND_MY_FAVORITES:
			$objects = objectList('myfavorites');
			break;

		case SSPACE_COMMAND_MY_SETTINGS:
			break;
	}

	if($objects) foreach($objects as $n=>$object)
	{
		if($n != 0) echo " &#9679; ";
		echo l($object->name, array('object/show', 'id'=>$object->id));
	}
	echo "</div>";
	
	echo "</td></tr></table>";
}

if(IsMobileDevice())
	echo "<br><br><br><br><br><br><br><br>";

echo <<<end
<script type="text/javascript">

$(document).ready(function() 
{
	$('#popup').dialog({ autoOpen: false, modal: true, width: '620', dialogClass:'modalpopup' })
	$('.popup').click(function(){ $('div#popup').dialog('open'); });
	$('.confirmation').hide();
})

function showVideo(object){
	var x = object.title;
	var link = object.getAttribute('data');
	$('#ui-id-1').text(x);
	$('#viewer').attr('src',link);
}
		
</script>
		
<div id="popup" title="">
    <p class='error' style='font-size:18px; padding:0px' autofocus></p>
    <p style='font-size:14px; text-align:center'><iframe id='viewer' width=480 height=360 frameborder=0 seamless src=''></iframe></p>
</div>
end;

if(IsMobileEmbeded())
	SetAppHeaderColors();





