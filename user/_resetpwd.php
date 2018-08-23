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
$c = new \Ss\User\UserCheck();
$q = new \Ss\User\Query();
$a = [];
if($c->IsEmailUsed($email)){
    $uid = $q->GetUidByEmail($email);
    $rst = new \Ss\User\ResetPwd($uid);
    if($rst->IsAbleToReset()){
        $code = $rst->NewLog();
        //send
        try {
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
            $mail->Subject = $site_name."重置密码";
            $mail->Body    = '请访问此链接申请重置密码'.$site_url."user/resetpwd_do.php?code=".$code."&uid=".$uid;
            $mail->send();
            $a['code'] = '1';
            $a['ok'] = '1';
            $a['msg'] = "已经发送到邮箱";
        } catch (Exception $e) {
                $a['code'] = '0';
                $a['msg'] = "邮件发送失败";
        }
    }else{
        $a['code'] = '0';
        $a['msg']  =  "24小时内申请超过上限";
    }
}else{
    $a['code'] = '0';
    $a['msg']  =  "邮箱不存在";
}
echo json_encode($a);

