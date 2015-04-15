<?php

function emailSingleCourse14Days($course)
{
$title = param('title');
$servername = getFullServerName();
$teacher = $course->getTeacherName(false);
$teacheremail = $course->getTeacherName2(false);

mailex('', SANSSPACE_SMTP_EMAIL, $teacheremail, 'Your Learning Site access may end soon', 
						
	"<img src='http://reviewlearningsite.waysidepublishing.com/contents/17894.png' alt='logo'  class='alignnone size-full wp-image-533'><br><br>
	<div style='margin-left:3%; height:100%; font-size:16px; color:#555555; line-height:1.1em; font-family:Gotham, 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif''><p><div style='font-size:34px; color:#007ABB; font-weight:500; font-family:Gotham, 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif''>Hi $teacher,</p></div>
	<p>You created the Learning Site course – <b>$course->name</b> 14 days ago, yet your students have not yet enrolled. Teacher access to the Learning Site is contingent upon student enrollment.</p>
	<p>We’d love to help you get your students enrolled in your Learning Site course. From your “My Learning Site” page, click on the Training tab to find a video about how your students enroll in your Learning Site course. The video is also available at: <a href='http://www.waysidepublishing.com/learningsite'>WaysidePublishing.com</a></p>
	<p>If in 2 weeks you still do not have students enrolled in your course, your course will be automatically removed from the Learning Site during routine maintenance. If you believe you are receiving this message in error, please contact us at your earliest convenience to avoid any potential disruption in your Learning Site access.</p>
	<p>If you are having difficulty enrolling your students, we’d be glad to help. Email us at support@waysidepublishing.com, or give us a call in the office at (888)302-2519.</p>
	<p>Sincerely,<br>
	Wayside Publishing Support</p>
	<div style='height:70px'>
	<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0
	style='border-collapse:collapse;mso-table-layout-alt:fixed;border:none;
	mso-yfti-tbllook:1184;mso-padding-alt:0in 5.4pt 0in 5.4pt;mso-border-insideh:
	none;mso-border-insidev:none'>
	<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes;
	height:10px'>
	<td width=31 style='width:23.4pt;border-top:dotted windowtext 1.0pt;
	border-left:none;border-bottom:none;border-right:dotted windowtext 1.0pt;
	mso-border-top-alt:dotted windowtext .5pt;mso-border-right-alt:dotted windowtext .5pt;
	padding:0in 5.4pt 0in 5.4pt;height:15px'>
	<p class=MsoNormal><span style='mso-fareast-font-family:Calibri'><a
	href='https://www.facebook.com/WaysidePublishing'><span style='mso-fareast-font-family:
	'Times New Roman';color:windowtext;mso-no-proof:yes;text-decoration:none;
	text-underline:none'><img border=0 width=17 height=16 id='_x0000_i1025'
	src='http://www.waysidepublishing.com/wp-content/uploads/2014/05/FacebookLogo1.png'
	alt='http://www.waysidepublishing.com/wp-content/uploads/2014/05/FacebookLogo1.png'></span></a></span><span
	style='mso-fareast-font-family:'Times New Roman''><o:p></o:p></span><span style='mso-fareast-font-family:Calibri'><a
	href='https://twitter.com/WaysidePublish'><span style='mso-fareast-font-family:
	'Times New Roman';color:windowtext;mso-no-proof:yes;text-decoration:none;
	text-underline:none'><img border=0 width=17 height=16 id='_x0000_i1026'
	src='http://www.waysidepublishing.com/wp-content/uploads/2014/05/TwitterLogo1.png'
	alt='http://www.waysidepublishing.com/wp-content/uploads/2014/05/TwitterLogo1.png'></span></a></span><span
	style='mso-fareast-font-family:'Times New Roman''>
	<o:p></o:p>
	</span></p>
	</td>
	<td width=48 style='width:.5in;border:none;border-top:dotted windowtext 1.0pt;
	mso-border-left-alt:dotted windowtext .5pt;mso-border-top-alt:dotted windowtext .5pt;
	mso-border-left-alt:dotted windowtext .5pt;padding:0in 5.4pt 0in 5.4pt;
	height:15px'>
	<p class=MsoNormal align=center style='text-align:center'><span
	style='mso-fareast-font-family:'Times New Roman';mso-no-proof:yes'><img
	border=0 width=34 height=43 id='_x0000_i1027'
	src='http://www.waysidepublishing.com/wp-content/uploads/2014/05/WaysideLogoSignature1.png'
	alt='http://www.waysidepublishing.com/wp-content/uploads/2014/05/WaysideLogoSignature1.png'></span><span
	style='mso-fareast-font-family:'Times New Roman''><o:p></o:p></span></p>
	</td>
	<td width=451 style='width:338.1pt;border:none;border-top:dotted windowtext 1.0pt;
	mso-border-top-alt:dotted windowtext .5pt;padding:0in 5.4pt 0in 5.4pt;
	height:15px'>
	<p class=MsoAutoSig style='line-height:100%'><span style='mso-fareast-font-family:
	Calibri'><a href='WaysidePublishing.com'><span style='font-size:10.0pt;
	mso-bidi-font-size:12.0pt;line-height:100%;font-family:'Helvetica','sans-serif''>WaysidePublishing.com</span></a></span><span
	style='font-size:10.0pt;mso-bidi-font-size:12.0pt;line-height:100%;
	font-family:'Helvetica','sans-serif';mso-fareast-font-family:'Times New Roman''><o:p></o:p>
	<br>
	</span><span style='font-size:8.0pt;mso-bidi-font-size:9.0pt;
	font-family:'Helvetica','sans-serif';mso-fareast-font-family:Calibri;
	color:#888888'>T/F (888) 302-2519</span><span style='font-size:8.0pt;
	mso-bidi-font-size:9.0pt;font-family:'Helvetica','sans-serif';mso-fareast-font-family:
	'Times New Roman';color:#888888'>
	<o:p></o:p>
	<br>
	</span><b style='mso-bidi-font-weight:normal'><i
	style='mso-bidi-font-style:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
	10.0pt;font-family:'Georgia','serif';mso-fareast-font-family:Calibri;
	mso-bidi-font-family:Helvetica;'><font style-'color:rgb(108,179,63)'>A World of Learning Opportunities</font></span></i></b><span
	style='mso-fareast-font-family:'Times New Roman''>
	<o:p></o:p>
	</span></p>
	</td>
	</tr>
	</table></div></div>");}