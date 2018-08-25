<?php

namespace Ss\Etc;
require_once '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Mail {
    private $mail;
    function __construct() {
		$this->mail = new PHPMailer(true);
	}

	function send($email, $subject, $body) {
		global $Selectmailservice;
		switch ($Selectmailservice) {
			case 'mail-gun':
				# code...
				break;
			case 'mail-smtp':
				# code...
				break;
			
			default:
				# code...
				break;
		}

	}

	function sendByMailgun($email, $subject, $body) {

	}

	function sendBySmtp($email, $subject, $body) {
		global $mail_smtp_Server, $mail_smtp_Account, $mail_smtp_password, $mail_smtp_Secure, $mail_smtp_Port, $mail_smtp_Account, $mail_smtp_Sender;
		// $mail = new MailSmtp();
		// $mail->setFrom($this->sender); //设置发件人
		// $mail->setReceiver("xxxx@gmail.com"); //设置收件人，多个收件人，调用多次
		//$mail->addAttachment("XXXX"); //添加附件，多个附件，调用多次
		// $mail->setMail("test主题", "test内容"); //设置邮件主题、内容 支持发送纯文本邮件和HTML格式的邮件
		// $mail->sendMail(); //发送
		try {
			$this->mail->CharSet = 'utf-8';
			$this->mail->SMTPDebug = 0;
			$this->mail->isSMTP();
			$this->mail->Host = $mail_smtp_Server;
			$this->mail->SMTPAuth = true;
			$this->mail->Username = $mail_smtp_Account;
			$this->mail->Password = $mail_smtp_password;
			$this->mail->SMTPSecure = $mail_smtp_Secure;
			$this->mail->Port = $mail_smtp_Port;
			$this->mail->setFrom($mail_smtp_Account, $mail_smtp_Sender);
			$this->mail->addAddress($email);
			$this->mail->isHTML(true);
			$this->mail->Subject = $subject;
            $this->mail->Body = $body;
			// $this->mail->MsgHTML = $body;
			$this->mail->send();
			return ture;
		} catch (Exception $e) {
			return false;
		}
	}

}