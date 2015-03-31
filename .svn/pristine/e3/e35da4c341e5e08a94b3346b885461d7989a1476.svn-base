<?php

include_once('/extensions/phpmailer/class.phpmailer.php');
include_once('/extensions/phpmailer/class.smtp.php');

function mailex($name, $from, $to, $subject, $body)
{
	$mail = new PHPMailer();
	
// 	debuglog($name);
// 	debuglog($from);
// 	debuglog($to);
// 	debuglog($subject);
// 	debuglog($body);
	
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "tls";
	$mail->Host = SANSSPACE_SMTP_HOST;
	$mail->Username = SANSSPACE_SMTP_USER;
	$mail->Password = SANSSPACE_SMTP_PASSWORD;
	
	$mail->From = $from;
	$mail->FromName = $name;
	$mail->AddAddress($to);
	$mail->AddReplyTo($from);
	
	$mail->WordWrap = 50;
	//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
	//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
	$mail->IsHTML(true);
	
	$mail->Subject = $subject;
	$mail->Body    = $body;

//	debuglog($mail);
	$sent = $mail->Send();
//	debuglog($sent);
}




