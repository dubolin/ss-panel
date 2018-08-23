<?php
//设置编码
header("content-type:text/html;charset=utf-8");
require_once '../lib/config.php';
//mailgun
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);

$code     = $_POST['code'];
$email    = $_POST['email'];
$uid      = $_POST['uid'];
$password = $_POST['password'];
$repasswd = $_POST['repasswd'];
//
$ur = new \Ss\User\UserInfo($uid);
if($ur->GetEmail() == $email){
    $rs = '1';
}else{
    $rs = '0';
}
if(!$rs){
    $a['code'] = '0';
    $a['msg']  =  "邮箱错误";
}elseif($repasswd != $password){
    $a['code'] = '0';
    $a['msg'] = "两次密码输入不符";
}elseif(strlen($password)<6){
    $a['code'] = '0';
    $a['msg'] = "密码太短";
}else{
    $rst = new \Ss\User\ResetPwd($uid);
    $u   = new \Ss\User\User($uid);
    if($rst->IsCharOK($code,$uid)){
        $NewPwd = $password;
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
            $mail->Subject = $site_name." 提示：您的新密码重置成功！";
            $mail->Body    = "您在 ".date("Y-m-d H:i:s")." 重置了密码。";
            $mail->send();
        } catch (Exception $e) {
        }
        $u->UpdatePWd($NewPwd);
        $rst->Del($code,$uid);
        $a['code'] = '1';
        $a['ok'] = '1';
        $a['msg']  =  "您的新密码重置成功！";
    }else{
        $a['code'] = '0';
        $a['msg']  =  "链接无效";
    }
}
echo json_encode($a);
