<?php
require_once '../lib/config.php';
require_once '_check.php';

//权限检查
if (!$oo->is_able_to_check_in()) {
	$transfer_to_add = 0;
} else {
	$oo->update_last_check_in_time();
	// if ($oo->unused_transfer() < 2048 * $tomb) {
	//     $transfer_to_add = rand(1024, 2048);
	// } else {
	$transfer_to_add = rand($check_min, $check_max);
	// }
	$U = new \Ss\User\UserInfo($uid);
	$c = $U->GetRefCount($uid);
	if ($c > 0) {
		$transfer_to_add += rand($check_min, $check_invite * $c);
	}
	$oo->add_transfer($transfer_to_add * $tomb);
	$ref_by = $U->GetRefBy();
	if ($ref_by) {
		$oo->add_transfer(rand($check_min* $tomb, $transfer_to_add * $tomb), $ref_by);
	}
}

$a['msg'] = "获得了" . $transfer_to_add . "MB流量";
echo json_encode($a);