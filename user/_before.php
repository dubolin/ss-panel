<?php
//设置编码
header("content-type:text/html;charset=utf-8");
require_once '../lib/config.php';
//mailgun
require '../vendor/autoload.php';

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
        $code = $rst->NewLog();
        $mail = new \Ss\Etc\Mail();
        if($mail->sendBySmtp($email, $site_name."注册连接","请访问此链接<a href=\"".$site_url."user/register.php?invite=".$invite."&code=".$code."&email=".$email."\">申请注册</a>")) {
            $a['code'] = '1';
            $a['ok'] = '1';
            $a['msg'] = "注册连接已经发送到邮箱";
        } else {
            $a['code'] = '0';
            $a['msg'] = "邮件发送失败";
        }
    }else{
        $a['code'] = '0';
        $a['msg']  =  "24小时内申请超过上限";
    }
}
echo json_encode($a);

