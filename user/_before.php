<?php
//设置编码
header("content-type:text/html;charset=utf-8");
require_once '../lib/config.php';
//mailgun
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);

$email    = $_GET['email'];
$email = strtolower($email);
$invite    = strtoupper($_GET['invite']);
$c = new \Ss\User\UserCheck();
$a = [];
if($c->IsEmailUsed($email)){
    $a['code'] = '0';
    $a['msg']  =  "邮箱已注册";
}elseif(!$c->IsUserInviteKey($invite)){
    $a['code'] = '0';
    $a['msg'] = "邀请码无效";
}else{
    $rst = new \Ss\User\EmailCheck($email);
    if($rst->IsAbleToRegister()){
        $code = $rst->NewLog();        //send
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
            $mail->Subject = $site_name."注册连接";
            $mail->Body    = '请访问此链接申请注册'.$site_url."user/register.php?invite=".$invite."&code=".$code."&email=".$email;
            $mail->send();
            $a['code'] = '1';
            $a['ok'] = '1';
            $a['msg'] = "注册连接已经发送到邮箱";
        } catch (Exception $e) {
            $a['code'] = '0';
            $a['msg'] = "邮件发送失败";
        }
    }else{
        $a['code'] = '0';
        $a['msg']  =  "24小时内申请超过上限";
    }
}
echo json_encode($a);

