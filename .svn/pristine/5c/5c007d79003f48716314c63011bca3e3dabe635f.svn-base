<?php

echo "<h2>Register a Learning Site account</h2>";
//echo "<p>Fields with <span class='required'>*</span> are required.</p>";

$this->widget('UniForm');

echo CUFHtml::beginForm();
echo CUFHtml::errorSummary($form);
echo CUFHtml::openTag('fieldset', array('class'=>'inlineLabels'));

echo CUFHtml::openActiveCtrlHolder($form, 'firstname');
echo CUFHtml::activeLabelEx($form, 'firstname');
echo CUFHtml::activeTextField($form, 'firstname', array('maxlength'=>15));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($form, 'lastname');
echo CUFHtml::activeLabelEx($form, 'lastname');
echo CUFHtml::activeTextField($form, 'lastname', array('maxlength'=>30));
echo "<p class='formHint2'></p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($form->user, 'logon');
echo CUFHtml::activeLabelEx($form->user, 'logon');
echo CUFHtml::activeTextField($form->user, 'logon', array('maxlength'=>25));
echo "<p class='formHint2'>Select the username you will use to log in to the Learning Site. Your username cannot contain spaces.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($form->user, 'password');
echo CUFHtml::activeLabelEx($form->user, 'password');
echo CUFHtml::activePasswordField($form->user, 'password', array('maxlength'=>45));
echo "<p class='formHint2'>Minimum 8 characters and maximum 20.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($form, 'confirm_password');
echo CUFHtml::activeLabelEx($form, 'confirm_password');
echo CUFHtml::activePasswordField($form, 'confirm_password', array('maxlength'=>45));
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($form->user, 'email');
echo CUFHtml::activeLabelEx($form->user, 'email');
echo CUFHtml::activeTextField($form->user, 'email', array('maxlength'=>45));
echo "<p class='formHint2'>If you have already created an account, your email address will cause an error message. Use the <a href='/site/forgot'>Forgot your password</a> link on the log in page.</p>";
echo CUFHtml::closeCtrlHolder();

echo CUFHtml::openActiveCtrlHolder($form->user, 'organisation');
echo CUFHtml::activeLabelEx($form->user, 'organisation');
echo CUFHtml::activeTextField($form->user, 'organisation', array('maxlength'=>45));
echo CUFHtml::closeCtrlHolder();

if(param('theme') == 'wayside')
{
	echo CUFHtml::openActiveCtrlHolder($form, 'register_role');
	echo CUFHtml::activeLabelEx($form, 'register_role').'<br>';
	echo CUFHtml::activeRadioButtonList($form, 'register_role', array('student'=>'I am a student', 'teacher'=>'I am a teacher'));
	echo CUFHtml::closeCtrlHolder();
	
	if($form->register_role == 'teacher')
		echo "<span id='teacher_fields'>";
	else
		echo "<span id='teacher_fields' style='display: none;'>";

	echo CUFHtml::openActiveCtrlHolder($form->user, 'phone1');
	echo CUFHtml::activeLabelEx($form->user, 'phone1');
	echo CUFHtml::activeTextField($form->user, 'phone1');
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($form->user, 'city');
	echo CUFHtml::activeLabelEx($form->user, 'city');
	echo CUFHtml::activeTextField($form->user, 'city');
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($form->user, 'state');
	echo CUFHtml::activeLabelEx($form->user, 'state');
	echo CUFHtml::activeTextField($form->user, 'state');
	echo CUFHtml::closeCtrlHolder();
	
	echo CUFHtml::openActiveCtrlHolder($form->user, 'postal');
	echo CUFHtml::activeLabelEx($form->user, 'postal');
	echo CUFHtml::activeTextField($form->user, 'postal');
	echo CUFHtml::closeCtrlHolder();
	
	$country_array = array("United States", "Afghanistan", "Aland Islands", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Barbuda", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Trty.", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Caicos Islands", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern Territories", "Futuna Islands", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard", "Herzegovina", "Holy See", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Jan Mayen Islands", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea", "Korea (Democratic)", "Kuwait", "Kyrgyzstan", "Lao", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "McDonald Islands", "Mexico", "Micronesia", "Miquelon", "Moldova", "Monaco", "Mongolia", "Montenegro", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "Nevis", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Palestinian Territory, Occupied", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Principe", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Barthelemy", "Saint Helena", "Saint Kitts", "Saint Lucia", "Saint Martin (French part)", "Saint Pierre", "Saint Vincent", "Samoa", "San Marino", "Sao Tome", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia", "South Sandwich Islands", "Spain", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "The Grenadines", "Timor-Leste", "Tobago", "Togo", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Turks Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "US Minor Outlying Islands", "Uzbekistan", "Vanuatu", "Vatican City State", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (US)", "Wallis", "Western Sahara", "Yemen", "Zambia", "Zimbabwe");
	
	echo CUFHtml::openActiveCtrlHolder($form->user, 'country');
	echo CUFHtml::activeLabelEx($form->user, 'country');
	echo CUFHtml::activeDropDownList($form->user, 'country', $country_array);
	echo CUFHtml::closeCtrlHolder();
	
	echo "</span>";
}

if(extension_loaded('gd'))
{
	echo CUFHtml::openActiveCtrlHolder($form, 'verifyCode');
	echo CUFHtml::activeLabelEx($form, 'verifyCode', array('label'=>'Enter blue letters on right:'));
	echo CUFHtml::activeTextField($form, 'verifyCode');
	echo "<p class='formHint2'>Enter the letters as they are shown in the image below.
		Letters are not case-sensitive.</p>";
	echo CUFHtml::closeCtrlHolder();

	echo "<div style='float: right; width:35%;'>";
	$this->widget('CCaptcha');
	echo "</div><br><br><br>";
}

echo CUFHtml::closeTag('fieldset');
echo "<div id='terms_agreement_container'>By checking this box, I agree to Wayside Publishing's <a href='javascript:void(0)' id='popuplink'>Terms of Service.</a><input type='checkbox' id='terms_agreement' required/> <em>*</em></div>";
showSubmitButton('Register');
echo CUFHtml::endForm();

echo "<br><br><br><br><br><br><br><br><br><br>";
echo "<footer>";
echo "<div class='container'>";
echo "<div class='row' style='max-width:910px'>";
echo "<div class='col-md-8' style='margin-top:10px;float:left;width:auto'>";
echo "<p class='footer-contact'>";
echo "<em class='fa fa-question-circle'></em> Need help? <a id='contactlink' class='contactlink' href='mailto:support@waysidepublishing.com'>Contact us.</a></p>";
echo "<p7>Copyright &#169; 2010-2014 <a href='http://www.waysidepublishing.com' style='text-decoration:none'  target='_blank'>Wayside Publishing.</a> All Rights Reserved.<br>Audios, videos, and visual materials are copyright protected and may not be downloaded without permission from <a href='http://www.waysidepublishing.com' style='text-decoration:none'  target='_blank'>Wayside Publishing.</a><br>";
echo "<br></p7></div><div style='max-width:40px'></div>";
echo "<div class='col-md-3 powered-by' style='width:201px;padding-left:0px'>";
echo "<p style='margin-top:-4px'>";
echo "Powered by</p>";
echo "<img style='padding-top:10px' src='/contents/16826.png' alt='Sansspace logo'>";
echo "<img style='margin-left:0px;margin-top:-2px' src='/contents/17884.png'>";
echo "</div>";
echo "</div> <!-- .row -->";
echo "</div> <!-- .container -->";
echo "</footer>"; 

echo <<<end
<script>
$(function()
{
	$('input:radio').change(
	    function()
	    {
			if(this.value == 'student'){
				$('#teacher_fields').hide();
			}		
			else{
				$('#teacher_fields').show();
			}
		}
	);
});	
$(function(){
  $("#RegisterForm_register_role_0").click(function(){
	var s = "_";
	$("#User_city").val(s);
	$("#User_state").val(s);
	$("#User_postal").val(s);
 });
});
$(function(){
  $("#RegisterForm_register_role_1").click(function(){
	var s = "";
	$("#User_city").val(s);
	$("#User_state").val(s);
	$("#User_postal").val(s);
 });
});
$(document).ready(function(){
  $(".sans-input").change(function(){
	if( $(this).val().length != 0 )
    $(this).css("background-color","#D6D6FF");
	else
	$(this).css("background-color","#f5f5f5");
  });
});

	$(document).ready(function() 
{
	$('#popup').dialog({ autoOpen: false, modal: true, width: '620', dialogClass:'modalpopup' })
	$('#popuplink').click(function(){ $('div#popup').dialog('open'); });
})
</script>
<div id="popup" title="Wayside Publishing Learning Site Terms of Service">
    <div id='terms_container'>
	<div id='terms_age' autofocus>IF YOU ARE UNDER 18 YEARS OF AGE, PLEASE BE SURE TO READ THIS AGREEMENT WITH YOUR PARENTS OR GUARDIAN AND ASK QUESTIONS ABOUT THINGS YOU DO NOT UNDERSTAND.</div>
	<div class='terms_paragraph' id='terms_one'>
		<ol>
			<li>
				<h5>Agreement between You and Wayside Publishing</h5>
				<p>Welcome. Please read these Terms of Service (the "Terms") carefully before registering on or using the website provided by Wayside Publishing, Inc., a Maine corporation, or its parents, affiliates or subsidiaries (collectively, "Wayside Publishing" or "we") at <a href='http://learningsite.waysidepublishing.com'>learningsite.waysidepublishing.com</a> (the "Learning Site"). The term "you" (and "your") for purposes of these Terms, means both you in your individual capacity, and if applicable, the company or other legal entity whom you represent and on whose behalf you use the Service. YOUR REGISTRATION ON, OR USE OF, THE LEARNING SITE INDICATES THAT YOU ACCEPT THESE TERMS OF SERVICE. IF YOU DO NOT ACCEPT THESE TERMS OF SERVICE, PLEASE DO NOT USE OR REGISTER FOR USE OF THE LEARNING SITE. These terms and conditions apply to all users of the Learning Site and associated services.</p>
			</li>
			<li>
				<h5>Changes to these Terms of Service</h5>
				<p>Wayside Publishing reserves the right, in its sole discretion, to modify these Terms of Service, in whole or in part, at any time. Changes will be effective when notice of such change is posted to <a href='http://learningsite.waysidepublishing.com'>learningsite.waysidepublishing.com.</a> While we will endeavor to provide direct notice to you of any changes, you are responsible for periodically checking the Learning Site to determine if any changes have been made and we are not liable for your failure to do so or our failure to provide such direct notice to you. Your continued use of the Learning Site after any changes are posted will be considered acceptance of those changes. By using the Learning Site, you agree that you have reviewed, understand and accept these Terms of Service.</p>
			</li>
			<li>
				<h5>Use of the Learning Site</h5>
				<p>Wayside Publishing reserves the right, in its sole discretion, to modify these Terms of Service, in whole or in part, at any time. Changes will be effective when notice of such change is posted to <a href='http://learningsite.waysidepublishing.com'>learningsite.waysidepublishing.com.</a> While we will endeavor to provide direct notice to you of any changes, you are responsible for periodically checking the Learning Site to determine if any changes have been made and we are not liable for your failure to do so or our failure to provide such direct notice to you. Your continued use of the Learning Site after any changes are posted will be considered acceptance of those changes. By using the Learning Site, you agree that you have reviewed, understand and accept these Terms of Service.</p>
			</li>
			<li>
				<h5>Use of the Learning Site</h5>
				<p>Except as otherwise provided, Wayside Publishing gives you permission to use the Learning Site and the content of the Learning Site (the "Site Content") solely for your personal, non-commercial, use. The Site Content, including, without limitation, text, images, video, graphics, music and sound is protected by copyright, trademark and other laws. The Site Content is the property of Wayside Publishing and its suppliers and contributors. Without limiting the foregoing, Wayside Publishing owns a copyright in the selection, coordination, arrangement and enhancement of the Site Content, as well as in Wayside Publishing's original content. Unauthorized use of the Site Content is strictly prohibited. You may not copy, redistribute, alter, modify, publish, transmit, adapt, translate, prepare derivative works from, decompile, reverse engineer (except as expressly permitted by law), disassemble or in any way exploit the Site Content, or create or attempt to create a substitute or similar service or product through use of or access to the Learning Site. Solely in connection with the use of products purchased from Wayside Publishing, instructors may (i) download, (ii) display, and perform in the classroom, and (iii) reproduce as-is and distribute in printed form to students, in the classroom, certain Site Content, as identified on the Learning Site as materials connected to Wayside Publishing. Further, solely in connection with the use of products purchased from Wayside Publishing or an authorized distributor, instructors may modify certain Site Content, as identified on the Learning Site as downloadable in unlocked editable electronic form, and display or distribute, in printed form, such modified Site Content to students in the classroom. You will not remove, obscure, or alter Wayside Publishing's copyright notice, trade names, trademarks, service marks, logos, other distinctive brand features, or other proprietary rights notices affixed to or contained within the Learning Site or any Site Content. Without Wayside Publishing's express prior written permission, you will not frame any portion of the Learning Site or any of the Site Content or link to the Learning Site other than to complete pages hosted as part of the Learning Site. You will not distribute any of the Site Content in electronic form without Wayside Publishing's express prior written permission. You acknowledge that you do not acquire any ownership rights by downloading or modifying Site Content. We reserve the right, for any reason, to suspend or deny your access to all or any portion of the Learning Site or use of Site Content, including Site Content that you have modified.</p>
			</li>
			<li>
				<h5>Learning Site Modifications</h5>
				<p>Wayside Publishing reserves the right at any time to modify, suspend or discontinue the Learning Site or any part thereof and you agree that Wayside Publishing shall not be liable to you or to any third party for any such modification, suspension, or discontinuance. Without limiting the foregoing, you acknowledge and agree that Wayside Publishing may suspend, terminate or cancel your access rights to the Learning Site, or any part thereof, with or without notice, for any or no reason, without liability to you or any third party.</p>
			</li>
			<li>
				<h5>User-Submitted Content/Conduct</h5>
				<p>Portions of the Learning Site (such as "chat rooms", "blogs" or "forums") may allow users to upload and/or post content, including both academic-oriented and nonacademic-oriented content. You shall not upload or post on the Learning Site any content that is libelous, defamatory, obscene, threatening, invasive of privacy, harmful to minors in any way, abusive, illegal or harassing, or contains expressions of hatred, bigotry, racism or pornography, or is otherwise objectionable, or that would constitute or encourage a criminal offense, violate the rights of any party or violate any law, or that you do not have a right to make available under contractual or fiduciary relationship, or that is used to make commercial solicitations. Uploading or posting any such content may result in the immediate termination of your access to the Learning Site and, if appropriate, notification to law enforcement officials. If legal action is pursued any and all information collected by Wayside Publishing will be turned over to the appropriate law enforcement officials. This means that you, and not Wayside Publishing, are entirely responsible for the content you transmit to the Learning Site.</p>
				<p>You shall not upload to, distribute through or otherwise publish through the Learning Site any content that contains viruses or any other computer code, corrupt files or programs designed to interrupt, destroy or limit the functionality of the Learning Site or disrupt any software, hardware, telecommunications, networks, servers or other equipment. Uploading, distributing or publishing such content may result in immediate termination of your access to the Learning Site and, if appropriate, notification to law enforcement officials.</p>
				<p>Wayside Publishing has no obligation to screen information or content posted or submitted by you or other users for use in connection with the Learning Site, and content posted by users does not necessarily reflect the views of Wayside Publishing. However, Wayside Publishing shall have the right, in Wayside Publishing's sole discretion, to refuse to post, remove or edit any content submitted to Wayside Publishing or posted on the Learning Site. You agree that Wayside Publishing has no liability or responsibility for the storage, modification or deletion of any content that you or any other person uploads or posts.</p>
				<p>Except as expressly provided in these Terms of Service or as expressly authorized in writing by you, you retain all rights, title and interest in and to content submitted to Wayside Publishing through the Learning Site. Notwithstanding the foregoing, by submitting content to Wayside Publishing or the Learning Site, you: (i) acknowledge and agree that all content provided in connection with any course whether directly through Wayside Publishing or through your educational institution will be made available to school officials, including instructors, and other users with legitimate educational interests in such content; and (ii) automatically grant to Wayside Publishing a royalty-free, perpetual, irrevocable, non-exclusive right and license to use, copy, reproduce, modify, adapt, publish, translate, perform, display, make derivative works of and distribute such content (in whole or in part) on the Learning Site, any successor website or application, or other sites owned or operated by Wayside Publishing, or to other third-parties as authorized by your educational institution, including, without limitation, syntactic analysis and grading vendors. Wayside Publishing may delete, archive, make unavailable, modify or comment on any content submitted by you. You may allow Wayside Publishing to publicly share your content and/or to identify you with the content you have posted by providing express prior written permission to Wayside Publishing.</p>
				<p>You shall not upload, post or otherwise make available on the Learning Site any content protected by copyright, trademark or other proprietary right without the express permission of the owner of the copyright, trademark or other proprietary right and the burden of determining that any content is not so protected rests with you. You shall be solely liable for any damage resulting from any claims of infringement of copyrights or other proprietary rights, any claims by third parties regarding Wayside Publishing's exercise of the foregoing license and any other harm resulting from your submission(s) or Wayside Publishing's use or posting of such submission(s).</p>
			</li>
			<li>
				<h5>Prohibited Actions</h5>
				<p>You may not attempt to gain unauthorized access to any portion or feature of the Learning Site, any other systems or networks connected to the Learning Site, any Wayside Publishing server, or any of the Site Content or services offered on or through the Learning Site, by hacking, password "mining" or any other illegitimate means. You may not probe, scan or test the vulnerability of the Learning Site or any network connected to the Learning Site, nor breach the security or authentication measures on the Learning Site or any network connected to the Learning Site. You may not reverse look-up, trace or seek to trace any information on any other user of or visitor to the Learning Site, including any account not owned by you, to its source. Wayside Publishing reserves the right to report unsuccessful code redemption attempts or unauthorized use of the Learning Site and/or Site Content to appropriate school and law enforcement authorities. You may not exploit the Learning Site or any Site Content or services made available or offered by or through the Learning Site, in any way where the purpose is to reveal any information, including but not limited to personal identification or information, other than your own information, as provided for by the Learning Site. You agree that you will not take any action that intentionally imposes an unreasonable or disproportionately large load on the infrastructure of the Learning Site or Wayside Publishing's systems or networks, or any systems or networks connected to the Learning Site or to Wayside Publishing. You agree not to use any device, software or routine to interfere or attempt to interfere with the proper working of the Learning Site or with any other person's use of the Learning Site. You may not forge headers or otherwise manipulate identifiers in order to disguise the origin of any message or transmittal you send to Wayside Publishing on or through the Learning Site. You may not pretend that you are, or that you represent, someone else, or impersonate any other individual or entity. You may not access the Learning Site by using the login credentials of any other person without that person's permission. You acknowledge that your failure to abide by these Terms of Service may subject you to civil and criminal liability.</p>
			</li>
			<li>
				<h5>Your Representations, Warranties and Conduct</h5>
				<p>You represent and warrant that: (i) all of the information provided by you to Wayside Publishing is accurate; (ii) you have all necessary right, power, and authority to agree to these Terms of Service and to perform the acts required of you hereunder; (iii) you have read and agree to abide by these Terms of Service and the Wayside Publishing Privacy Policy; and (iv) you will not use the Learning Site for any unlawful purpose or in violation of any law or these Terms of Service or for any purpose not expressly permitted in these Terms of Service.</p>
			</li>
			<li>
				<h5>Password Protection</h5>
				<p>You are responsible for maintaining the confidentiality of all access codes and account information associated with the Learning Site (collectively, "Password(s)"), and are fully responsible for all activities that occur using your Password. You agree to immediately notify Wayside Publishing of any unauthorized use of your Password or any other breach of security of which you become aware.</p>
			</li>
			<li>
				<h5>Indemnity</h5>
				<p>You agree to indemnify, defend (at Wayside Publishing's option) and hold Wayside Publishing and its affiliates, officers, directors, representatives, agents, partners and employees (collectively, "Indemnified Person(s)") harmless from and against any and all claims, liabilities, losses, and expenses (including damage awards, settlement amounts, and reasonable legal fees), brought against any Indemnified Person, arising out of or related to your content and materials, your use of the Learning Site, your violation of these Terms of Service or your violation of any third party's rights including such party's copyrights and trademarks.</p>
			</li>
			<li>
				<h5>Disclaimer of Warranties</h5>
				<p>The Learning Site and related applications, materials and services are provided to you "AS IS" without warranty of any kind. WAYSIDE PUBLISHING HEREBY DISCLAIMS, TO THE MAXIMUM EXTENT PERMITTED BY LAW, ALL WARRANTIES EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS OF A PARTICULAR PURPOSE AND ANY WARRANTIES PERTAINING TO NONINFRINGEMENT, AVAILABILITY OF THE LEARNING SITE, LACK OF VIRUSES, WORMS, TROJAN HORSES, OR OTHER CODE THAT MANIFESTS CONTAMINATING OR DESTRUCTIVE PROPERTIES, ACCURACY, COMPLETENESS, RELIABILITY, TIMELINESS, CURRENCY, OR USEFULNESS OF ANY INFORMATION ON THE LEARNING SITE.</p>
			</li>
			<li>
				<h5>Assumption of Risks</h5>
				<p>Use of the Learning Site is at your sole risk. You assume all risks that the Learning Site, applications, and related information are suitable for your needs. Use of any applications obtained through the Learning Site is at your own discretion and risk and you are solely responsible for any damage to your computer or loss of data. You agree that Wayside Publishing shall not be responsible for any loss or damage of any sort relating to your dealings with any third party content provider on the Learning Site.</p>
			</li>
			<li>
				<h5>Disclaimer of Damages; Limitation of Liability</h5>
				<p>YOU AGREE THAT NEITHER WAYSIDE PUBLISHING NOR ANY OF ITS AFFILIATES OR AGENTS WILL BE LIABLE TO YOU OR ANY OTHER PERSON FOR ANY CONSEQUENTIAL OR INCIDENTAL DAMAGES (INCLUDING BUT NOT LIMITED TO LOST PROFITS OR LOSS OF PRIVACY) OR ANY INDIRECT, SPECIAL, OR PUNITIVE DAMAGES WHATSOEVER THAT ARISE OUT OF OR ARE RELATED TO THE LEARNING SITE OR TO ANY BREACH OF THESE TERMS OF SERVICE EVEN IF SUCH PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. IN NO EVENT WILL WAYSIDE PUBLISHING'S AGGREGATE LIABILITY IN CONNECTION WITH THE LEARNING SITE OR THESE TERMS OF SERVICE EXCEED $25, REGARDLESS OF THE CAUSE OF ACTION. THESE LIMITATIONS OF LIABILITY SHALL APPLY TO THE MAXIMUM EXTENT PERMITTED BY LAW, NOTWITHSTANDING ANY FAILURE OF ESSENTIAL PURPOSE OF ANY LIMITED REMEDY. Some states do not allow the exclusion or limitation of liability for consequential damages, so the above limitation may not apply to you.</p>
			</li>
			<li>
				<h5>Links to Third Party Websites</h5>
				<p>Wayside Publishing may, as a convenience, provide links to third party websites. The inclusion of the link does not imply that Wayside Publishing endorses those third party sites. Third party sites are not under Wayside Publishing's control and Wayside Publishing is not responsible for any content on any linked site. If you access a third party site from the Learning Site, you do so at your own risk.</p>
			</li>
			<li>
				<h5>Copyright Agent</h5>
				<p>If you believe that your copyrighted work is accessible on the Learning Site in a way that constitutes copyright infringement, please provide the following information to the agent identified below: (i) a physical or electronic signature of a person authorized to act on behalf of the owner of an exclusive right that is allegedly infringed; (ii) identification of the copyrighted work claimed to have been infringed, or, if multiple copyrighted works at a single online site are covered by a single notification, a representative list of such works at that site; (iii) identification of the material that is claimed to be infringing or to be the subject of infringing activity and that is to be removed or access to which is to be disabled, and information reasonably sufficient to permit Wayside Publishing to locate the material; (iv) information reasonably sufficient to permit Wayside Publishing to contact the complaining party, such as an address, telephone number, and, if available, an electronic mail address at which the complaining party may be contacted; (v) a statement that the complaining party has a good faith belief that use of the material in the manner complained of is not authorized by the copyright owner, its agent, or the law; and (vi) A statement that the information in the notification is accurate, and under penalty of perjury, that the complaining party is authorized to act on behalf of the owner of an exclusive right that is allegedly infringed.
				For copyright inquiries, please contact: <a href='mailto:support@waysidepublishing.com'>support@waysidepublishing.com</a></p>
			</li>
			<li>
				<h5>Governing Law; Venue</h5>
				<p>These Terms of Service shall be governed by and construed in accordance with the internal laws of the State of Maine, without regard to conflicts of law rules. Any dispute or claim arising out of or in connection with these Terms of Service shall be adjudicated in Portland, Maine.</p>
			</li>
			<li>
				<h5>Entire Agreement; Binding Effect</h5>
				<p>These Terms of Service constitute the entire agreement between you and Wayside Publishing relating to the subject matter hereof and supersede all prior oral and written understandings. These Terms of Service shall be binding upon and inure to the benefit of the parties hereto and their respective heirs, executors, administrators, legal representatives, successors and permitted assigns.</p>
			</li>
			<li>
				<h5>Waiver</h5>
				<p>No waiver of any provision of these Terms of Service or any breach hereunder shall be deemed a waiver of any other provision or subsequent breach, nor shall any such waiver constitute a continuing waiver.</p>
			</li>
			<li>
				<h5>Severability</h5>
				<p>If any part of these Terms of Service, or the application thereof to any person or circumstance, is for any reason held invalid or unenforceable, it shall be deemed severable and the validity of the remainder of these Terms of Service or the applications of such provision to other persons or circumstances shall not be affected thereby.</p>
			</li>
			<li>
				<h5>Violations</h5>
				<p>Please report any violations of these Terms of Service to Wayside Publishing at <a href='mailto:support@waysidepublishing.com'>support@waysidepublishing.com</a></p>
				<p>All rights not expressly granted herein are fully reserved.</p>
			</li>
		</ol> 	
	</div>
</div>
</div>
end;








