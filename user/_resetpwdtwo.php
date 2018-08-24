<?php
//设置编码
header("content-type:text/html;charset=utf-8");
require_once '../lib/config.php';
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

        $mail = new \Ss\Etc\Mail();
        $mail->sendBySmtp($email, $site_name." 提示：您的新密已重置！","您在 ".date("Y-m-d H:i:s")." 重置了密码。");

        $u->UpdatePWd($NewPwd);
        $rst->Del($uid);
        $a['code'] = '1';
        $a['ok'] = '1';
        $a['msg']  =  "您的新密码重置成功！";
    }else{
        $a['code'] = '0';
        $a['msg']  =  "链接无效";
    }
}
echo json_encode($a);
