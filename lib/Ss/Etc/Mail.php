<?php

namespace Ss\Etc;
require_once '../vendor/autoload.php';
use Mailgun\Mailgun;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail {
	private $mail;
	function __construct() {
		$this->mail = new PHPMailer(true);
	}

	function send($email, $subject, $body) {
		global $Selectmailservice;
		switch ($Selectmailservice) {
		case 'mail-gun':
			$this->sendByMailgun($email, $subject, $body);
			break;
		case 'mail-smtp':
			$this->sendBySmtp($email, $subject, $body);
			break;
		default:
			break;
		}
	}

	function sendByMailgun($email, $subject, $body) {
		global $mailgun_key, $mailgun_domain;
		$mg = new Mailgun($mailgun_key);
		$mg->sendMessage($mailgun_domain, array('from' => "no-reply@" . $mailgun_domain,
			'to' => $email,
			'subject' => $subject,
			'text' => $body)
		);
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