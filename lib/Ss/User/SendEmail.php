<?php
namespace Ss\User;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendEmail {
    private $mail;
    function __construct(){
        $this->mail = new PHPMailer(true);
    }

    function do($email,$subject,$body){
        global $mail_smtp_Server,$mail_smtp_Account,$mail_smtp_password,$mail_smtp_Secure,$mail_smtp_Port,$mail_smtp_Account;
        try {
            $mail->Charset='UTF-8';
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = $mail_smtp_Server;
            $mail->SMTPAuth = true;
            $mail->Username = $mail_smtp_Account;
            $mail->Password = $mail_smtp_password;
            $mail->SMTPSecure = $mail_smtp_Secure;
            $mail->Port = $mail_smtp_Port; 
            $mail->setFrom($mail_smtp_Account, $sender);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();
            return ture;
        } catch (Exception $e) {
            return false;
        }
    }
}