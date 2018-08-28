<?php
include_once 'lib/config.php';
setcookie("user_name", "", time()-3600,'/');
setcookie("user_pwd", "", time()-3600,'/');
setcookie("uid", "", time()-3600,'/');
setcookie("user_email", "", time()-3600,'/');
header("Location:\\");
exit;