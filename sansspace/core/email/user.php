<?php

function emailUserCreated($user)
{
	mailex('', SANSSPACE_SMTP_EMAIL, $user->email,
	'Learning Site Account Creation',
	
	"<img src='http://reviewlearningsite.waysidepublishing.com/images/wayside/logo2.png' alt='logo'  class='alignnone size-full wp-image-533'><br><br>
	<div style='margin-left:3%; height:100%; font-size:16px; color:#555555; line-height:1.1em; font-family:Gotham, 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif''><p><div style='font-size:34px; color:#007ABB; font-weight:500; height:40px line-height:1.1em; font-family:Gotham, 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif''>Hello $user->name!</div><br><br>We received your request to change your password for your Learning Site account and promptly sent this message.<br>
	To change your password just click on the link below:<br><br>
	<a href='dummy link'>Click to reset password</a><br>
	After you have clicked the link above, simply choose a new password and save.<br><br>
	If you have opted to reset your password in error, or you had not done so at all, please disregard this message.<br>
	Have any questions or concerns? Don't hesitate to contact us at <a href='mailto:support@waysidepublishing.com'>support@waysidepublishing.com.</a>
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
	<p class=MsoAutoSig style='line-height:115%'><span style='mso-fareast-font-family:
	Calibri'><a href='WaysidePublishing.com'><span style='font-size:10.0pt;
	mso-bidi-font-size:12.0pt;line-height:115%;font-family:'Helvetica','sans-serif''>WaysidePublishing.com</span></a></span><span
	style='font-size:10.0pt;mso-bidi-font-size:12.0pt;line-height:115%;
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
	mso-bidi-font-family:Helvetica;color:#6CB33F'>A World of Learning Opportunities</span></i></b><span
	style='mso-fareast-font-family:'Times New Roman''>
	<o:p></o:p>
	</span></p>
	</td>
	</tr>
	</table>
	</div>
	</div>
	</div>");
	
}


