<?php
require_once('training.js');
$user = getUser();
$ch = curl_init("https://waysidepublishing.atlassian.net/wiki/display/LSD/Learning+Site+FAQ+-+Customer+View");
$fp = fopen("../temp/training.txt", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_exec($ch);
curl_close($ch);
fclose($fp);

$fp = fopen("../temp/training.txt", "r");
while(!feof($fp)){
    $line = fgets($fp);
    if(strpos($line,'<div id="faqcontent">') !== false){$faq = $line;}
}
fclose($fp);

echo "
<style>
.ui-widget-header{min-width:1060px;}
footer{min-width:1060px;}
</style>
<main class='container' style='width:970px'>
	<h1 id='trainingheader'>Need Help?</h1>
	<p id='t-header-text'>This is the place to find all things Learning Site 
	and the place to start out if you're just starting out.</br>Below you will find videos, questions and answers, and a way to send us comments, questions, and/or concerns if all else fails. We are here to help!</p><br>
	<div id='trainingdescription'>
		<p id='p-hide'><u>Click below to choose your section</u></p><br>
	</div>	
	<div id='trainingselectordiv'>
		<div id='videoselector' class='trainingselector' section='training' onclick='setSection(this.id)'>Videos</div>
		<div id='faqselector' class='trainingselector' section='faq' onclick='setCategories(), setSection(this.id)'>Frequently Asked Questions</div>
		<div id='contactselector' class='trainingselector' section='contact' onclick='setSection(this.id)'>Contact Us</div>
	</div>
	<hr>
	<div id='training' class='error trainingholder'>
		<div id='trainingtabholder'>
			<div id='getting-started' class='trainingtab trainingtabfocus' title='startedlist' description='The Signing Up for an Account video offers an in-depth look on how to create a Learning Site account as both a student and then as a teacher. The video covers this process by using the Account Registration form.'  onclick='setTrainingTab(this)' data='/file/embed?id=18087'>Getting Started</div>
			<div id='course-navigating' class='trainingtab trainingtabblur' title='navigatelist' description='The Learning Site Basics Webinar conducted on January 7, 2015, offers instructions on how to navigate the My Learning Site tab and all items associated with it such as the Courses, Grades, My Files, Inbox, and Settings tiles.'  onclick='setTrainingTab(this)' data='/file/embed?id=50634'>Navigating Your Course</div>
			<div id='program-webinars' class='trainingtab trainingtabblur' title='programlist' description='The Tr&aacute;ngulo Aprobado webinar conducted on September 29, 2014, offers an in-depth look at the Tri&aacute;ngulo Aprobado Student Edition, Teacher Edition, Learning Site materials and navigation, and the integration of all three components of the program.' onclick='setTrainingTab(this)' data='/file/embed?id=47716'>Full Program Webinars</div>
		</div>
		<div id='trainingcontent'>
			<div id='trainingcontentinner'>
				<div id='topiclistdiv'>
					<ul id='startedlist' class='topiclist'>
					
						<li id='generallink1' class='listItem topiclistactive' description='The Signing Up for an Account video offers an in-depth look on how to create a Learning Site account as both a student and then as a teacher. The video covers this process by using the Account Registration form.' data='/file/embed?id=18087' onclick='setListItem(this)' name='first'>
						Signing Up for an Account</li>

						<li id='generallink2' class='listItem topiclistblur' description='' data='/file/embed?id=65442' onclick='setListItem(this)'>
						Signing Up for an Account - Teacher</li>
						
						<li id='generallink3' class='listItem topiclistblur' description='The Creating My Course video offers an in-depth look at how a teacher is able to create their own course on the Learning Site.' data='/file/embed?id=18088' onclick='setListItem(this)'>
						Creating My Course</li>
						
						<li id='generallink4' class='listItem topiclistblur' description='The Enrolling in My Course video offers an in-depth look on how students are able to enroll within their teacher's course once it has been created by their instructor, first.' data='/file/embed?id=18089' onclick='setListItem(this)'>
						Enrolling in My Course</li>
						
						<li id='generallink5' class='listItem topiclistblur' description='The Navigating the Learning Site video takes a look at the main My Learning Site page upon login and how to navigate and utilize the various options from within.' data='/file/embed?id=42905' onclick='setListItem(this)'>
						Navigating the Learning Site</li>
					</ul>
					<ul id='navigatelist' class='topiclist hiddenlist'>
					
						<li id='navigatelink1' class='listItem topiclistactive' description='The Learning Site Basics Webinar conducted on January 7, 2015, offers instructions on how to navigate the My Learning Site tab and all items associated with it such as the Courses, Grades, My Files, Inbox, and Settings tiles.' data='/file/embed?id=50634' onclick='setListItem(this)' name='first' >Learning Site Basics</li>
						
						<li id='navigatelink2' class='listItem topiclistblur' description='The Assessing Student Performance and Grades webinar conducted on January 14, 2015, offers an in-depth look at how to assess survey and discussion forum participation, as well as how to grade all quiz types.' data='/file/embed?id=50633' onclick='setListItem(this)'>Student Performance and Grades</li>
						
						<!--<li id='navigatelink3' class='listItem topiclistblur' description='The Classroom Forum webinar provides insight as to what is and who your class might be able to use the Classroom Forum. This area can be used for group discussions, providing external context, assigning work, etc.' data='/file/embed?id=43368' onclick='setListItem(this)'>
						Classroom Forum</li>-->
						
						<li id='navigatelink4' class='listItem topiclistblur' description='The Learning Site Activities webinar conducted on January 28, 2015 offers an in-depth look at how students and teachers can navigate through all quiz types, flashcards, surveys, discussion forums, and PDF forms.' data='/file/embed?id=52473' onclick='setListItem(this)'>Learning Site Activities</li>
						
						<li id='navigatelink5' class='listItem topiclistblur' description='The Using the Comparative Recorder webinar conducted on January 21, 2015, offers a detailed look at the technological requirements for the comparative recorder, how a student records and reviews teacher feedback, and how a teacher can provide precision feedback to any student recorded audio.' data='/file/embed?id=51922' onclick='setListItem(this)'>Using the Comparative Recorder</li>
	
					</ul>
					<ul id='programlist' class='topiclist hiddenlist'>
					
						<li id='triangulolink1' class='listItem topiclistactive' description='The Tr&aacute;ngulo Aprobado webinar conducted on September 29, 2014, offers an in-depth look at the Tri&aacute;ngulo Aprobado Student Edition, Teacher Edition, Learning Site materials and navigation, and the integration of all three components of the program.' data='/file/embed?id=47716' onclick='setListItem(this)' name='first'>
						Tri&aacute;ngulo Webinar</li>
						
						<li id='tejidoslink1' class='listItem topiclistblur' description='The Tejidos webinar conducted on September 29, 2014, offers an in-depth look at the Tejidos Student Edition, Teacher Edition, Learning Site materials and navigation, and the integration of all three components of the program.' data='/file/embed?id=47727' onclick='setListItem(this)'>
						Tejidos Webinar</li>
						
						<li id='azulejolink1' class='listItem topiclistblur' description='The Azulejo webinar conducted on September 29, 2014, offers an in-depth look at the Azulejo Student Edition, Teacher Edition, Learning Site materials and navigation, and the integration of all three components of the program.' data='/file/embed?id=47750' onclick='setListItem(this)'>
						Azulejo Webinar</li>
						
						<li id='neuelink1' class='listItem topiclistblur' description='The Neue Blickwinkel webinar conducted on September 29, 2014, offers an in-depth look at the Neue Blickwinkel Student Edition, Teacher Edition, Learning Site materials and navigation, and the integration of all three components of the program.' data='/file/embed?id=47755' onclick='setListItem(this)'>
						Neue Blickwinkel Webinar</li>
						
						<li id='apprenonslink1' class='listItem topiclistblur' description='The APprenons webinar conducted on September 29, 2014, offers an in-depth look at the APprenons Student Edition, Teacher Edition, Learning Site materials and navigation, and the integration of all three components of the program.' data='/file/embed?id=47754' onclick='setListItem(this)'>
						APprenons Webinar</li>
						
						<li id='chiarissimolink1' class='listItem topiclistblur' description='The Tejidos webinar conducted on September 29, 2014, offers an in-depth look at the Tejidos Student Edition, Teacher Edition, Learning Site materials and navigation, and the integration of all three components of the program.' data='/file/embed?id=47763' onclick='setListItem(this)'>
						Chiarissimo Webinar</li>
						
					</ul>
				</div>
				<div id='trainingvideo'>
					<iframe id='webinariframe' width=480 height=360 frameborder=0 seamless src='/file/embed?id=18087'></iframe>
				</div>
				<div id='videotext'>The Signing Up for an Account video offers an in-depth look on how to create a Learning Site account as both a student and then as a teacher. The video covers this process by using the Account Registration form.
				</div>
			</div>	
		</div>
	</div>
	<div id='faq' class='trainingholder'>
		<div id='faqcategories'>
			<div id='faq-categories-show' onmouseover='hoverWidth(this)'>
			</div>
			<div id='faq-categories-hide'>FAQ Topics</div>
		</div>
		<div id='faq-choices'>
			<div id='faq-choices-show'>
				<div id='choice-title'></div>
				<div id='faq-choices-list' onmouseover='hoverWidth(this)'></div>
			</div>	
			<div id='faq-choices-hide'>Questions</div>
		</div>
		<div id='faq-result'>
			<div id='questionHolder'>
				<h1 id='bigq' class='bigLetters'>Q:</h1>
				<div id='faq-result-question' class='resultHolder'></div>
			</div>
			<div id='answerHolder'>
				<h1 id='biga' class='bigLetters'>A:</h1>
				<div id='faq-result-answer' class='resultHolder'></div>
			</div>
		</div>
	$faq</div>
	<div id='contact' class='trainingholder'>
		<div id='contactcontent'>
		</div>
	</div>
</main>";