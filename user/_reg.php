<?php
require_once '../lib/config.php';
$email = $_POST['email'];
$email = strtolower($email);
$passwd = $_POST['passwd'];
$repasswd = $_POST['repasswd'];
$emailcode = $_POST['emailcode'];
$code = strtoupper($_POST['code']);

$c = new \Ss\User\UserCheck();
$rst = new \Ss\User\EmailCheck($email);
if(!$rst->IsCharOK($emailcode,$email)){
    $a['url'] = '/user/before.php';
    $a['msg'] = "邮箱验证无效";
}elseif(!$c->IsUserInviteKey($code)){
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

        $mail = new \Ss\Etc\Mail();
        $mail->sendBySmtp($email, $site_name."注册成功","感谢您的注册".$site_url."<br/>邀请朋友注册可获得".$user_invite_get."M流量<br/>邀请越多每日签到获得更多流量<br/>朋友签到您同时获得额外流量<br/>:)在个人中心->邀请好友:查看您的“邀请码”<br/>生活，被友情沁润，有滋有味，开心不已；人生，被情谊包裹，美仑美奂，甜蜜幸福；日子，被朋友问候，心窝暖暖，心情舒畅。朋友，唯愿你快乐每分每秒，幸福每时每刻。 ");
    }else{
        $a['msg'] = "服务器繁忙请重试";
    }
}
echo json_encode($a);
