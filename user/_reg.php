<?php
require_once '../lib/config.php';
$email = $_POST['email'];
$email = strtolower($email);
$passwd = $_POST['passwd'];
$repasswd = $_POST['repasswd'];
$agree = $_POST['agree'];
$code = strtoupper($_POST['code']);

$c = new \Ss\User\UserCheck();
// $code = new \Ss\User\InviteCode($code);
if(!$c->IsUserInviteKey($code)){
    $a['msg'] = "邀请码无效";
}elseif(!$c->IsEmailLegal($email)){
    $a['msg'] = "邮箱无效";
}elseif($c->IsEmailUsed($email)){
    $a['msg'] = "邮箱已被使用";
}elseif($repasswd != $passwd){
    $a['msg'] = "两次密码输入不符";
}elseif(strlen($passwd)<6){
    $a['msg'] = "密码太短";
}else{
    // get value
    $ref_by = $c->GetInviteKeyUser($code);
    $passwd = \Ss\User\Comm::SsPW($passwd);
    $plan = "A";
    $transfer = $a_transfer;
    $reg = new \Ss\User\Reg();
    if($reg->Reg($email,$passwd,$plan,$transfer,$ref_by)){
        $a['ok'] = '1';
        $a['msg'] = "注册成功";
        $oo = new Ss\User\Ss($ref_by);
        if($ref_by > 0) $oo->add_transfer($user_invite_get*$tomb);
    }else{
        $a['msg'] = "服务器繁忙请重试";
    }
}
echo json_encode($a);
