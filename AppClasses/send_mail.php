<?php
    require 'PHPMailer/PHPMailerAutoload.php';
    function sendMail($to,$subject="",$msg){
        $mail = new PHPMailer();
        $mail->IsSMTP(true);                                      // set mailer to use SMTP
        $mail->Host = "smtp.gmail.com";  // specify main and backup server
        $mail->Port = 587;
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = "portalquote0@gmail.com";  // SMTP username
        $mail->Password = "portalquote123"; // SMTP password
        $mail->From = "portalquote0@gmail.com";
        $mail->FromName = $subject;
        $mail->AddAddress($to);                  // name is optional
        //$mail->AddReplyTo("info@example.com", "Information");
        $mail->WordWrap = 50;                                 // set word wrap to 50 characters
        $mail->IsHTML(true);                                  // set email format to HTML
        $mail->Subject = "no-reply";
        $mail->Body    = $msg;
        //$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
        if(!$mail->Send())
        {
           return $mail->ErrorInfo;
        }else
            return true;
    }
?>