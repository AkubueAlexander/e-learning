<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



function send_email($to,$subject,$fullName,$body,$maill){
    //   require 'phpmailer/vendor/autoload.php';
        $mail = $maill;       
        
    try {        
            $mail->isSMTP();
            
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

            $mail->Host = gethostname();  
          
            $mail->Port = 587;
            
            $mail->SMTPSecure = 'tls';

            $mail->SMTPAuth = true;

           $mail->Username = 'no-reply@starnetweb.com';

            $mail->Password = 'TC,E!AY-cfh(';

            $mail->setFrom('no-reply@starnetweb.com','Starnet');
            $mail->addAddress($to, $fullName);     //Add a recipient 
            
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            $mail->send(); 

           
             
    
    } 
    catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}








?>