<?php

function emailUnenrolled7Days($user)
{
$title = param('title');
$servername = getFullServerName();

mailex('', SANSSPACE_SMTP_EMAIL, $user->email, 'Need help enrolling into your course?', 
						
	"<img src='http://reviewlearningsite.waysidepublishing.com/contents/17894.png' alt='logo'  class='alignnone size-full wp-image-533'><br><br>
	<div style='margin-left:3%; height:100%; font-size:16px; color:#555555; line-height:1.1em; font-family:Gotham, 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif''><p><div style='font-size:34px; color:#007ABB; font-weight:500; font-family:Gotham, 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif''>Hi $user->firstname,</p></div>
	<p>We noticed that you, '<b>$user->logon</b>', haven’t enrolled in a course.</p>
	<p>Can we help? To enroll in a course, just click the “Enroll in my course” link in the upper right hand corner of the screen after logging in. We’ve created a helpful video to walk you through the process:  <a href='http://www.waysidepublishing.com/learningsite'>WaysidePublishing.com</a></p>
	<p>If you experience any difficulties enrolling in a course, we’d be glad to help. Email us at support@waysidepublishing.com.</p>
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