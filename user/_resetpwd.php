<?php
//设置编码
header("content-type:text/html;charset=utf-8");
require_once '../lib/config.php';

$email    = $_GET['email'];
$c = new \Ss\User\UserCheck();
$q = new \Ss\User\Query();
$a = [];
if($c->IsEmailUsed($email)){
    $uid = $q->GetUidByEmail($email);
    $rst = new \Ss\User\ResetPwd($uid);
    if($rst->IsAbleToReset()){
        $code = $rst->NewLog();
        $mail = new \Ss\Etc\Mail();
        if($mail->sendBySmtp($email, $site_name."重置密码","请访问此链接<a href=\"".$site_url."user/resetpwd_do.php?code=".$code."&uid=".$uid."\">重置密码</a>")) {
            $a['code'] = '1';
            $a['ok'] = '1';
            $a['msg'] = "已经发送到邮箱";
        } else {
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

